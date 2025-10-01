<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserCustomization;
use Illuminate\Support\Facades\Auth;

class CustomizationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Mostrar la página de personalización
     */
    public function index()
    {
        $user = Auth::user();
        $customization = $user->getCustomization();
        
        $dataBreadcrumb = [
            'title' => 'Personalización',
            'description' => 'Configura la apariencia del sistema según tus preferencias',
            'icon' => 'ti ti-palette',
            'breadcrumbs' => [
                ['name' => 'Config. del sistema', 'url' => route('home')],
                ['name' => 'Personalización', 'url' => 'javascript:void(0);', 'active' => true],
            ],
            'stats' => [
                [
                    'name' => 'Tema Actual',
                    'value' => ucfirst($customization->theme_mode),
                    'icon' => 'ti ti-sun',
                    'color' => 'bg-label-primary',
                ],
                [
                    'name' => 'Layout',
                    'value' => ucfirst($customization->layout_type),
                    'icon' => 'ti ti-layout-dashboard',
                    'color' => 'bg-label-success',
                ],
            ],
        ];

        $dataHeaderCard = [
            'title' => 'Configuración de Personalización',
            'description' => 'Ajusta la apariencia del sistema',
            'textColor' => 'text-primary',
            'icon' => 'ti ti-palette',
            'iconColor' => 'bg-label-primary',
            'actions' => [
                [
                    'typeAction' => 'btnIdEvent',
                    'name' => 'Restablecer',
                    'url' => '#',
                    'icon' => 'ti ti-refresh',
                    'permission' => null,
                    'typeButton' => 'btn-label-warning',
                    'id' => 'reset-header-btn',
                ],
            ],
        ];

        return view('customization.index', compact('customization', 'dataBreadcrumb', 'dataHeaderCard'));
    }

    /**
     * Actualizar la personalización del usuario
     */
    public function update(Request $request)
    {
        $request->validate([
            'theme_mode' => 'required|in:light,dark,system',
            'theme_color' => 'required|in:default,cyan,purple,orange,red,green,dark,custom',
            'custom_color' => 'nullable|string|regex:/^#[0-9A-Fa-f]{6}$/',
            'font_family' => 'required|in:inter,roboto,poppins,open_sans,lato',
            'font_size' => 'required|in:small,medium,large',
            'layout_type' => 'required|in:vertical,horizontal',
            'layout_container' => 'required|in:fluid,boxed,detached',
            'navbar_type' => 'required|in:fixed,static,hidden',
            'navbar_blur' => 'boolean',
            'sidebar_type' => 'required|in:fixed,static,hidden',
            'sidebar_collapsed' => 'boolean',
            'rtl_mode' => 'boolean',
        ]);

        $user = Auth::user();
        $customization = $user->getCustomization();

        $customization->update($request->all());

        return response()->json([
            'success' => true,
            'message' => 'Configuración actualizada correctamente',
            'data' => $customization
        ]);
    }

    /**
     * Restablecer configuración a valores por defecto
     */
    public function reset()
    {
        $user = Auth::user();
        $customization = $user->getCustomization();

        $customization->update(UserCustomization::getDefaults());

        return response()->json([
            'success' => true,
            'message' => 'Configuración restablecida a valores por defecto',
            'data' => $customization
        ]);
    }

    /**
     * Obtener la configuración actual (API)
     */
    public function getSettings()
    {
        $user = Auth::user();
        $customization = $user->getCustomization();

        return response()->json([
            'success' => true,
            'data' => $customization
        ]);
    }
}
