<?php

namespace App\Http\Controllers\Erp;

/**
 * Controlador del Dashboard Principal del ERP
 * 
 * Fecha de creación: 3 de octubre de 2025
 * 
 * Este controlador maneja la página principal del ERP para cada empresa:
 * 1. Estadísticas generales de la empresa
 * 2. Resumen de ventas y compras
 * 3. Alertas y notificaciones importantes
 * 4. Gráficos y métricas clave de rendimiento
 */
class DashboardController extends BaseErpController
{
    /**
     * Mostrar el dashboard principal de la empresa
     * 
     * Fecha: 3 de octubre de 2025
     * 
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $empresaActual = $this->getEmpresaActual();
        $grupoActual = $this->getGrupoEmpresarial();
        
        // TODO: Implementar métricas reales
        $metricas = [
            'ventas_mes' => 0,
            'compras_mes' => 0,
            'clientes_activos' => 0,
            'productos_stock_bajo' => 0,
        ];
        
        return view('erp.dashboard.index', compact(
            'empresaActual',
            'grupoActual',
            'metricas'
        ));
    }
}