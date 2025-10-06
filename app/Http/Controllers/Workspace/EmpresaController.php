<?php

namespace App\Http\Controllers\Workspace;

use App\Http\Controllers\Controller;
use App\Http\Requests\Workspace\EmpresaRequest;
use App\Models\Workspace\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class EmpresaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Aquí puedes agregar middleware para permisos específicos si es necesario

        $this->middleware('can:empresas.view')->only('index', 'show');
        $this->middleware('can:empresas.create')->only('create', 'store');
        $this->middleware('can:empresas.edit')->only('edit', 'update');
        $this->middleware('can:empresas.delete')->only('destroy');

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Empresa::query();

        // busqueda
        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('razon_social', 'like', '%'.$request->input('buscar').'%')
                    ->orWhere('nombre_comercial', 'like', '%'.$request->input('buscar').'%')
                    ->orWhere('numerodocumento', 'like', '%'.$request->input('buscar').'%');
            });
        }

        // filtrar por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->input('estado'));
        }

        $empresas = $query->orderBy('nombre_comercial')
            ->paginate(10)
            ->withQueryString();

        // Obtener estadísticas generales (sin filtros)
        $totalEmpresas = Empresa::count();
        $empresasActivas = Empresa::where('estado', true)->count();
        $grupoActual = $this->getGrupoActual();

        return view('apps.workspace.empresas.index', compact('empresas', 'totalEmpresas', 'empresasActivas', 'grupoActual'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $gruposEmpresariales = \App\Models\Admin\GrupoEmpresarial::activos()->pluck('nombre', 'id');
        $grupoActual = $this->getGrupoActual();
        return view('apps.workspace.empresas.create', compact('gruposEmpresariales', 'grupoActual'));
    }

    private function generateUniqueCodigo()
    {
        do {
            $lastEmpresa = Empresa::orderBy('id', 'desc')->first();
            $nextId = $lastEmpresa ? $lastEmpresa->id + 1 : 1;
            $codigo = 'EMP' . str_pad($nextId, 4, '0', STR_PAD_LEFT);
        } while (Empresa::where('codigo', $codigo)->exists());

        return $codigo;
    }

    /**
     * Obtener el grupo empresarial actual del usuario
     */
    private function getGrupoActual()
    {
        $user = Auth::user();
        return $user->gruposEmpresariales()->first();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmpresaRequest $request)
    {
        try {
            DB::beginTransaction();
            
            $validatedData = $request->validated();
            
            $slug = Str::slug($validatedData['razon_social']);
            
            $validatedData['codigo'] = $this->generateUniqueCodigo();
            $validatedData['slug'] = $slug;
            $validatedData['grupo_empresarial_id'] = Auth::user()->grupo_empresarial_id;

            Log::info('Creando empresa con código: ' . $validatedData['codigo']);
            Log::info('Creando empresa con slug: ' . $validatedData['slug']);

            $empresa = Empresa::create($validatedData);

            DB::commit();

            Log::info('Empresa creada exitosamente: ' . $empresa->id);

            $grupoActual = $this->getGrupoActual();

            return redirect()->route('workspace.empresas.index', ['grupoempresa' => $grupoActual->slug])->with('success', 'Empresa creada exitosamente.');

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            Log::error('Error de base de datos al crear empresa: ' . $e->getMessage());
            
            // Verificar si es error de duplicado (código de error 23000)
            if ($e->getCode() == 23000) {
                return back()
                    ->withInput()
                    ->with('error', 'El número de documento (RUC) ya está registrado en el sistema.');
            }
            
            return back()
                ->withInput()
                ->with('error', 'Error de base de datos al crear la empresa. Verifique los datos e inténtelo nuevamente.' . $e->getMessage());
                
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error general al crear empresa: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Error inesperado al crear la empresa. Inténtalo nuevamente.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $grupoempresa, Empresa $empresa)
    {
        // Obtener las actividades relacionadas a esta empresa
        $activities = $empresa->activities()->latest()->get();
        $grupoActual = $this->getGrupoActual();
        
        return view('apps.workspace.empresas.show', compact('empresa', 'activities', 'grupoActual'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $grupoempresa, Empresa $empresa)
    {
        
        // $gruposEmpresariales = \App\Models\Admin\GrupoEmpresarial::activos()->pluck('nombre', 'id');
        $grupoActual = $this->getGrupoActual();
        return view('apps.workspace.empresas.edit', compact('empresa', 'grupoActual'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmpresaRequest $request, string $grupoempresa, Empresa $empresa)
    {
        try {
            DB::beginTransaction();

            $empresa->update($request->validated());

            // El activity log se registra automáticamente por el trait LogsActivity en el modelo

            DB::commit();

            $grupoActual = $this->getGrupoActual();

            return redirect()
                ->route('workspace.empresas.index', ['grupoempresa' => $grupoActual->slug])
                ->with('success', 'Empresa actualizada exitosamente.');

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            Log::error('Error de base de datos al actualizar empresa: ' . $e->getMessage());
            
            // Verificar si es error de duplicado (código de error 23000)
            if ($e->getCode() == 23000) {
                return back()
                    ->withInput()
                    ->with('error', 'El número de documento (RUC) ya está registrado en el sistema.');
            }
            
            return back()
                ->withInput()
                ->with('error', 'Error de base de datos al actualizar la empresa. Verifique los datos e inténtelo nuevamente.');
                
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error general al actualizar empresa: ' . $e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Error inesperado al actualizar la empresa. Inténtalo nuevamente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $grupoempresa, Empresa $empresa)
    {
        try {
            DB::beginTransaction();

            $nombreEmpresa = $empresa->nombre_comercial ?? $empresa->razon_social;
            $empresaData = $empresa->toArray(); // Guardar datos antes de eliminar
            $empresa->delete();

            // El activity log se registra automáticamente por el trait LogsActivity en el modelo

            DB::commit();

            $grupoActual = $this->getGrupoActual();

            return redirect()
                ->route('workspace.empresas.index', ['grupoempresa' => $grupoActual->slug])
                ->with('success', 'Empresa eliminada exitosamente.');

        } catch (\Illuminate\Database\QueryException $e) {
            DB::rollback();
            Log::error('Error de base de datos al eliminar empresa: ' . $e->getMessage());
            
            // Verificar si es error de integridad referencial (código de error 23000)
            if ($e->getCode() == 23000) {
                return back()->with('error', 'No se puede eliminar la empresa porque tiene registros relacionados en el sistema.');
            }
            
            return back()->with('error', 'Error de base de datos al eliminar la empresa. Inténtalo nuevamente.');
            
        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error general al eliminar empresa: ' . $e->getMessage());

            return back()->with('error', 'Error inesperado al eliminar la empresa. Inténtalo nuevamente.');
        }
    }
}
