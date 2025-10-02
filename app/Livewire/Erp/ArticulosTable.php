<?php

namespace App\Livewire\Erp;

use App\Models\Erp\Articulo;
use App\Traits\HasDataTable;
use Livewire\Component;
use Livewire\WithPagination;

class ArticulosTable extends Component
{
    use WithPagination, HasDataTable;

    protected $paginationTheme = 'bootstrap';

    // Filtros específicos de artículos
    public $filtros = [
        'estado' => '',
        'inventariable' => '',
        'vendible' => '',
        'comprable' => '',
        'bajo_stock' => false,
    ];

    protected $listeners = [
        'refreshTable' => '$refresh',
        'articleDeleted' => '$refresh',
        'articleUpdated' => '$refresh',
    ];

    public function mount()
    {
        $this->sortField = 'nombre';
        $this->sortDirection = 'asc';
    }

    /**
     * Get the model class
     */
    protected function getModel()
    {
        return Articulo::class;
    }

    /**
     * Get the base query
     */
    protected function getQuery()
    {
        $query = Articulo::query();

        // Búsqueda
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('codigo', 'like', '%' . $this->search . '%')
                  ->orWhere('nombre', 'like', '%' . $this->search . '%')
                  ->orWhere('descripcion', 'like', '%' . $this->search . '%')
                  ->orWhere('marca', 'like', '%' . $this->search . '%')
                  ->orWhere('modelo', 'like', '%' . $this->search . '%');
            });
        }

        // Filtros
        if ($this->filtros['estado'] !== '') {
            $query->where('estado', $this->filtros['estado']);
        }

        if ($this->filtros['inventariable'] !== '') {
            $query->where('inventariable', $this->filtros['inventariable']);
        }

        if ($this->filtros['vendible'] !== '') {
            $query->where('vendible', $this->filtros['vendible']);
        }

        if ($this->filtros['comprable'] !== '') {
            $query->where('comprable', $this->filtros['comprable']);
        }

        if ($this->filtros['bajo_stock']) {
            $query->bajoStock();
        }

        // Ordenamiento
        $query->orderBy($this->sortField, $this->sortDirection);

        return $query;
    }

    /**
     * Get articulos with pagination
     */
    public function getArticulosProperty()
    {
        return $this->getQuery()->paginate($this->perPage);
    }

    /**
     * Toggle article status
     */
    public function toggleStatus($articuloId)
    {
        try {
            $articulo = Articulo::findOrFail($articuloId);
            $articulo->update(['estado' => !$articulo->estado]);

            $estado = $articulo->estado ? 'activado' : 'desactivado';
            
            $this->dispatch('show-alert', [
                'type' => 'success',
                'message' => "Artículo {$estado} exitosamente."
            ]);

        } catch (\Exception $e) {
            $this->dispatch('show-alert', [
                'type' => 'error',
                'message' => 'Error al cambiar el estado del artículo.'
            ]);
        }
    }

    /**
     * Delete article
     */
    public function deleteArticle($articuloId)
    {
        try {
            $articulo = Articulo::findOrFail($articuloId);
            $articulo->delete();

            $this->dispatch('show-alert', [
                'type' => 'success',
                'message' => 'Artículo eliminado exitosamente.'
            ]);

            $this->dispatch('articleDeleted');

        } catch (\Exception $e) {
            $this->dispatch('show-alert', [
                'type' => 'error',
                'message' => 'Error al eliminar el artículo.'
            ]);
        }
    }

    /**
     * Clear all filters
     */
    public function clearAllFilters()
    {
        $this->search = '';
        $this->filtros = [
            'estado' => '',
            'inventariable' => '',
            'vendible' => '',
            'comprable' => '',
            'bajo_stock' => false,
        ];
        $this->resetPage();
    }

    /**
     * Export articles
     */
    public function export($format = 'excel')
    {
        $articulos = $this->getQuery()->get();
        
        // Implementar lógica de exportación
        $this->dispatch('show-alert', [
            'type' => 'info',
            'message' => "Exportando {$articulos->count()} artículos en formato {$format}..."
        ]);
    }

    public function render()
    {
        return view('livewire.erp.articulos-table');
    }
}
