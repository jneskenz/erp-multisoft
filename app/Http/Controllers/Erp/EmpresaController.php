<?php

namespace App\Http\Controllers\Erp;

use App\Http\Controllers\Controller;
use App\Http\Requests\Erp\EmpresaRequest;
use App\Models\Erp\Empresa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use function Spatie\Activitylog\activity;

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

        return view('erp.empresas.index', compact('empresas'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('erp.empresas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(EmpresaRequest $request)
    {
        try {
            DB::beginTransaction();

            $empresa = Empresa::create($request->validated());

            activity()->performedOn($empresa)->log('Empresa creada');

            DB::commit();

            return redirect()->route('empresas.index')->with('success', 'Empresa creada exitosamente.');

        } catch (\Exception $e) {

            DB::rollback();
            Log::error('Error al crear empresa: '.$e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Error al crear la empresa. Inténtalo nuevamente.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Empresa $empresa)
    {
        return view('erp.empresas.show', compact('empresa'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Empresa $empresa)
    {
        return view('erp.empresas.edit', compact('empresa'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(EmpresaRequest $request, Empresa $empresa)
    {
        try {
            DB::beginTransaction();

            $empresa->update($request->validated());

            activity()->performedOn($empresa)->log('Empresa actualizada');

            DB::commit();

            return redirect()
                ->route('empresas.index')
                ->with('success', 'Empresa actualizada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error al actualizar empresa: '.$e->getMessage());

            return back()
                ->withInput()
                ->with('error', 'Error al actualizar la empresa. Inténtalo nuevamente.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Empresa $empresa)
    {
        try {
            DB::beginTransaction();

            $nombreEmpresa = $empresa->nombre;
            $empresa->delete();

            activity()->log("Empresa '{$nombreEmpresa}' eliminada");

            DB::commit();

            return redirect()
                ->route('empresas.index')
                ->with('success', 'Empresa eliminada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Error al eliminar empresa: '.$e->getMessage());

            return back()->with('error', 'Error al eliminar la empresa. Inténtalo nuevamente.');
        }
    }
}
