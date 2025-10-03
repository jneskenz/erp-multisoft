<?php

namespace App\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Models\Admin\GrupoEmpresarial;
use App\Models\Erp\Empresa;
use Illuminate\Support\Facades\Auth;

/**
 * Controlador Base del ERP Multi-Empresa
 * 
 * Fecha de creación: 3 de octubre de 2025
 * 
 * Este controlador base proporciona funcionalidad común para todos los módulos del ERP:
 * 1. Aplicación automática del middleware de validación de empresa
 * 2. Acceso fácil al contexto de empresa y grupo empresarial
 * 3. Métodos helper para obtener la empresa y grupo actual
 * 
 * Todos los controladores del ERP deben extender de esta clase base.
 */
abstract class BaseErpController extends Controller
{
    /**
     * Empresa actual obtenida del contexto de la URL
     */
    protected ?Empresa $empresa = null;
    
    /**
     * Grupo empresarial actual obtenido del contexto de la URL
     */
    protected ?GrupoEmpresarial $grupoEmpresarial = null;

    /**
     * Constructor que aplica middleware y establece el contexto
     */
    public function __construct()
    {
        // Aplicar middleware de validación de empresa a todas las rutas
        $this->middleware('empresa.access');
        
        // Middleware que extrae el contexto de empresa después de la validación
        $this->middleware(function ($request, $next) {
            // Obtener empresa y grupo desde los atributos del request
            // Estos son establecidos por el middleware ValidateEmpresaAccess
            $this->empresa = $request->attributes->get('empresaActual');
            $this->grupoEmpresarial = $request->attributes->get('grupoActual');
            
            return $next($request);
        });
    }

    /**
     * Obtener la empresa actual desde el contexto
     * 
     * @return Empresa|null La empresa actual o null si no está disponible
     */
    protected function getEmpresaActual(): ?Empresa
    {
        return $this->empresa;
    }

    /**
     * Obtener el grupo empresarial actual desde el contexto
     * 
     * @return GrupoEmpresarial|null El grupo empresarial actual o null si no está disponible
     */
    protected function getGrupoEmpresarial(): ?GrupoEmpresarial
    {
        return $this->grupoEmpresarial;
    }

    /**
     * Verificar si el usuario actual tiene acceso de super admin
     * 
     * @return bool True si es super admin, false en caso contrario
     */
    protected function isSuperAdmin(): bool
    {
        return Auth::user()->hasRole('super_admin');
    }

    /**
     * Obtener el código del grupo empresarial actual
     * 
     * @return string|null El código del grupo o null si no está disponible
     */
    protected function getGrupoCodigo(): ?string
    {
        return $this->grupoEmpresarial?->codigo;
    }

    /**
     * Obtener el código de la empresa actual
     * 
     * @return string|null El código de la empresa o null si no está disponible
     */
    protected function getEmpresaCodigo(): ?string
    {
        return $this->empresa?->codigo;
    }
}