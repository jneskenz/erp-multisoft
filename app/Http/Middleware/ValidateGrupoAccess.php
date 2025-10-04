<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Log;
use App\Models\Admin\GrupoEmpresarial;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de Validación de Acceso a Grupo Empresa
 * 
 * Fecha de creación: 4 de octubre de 2025
 * 
 * Este middleware se encarga de:
 * 1. Validar que el usuario tenga acceso al grupo empresarial especificado en la URL
 * 3. Compartir variables de contexto con las vistas
 * 4. Gestionar el acceso de super administradores
 * 
 * Patrón de URL: /{grupo}/
 * Ejemplo: /demo/
 */
class ValidateGrupoAccess
{
    /**
     * Maneja la solicitud entrante y valida el acceso a la empresa
     * 
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Verificar que el usuario esté autenticado
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Debe iniciar sesión para acceder al módulo');
        }

        $user = Auth::user();
        
        // 2. Extraer parámetros de la URL
        $grupoSlug = $request->route('grupoempresa'); // Cambiado de 'grupo' a 'grupoempresa'

        // 3. Buscar el grupo empresarial por slug o id
        $grupoEmpresarial = GrupoEmpresarial::where('slug', $grupoSlug)
            ->orWhere('id', $grupoSlug)
            ->first();
            
        if (!$grupoEmpresarial) {
            abort(404, 'Grupo empresarial no encontrado');
        }        
        
        // 4. Validar acceso del usuario (super admin tiene acceso total)
        if ($user->isSuperAdmin()) {
            // Verificar que el usuario pertenezca al grupo empresarial (solo usuarios normales)
            $userGrupos = $user->gruposEmpresariales()->pluck('id')->toArray();
            
            if (!in_array($grupoEmpresarial->id, $userGrupos)) {
                abort(403, 'No tiene acceso a este grupo empresarial');
            }
        }
        
        // 6. Establecer atributos en el request para uso en controllers
        $request->attributes->set('grupoActual', $grupoEmpresarial);
        
        // 7. Compartir variables con todas las vistas del ERP
        View::share('grupoActual', $grupoEmpresarial);
        
        return $next($request);
    }
}