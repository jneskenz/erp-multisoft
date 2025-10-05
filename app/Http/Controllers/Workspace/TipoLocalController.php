<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Models\Workspace\TipoLocal;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TipoLocalController extends Controller
{
    public function index()
    {
        $tipoLocales = TipoLocal::all();
        return response()->json($tipoLocales);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100|unique:tipo_locales,nombre',
            'descripcion' => 'nullable|string',
            'estado' => 'boolean|required',
        ]);

        $tipoLocal = TipoLocal::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'estado' => $request->estado ?? true
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tipo de local creado exitosamente',
            'data' => $tipoLocal
        ]);
    }

    public function show(TipoLocal $tipoLocal)
    {
        return response()->json($tipoLocal);
    }

    public function update(Request $request, TipoLocal $tipoLocal)
    {
        $request->validate([
            'nombre' => ['required', 'string', 'max:100', Rule::unique('tipo_locales', 'nombre')->ignore($tipoLocal->id)],
            'descripcion' => 'nullable|string',
            'estado' => 'boolean'
        ]);

        // Verificar si se está desactivando un tipo que tiene locales asociados
        $estadoAnterior = $tipoLocal->estado;
        $nuevoEstado = $request->estado ?? true;
        
        if ($estadoAnterior && !$nuevoEstado) {
            $localesAsociados = $tipoLocal->locales()->count();
            if ($localesAsociados > 0) {
                return response()->json([
                    'success' => true,
                    'message' => "Tipo de local actualizado exitosamente.\n\nNOTA: Este tipo tiene {$localesAsociados} local(es) asociado(s). Los locales existentes mantendrán su configuración, pero este tipo ya no estará disponible para nuevos registros.",
                    'data' => $tipoLocal,
                    'warning' => true
                ]);
            }
        }

        $tipoLocal->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'estado' => $nuevoEstado
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Tipo de local actualizado exitosamente',
            'data' => $tipoLocal
        ]);
    }

    public function destroy(TipoLocal $tipoLocal)
    {
        if ($tipoLocal->locales()->count() > 0) {
            return response()->json([
                'success' => false,
                'message' => 'No se puede eliminar el tipo de local porque tiene locales asociados'
            ], 422);
        }

        $tipoLocal->delete();

        return response()->json([
            'success' => true,
            'message' => 'Tipo de local eliminado exitosamente'
        ]);
    }
}
