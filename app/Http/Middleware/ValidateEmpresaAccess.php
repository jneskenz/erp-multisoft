<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use App\Models\Admin\GrupoEmpresarial;
use App\Models\Erp\Empresa;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware de Validación de Acceso a Empresa
 * 
 * Fecha de creación: 3 de octubre de 2025
 * 
 * Este middleware se encarga de:
 * 1. Validar que el usuario tenga acceso a la empresa especificada en la URL
 * 2. Verificar que la empresa pertenezca al grupo empresarial correcto
 * 3. Compartir variables de contexto con las vistas
 * 4. Gestionar el acceso de super administradores
 * 
 * Patrón de URL: /{grupo}/{empresa}/{módulo}
 * Ejemplo: /demo/alpha/ventas
 */
class ValidateEmpresaAccess
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
            return redirect()->route('login')->with('error', 'Debe iniciar sesión para acceder al ERP');
        }

        $user = Auth::user();
        
        // 2. Extraer parámetros de la URL
        $grupoSlug = $request->route('grupo');
        $empresaSlug = $request->route('empresa');

        // 3. Buscar el grupo empresarial por código
        $grupoEmpresarial = GrupoEmpresarial::where('slug', $grupoSlug)->first();
        if (!$grupoEmpresarial) {
            abort(404, 'Grupo empresarial no encontrado');
        }
        
        // 4. Buscar la empresa dentro del grupo
        $empresa = Empresa::where('slug', $empresaSlug)
                          ->where('grupo_empresarial_id', $grupoEmpresarial->id)
                          ->first();
        
        if (!$empresa) {
            abort(404, 'Empresa no encontrada en este grupo');
        }
        
        // 5. Validar acceso del usuario (super admin tiene acceso total)
        if (!$user->hasRole('super_admin')) {
            // Verificar que el usuario pertenezca al grupo empresarial
            if ($user->grupo_empresarial_id !== $grupoEmpresarial->id) {
                abort(403, 'No tiene acceso a este grupo empresarial');
            }
            
            // Verificar que el usuario tenga acceso a esta empresa específica
            if ($user->empresa_id !== $empresa->id) {
                abort(403, 'No tiene acceso a esta empresa');
            }
        }
        
        // 6. Establecer atributos en el request para uso en controllers
        $request->attributes->set('grupoActual', $grupoEmpresarial);
        $request->attributes->set('empresaActual', $empresa);
        
        // 7. Compartir variables con todas las vistas del ERP
        View::share('grupoActual', $grupoEmpresarial);
        View::share('empresaActual', $empresa);
        
        return $next($request);
    }
}