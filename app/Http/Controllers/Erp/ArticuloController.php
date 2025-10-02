<?php

namespace App\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Models\Erp\Articulo;
use App\Http\Requests\Erp\ArticuloRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticuloController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('can:articulos.view')->only('index', 'show');
        $this->middleware('can:articulos.create')->only('create', 'store');
        $this->middleware('can:articulos.edit')->only('edit', 'update');
        $this->middleware('can:articulos.delete')->only('destroy');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('erp.articulos.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('erp.articulos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticuloRequest $request)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            
            // Generar código si no se proporciona
            if (empty($data['codigo'])) {
                $data['codigo'] = $this->generarCodigo();
            }

            // Manejar imagen si se sube
            if ($request->hasFile('imagen')) {
                $data['imagen'] = $this->subirImagen($request->file('imagen'));
            }

            // Procesar especificaciones
            if ($request->filled('especificaciones_json')) {
                $data['especificaciones'] = json_decode($request->especificaciones_json, true);
            }

            $articulo = Articulo::create($data);

            DB::commit();

            return redirect()->route('articulos.index')
                ->with('success', 'Artículo creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Eliminar imagen si se subió
            if (isset($data['imagen'])) {
                Storage::disk('public')->delete($data['imagen']);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el artículo: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Articulo $articulo)
    {
        return view('erp.articulos.show', compact('articulo'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Articulo $articulo)
    {
        return view('erp.articulos.edit', compact('articulo'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ArticuloRequest $request, Articulo $articulo)
    {
        try {
            DB::beginTransaction();

            $data = $request->validated();
            $imagenAnterior = $articulo->imagen;

            // Manejar imagen si se sube nueva
            if ($request->hasFile('imagen')) {
                $data['imagen'] = $this->subirImagen($request->file('imagen'));
                
                // Eliminar imagen anterior
                if ($imagenAnterior) {
                    Storage::disk('public')->delete($imagenAnterior);
                }
            }

            // Procesar especificaciones
            if ($request->filled('especificaciones_json')) {
                $data['especificaciones'] = json_decode($request->especificaciones_json, true);
            }

            $articulo->update($data);

            DB::commit();

            return redirect()->route('articulos.index')
                ->with('success', 'Artículo actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            
            // Eliminar nueva imagen si se subió
            if (isset($data['imagen']) && $data['imagen'] !== $imagenAnterior) {
                Storage::disk('public')->delete($data['imagen']);
            }

            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el artículo: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Articulo $articulo)
    {
        try {
            $articulo->delete();

            return redirect()->route('articulos.index')
                ->with('success', 'Artículo eliminado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el artículo: ' . $e->getMessage());
        }
    }

    /**
     * Toggle article status
     */
    public function toggleStatus(Articulo $articulo)
    {
        try {
            $articulo->update(['estado' => !$articulo->estado]);

            $estado = $articulo->estado ? 'activado' : 'desactivado';
            
            return response()->json([
                'success' => true,
                'message' => "Artículo {$estado} exitosamente.",
                'estado' => $articulo->estado
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al cambiar el estado del artículo.'
            ], 500);
        }
    }

    /**
     * Generar código único para el artículo
     */
    private function generarCodigo()
    {
        do {
            $codigo = 'ART-' . Str::upper(Str::random(6));
        } while (Articulo::where('codigo', $codigo)->exists());

        return $codigo;
    }

    /**
     * Subir imagen del artículo
     */
    private function subirImagen($archivo)
    {
        $nombreArchivo = time() . '_' . Str::slug(pathinfo($archivo->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $archivo->getClientOriginalExtension();
        
        return $archivo->storeAs('articulos', $nombreArchivo, 'public');
    }
}
