<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\GrupoEmpresarial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class GrupoEmpresarialController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('superadmin');

        $this->middleware('can:grupo_empresarial.view')->only(['index', 'show']);
        $this->middleware('can:grupo_empresarial.create')->only(['create', 'store']);
        $this->middleware('can:grupo_empresarial.edit')->only(['edit', 'update']);
        $this->middleware('can:grupo_empresarial.delete')->only(['destroy', 'toggleStatus']);
        
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grupos = GrupoEmpresarial::withCount('empresas')->orderBy('nombre')->get();
        return view('admin.grupo-empresarial.index', compact('grupos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.grupo-empresarial.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'codigo' => 'required|string|max:20|unique:grupo_empresarials,codigo',
            'pais_origen' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'sitio_web' => 'nullable|url|max:255',
            'direccion_matriz' => 'nullable|string',
            'estado' => 'sometimes|boolean',
        ]);

        try {
            $grupo = GrupoEmpresarial::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'codigo' => strtoupper($request->codigo),
                'pais_origen' => $request->pais_origen,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'sitio_web' => $request->sitio_web,
                'direccion_matriz' => $request->direccion_matriz,
                'estado' => $request->estado ?? true,
            ]);

            return redirect()->route('admin.grupo-empresarial.index')
                ->with('success', 'Grupo empresarial creado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al crear el grupo empresarial.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(GrupoEmpresarial $grupoEmpresarial)
    {
        $grupoEmpresarial->load('empresas');
        return view('admin.grupo-empresarial.show', compact('grupoEmpresarial'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(GrupoEmpresarial $grupoEmpresarial)
    {
        return view('admin.grupo-empresarial.edit', compact('grupoEmpresarial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, GrupoEmpresarial $grupoEmpresarial)
    {
        $request->validate([
            'nombre' => 'required|string|max:200',
            'descripcion' => 'nullable|string',
            'codigo' => ['required', 'string', 'max:20', Rule::unique('grupo_empresarials', 'codigo')->ignore($grupoEmpresarial->id)],
            'pais_origen' => 'nullable|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'sitio_web' => 'nullable|url|max:255',
            'direccion_matriz' => 'nullable|string',
            'estado' => 'sometimes|boolean',
        ]);

        try {
            $grupoEmpresarial->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'codigo' => strtoupper($request->codigo),
                'pais_origen' => $request->pais_origen,
                'telefono' => $request->telefono,
                'email' => $request->email,
                'sitio_web' => $request->sitio_web,
                'direccion_matriz' => $request->direccion_matriz,
                'estado' => $request->estado ?? false,
            ]);

            return redirect()->route('admin.grupo-empresarial.index')
                ->with('success', 'Grupo empresarial actualizado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Error al actualizar el grupo empresarial.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(GrupoEmpresarial $grupoEmpresarial)
    {
        try {
            if ($grupoEmpresarial->empresas()->count() > 0) {
                return redirect()->back()
                    ->with('error', 'No se puede eliminar el grupo empresarial porque tiene empresas asociadas.');
            }

            $grupoEmpresarial->delete();

            return redirect()->route('admin.grupo-empresarial.index')
                ->with('success', 'Grupo empresarial eliminado exitosamente.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al eliminar el grupo empresarial.');
        }
    }

    public function toggleStatus(GrupoEmpresarial $grupoEmpresarial)
    {
        try {
            $grupoEmpresarial->update([
                'estado' => !$grupoEmpresarial->estado
            ]);

            $status = $grupoEmpresarial->estado ? 'activado' : 'desactivado';
            
            return redirect()->back()
                ->with('success', "Grupo empresarial {$status} exitosamente.");

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al cambiar el estado.');
        }
    }
}
