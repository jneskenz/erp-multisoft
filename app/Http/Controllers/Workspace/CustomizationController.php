<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Models\UserCustomization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class CustomizationController extends BaseWorkspaceController
{
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Mostrar la página de personalización
     */
    public function index()
    {

        Log::alert('Customization index accessed by user ID: ' . Auth::id());

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
        
        $grupoActual = $this->getGrupoEmpresarial();

        // Log::info('Rendering customization view', [
        //     'user_id' => $user->id,
        //     'grupo_id' => $grupoActual->id,
        //     'slug' => $grupoActual->slug
        // ]);

        return view('apps.workspace.customization.index', compact('customization', 'dataBreadcrumb', 'grupoActual'));
    }

    /**
     * Actualizar la personalización del usuario
     */
    public function update(Request $request)
    {
        try {
            Log::info('Customization update started', [
                'request_data' => $request->except(['avatar']),
                'has_file' => $request->hasFile('avatar'),
                'file_info' => $request->hasFile('avatar') ? [
                    'name' => $request->file('avatar')->getClientOriginalName(),
                    'size' => $request->file('avatar')->getSize(),
                    'mime' => $request->file('avatar')->getMimeType()
                ] : null
            ]);
            
            $request->validate([
                'theme_mode' => 'required|in:light,dark,system',
                'theme_color' => 'required|in:default,cyan,purple,orange,red,green,dark,custom',
                'font_family' => 'required|in:inter,roboto,poppins,open_sans,lato',
                'font_size' => 'required|in:small,medium,large',
                'layout_type' => 'required|in:vertical,horizontal',
                'layout_container' => 'required|in:fluid,boxed,detached',
                'navbar_type' => 'required|in:fixed,static,hidden',
                'navbar_blur' => 'nullable|in:0,1',
                'sidebar_collapsed' => 'nullable|in:0,1',
                // Validación para avatar del grupo empresarial (5MB max, incluyendo SVG)
                'avatar' => 'nullable|file|mimes:jpeg,png,jpg,gif,svg|max:5120',
                'remove_avatar' => 'nullable|boolean',
            ]);

            $user = Auth::user();
            $customization = $user->getCustomization();
            
            // Obtener el grupo empresarial actual
            $grupoEmpresarial = $request->attributes->get('grupoActual');

            // Preparar datos para actualizar, convirtiendo strings a boolean donde sea necesario
            $data = $request->all();
            
            // Convertir valores checkbox a boolean
            if (isset($data['navbar_blur'])) {
                $data['navbar_blur'] = $data['navbar_blur'] == '1';
            }
            if (isset($data['sidebar_collapsed'])) {
                $data['sidebar_collapsed'] = $data['sidebar_collapsed'] == '1';
            }

            // Manejar avatar del grupo empresarial
            if ($grupoEmpresarial) {
                // Si se solicita eliminar el avatar
                if ($request->has('remove_avatar') && $request->remove_avatar) {
                    if ($grupoEmpresarial->avatar) {
                        $this->deleteAvatarSafely($grupoEmpresarial->avatar, $grupoEmpresarial->id);
                        $grupoEmpresarial->update(['avatar' => null]);
                        Log::info('Avatar del grupo eliminado', ['grupo_id' => $grupoEmpresarial->id]);
                    }
                }
                // Si se sube un nuevo avatar
                elseif ($request->hasFile('avatar')) {
                    $avatarFile = $request->file('avatar');
                    
                    Log::info('Iniciando subida de avatar', [
                        'grupo_id' => $grupoEmpresarial->id,
                        'original_name' => $avatarFile->getClientOriginalName(),
                        'mime_type' => $avatarFile->getMimeType(),
                        'size' => $avatarFile->getSize()
                    ]);
                    
                    // Verificar que el archivo es válido
                    if (!$avatarFile->isValid()) {
                        Log::error('Archivo de avatar no válido', [
                            'grupo_id' => $grupoEmpresarial->id,
                            'error' => $avatarFile->getErrorMessage()
                        ]);
                        throw new \Exception('El archivo subido no es válido: ' . $avatarFile->getErrorMessage());
                    }
                    
                    // Eliminar avatar anterior si existe
                    if ($grupoEmpresarial->avatar) {
                        $this->deleteAvatarSafely($grupoEmpresarial->avatar, $grupoEmpresarial->id);
                    }
                    
                    // Generar nombre único para el archivo
                    $extension = $avatarFile->getClientOriginalExtension();
                    
                    // Si no hay extensión, obtenerla del mime type
                    if (empty($extension)) {
                        $mimeType = $avatarFile->getMimeType();
                        $extension = match($mimeType) {
                            'image/jpeg' => 'jpg',
                            'image/png' => 'png',
                            'image/gif' => 'gif',
                            'image/webp' => 'webp',
                            'image/svg+xml' => 'svg',
                            default => 'jpg'
                        };
                    }
                    
                    $fileName = 'avatars/grupos/' . $grupoEmpresarial->id . '_' . time() . '.' . $extension;
                    
                    Log::info('Nombre de archivo generado', [
                        'grupo_id' => $grupoEmpresarial->id,
                        'file_name' => $fileName,
                        'extension' => $extension,
                        'original_extension' => $avatarFile->getClientOriginalExtension()
                    ]);
                    
                    try {
                        // Verificar que el nombre del archivo no esté vacío
                        if (empty($fileName) || !str_contains($fileName, '.')) {
                            throw new \Exception('Nombre de archivo inválido: ' . $fileName);
                        }
                        
                        // Método alternativo: usar move en lugar de storeAs
                        $destinationPath = storage_path('app/public/' . $fileName);
                        $destinationDir = dirname($destinationPath);
                        
                        // Crear directorio si no existe
                        if (!is_dir($destinationDir)) {
                            mkdir($destinationDir, 0755, true);
                        }
                        
                        // Mover archivo
                        if ($avatarFile->move($destinationDir, basename($fileName))) {
                            $avatarPath = $fileName; // Guardar solo el path relativo
                            
                            Log::info('Archivo movido exitosamente usando move()', [
                                'grupo_id' => $grupoEmpresarial->id,
                                'destination_path' => $destinationPath,
                                'file_name' => $fileName
                            ]);
                        } else {
                            throw new \Exception('No se pudo mover el archivo al destino');
                        }
                        
                        if (!$avatarPath) {
                            throw new \Exception('No se pudo guardar el archivo en storage');
                        }
                        
                        Log::info('Archivo guardado en storage', [
                            'grupo_id' => $grupoEmpresarial->id,
                            'storage_path' => $avatarPath,
                            'file_name' => $fileName
                        ]);
                        
                        // Actualizar registro en base de datos
                        $grupoEmpresarial->update(['avatar' => $fileName]);
                        
                        Log::info('Avatar del grupo actualizado', [
                            'grupo_id' => $grupoEmpresarial->id,
                            'path' => $fileName
                        ]);
                        
                    } catch (\Exception $e) {
                        Log::error('Error al guardar avatar', [
                            'grupo_id' => $grupoEmpresarial->id,
                            'error' => $e->getMessage(),
                            'file_name' => $fileName
                        ]);
                        throw new \Exception('Error al guardar avatar: ' . $e->getMessage());
                    }
                }
            }

            // Actualizar personalización del usuario (sin datos del avatar)
            unset($data['avatar'], $data['remove_avatar']);
            $customization->update($data);

            Log::info('Customization updated successfully');

            return response()->json([
                'success' => true,
                'message' => 'Configuración actualizada correctamente',
                'data' => $customization,
                'avatar_updated' => $request->hasFile('avatar') || $request->has('remove_avatar')
            ]);
            
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation error in customization update', ['errors' => $e->errors()]);
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
            
        } catch (\Exception $e) {
            Log::error('Error in customization update', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return response()->json([
                'success' => false,
                'message' => 'Error interno del servidor: ' . $e->getMessage()
            ], 500);
        }
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

    /**
     * Eliminar avatar de manera segura
     */
    private function deleteAvatarSafely($avatarPath, $grupoId = null)
    {
        try {
            // Validar que el path no esté vacío
            if (empty($avatarPath) || empty(trim($avatarPath))) {
                Log::warning('Intento de eliminar avatar con path vacío', [
                    'grupo_id' => $grupoId,
                    'avatar_path' => $avatarPath
                ]);
                return false;
            }

            // Verificar que el archivo existe
            if (!Storage::exists($avatarPath)) {
                Log::warning('Archivo de avatar no encontrado', [
                    'grupo_id' => $grupoId,
                    'avatar_path' => $avatarPath
                ]);
                return false;
            }

            // Eliminar el archivo
            $deleted = Storage::delete($avatarPath);
            
            if ($deleted) {
                Log::info('Avatar eliminado exitosamente', [
                    'grupo_id' => $grupoId,
                    'avatar_path' => $avatarPath
                ]);
            } else {
                Log::error('Falló la eliminación del avatar', [
                    'grupo_id' => $grupoId,
                    'avatar_path' => $avatarPath
                ]);
            }

            return $deleted;
            
        } catch (\Exception $e) {
            Log::error('Error al eliminar avatar', [
                'grupo_id' => $grupoId,
                'avatar_path' => $avatarPath,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }
}
