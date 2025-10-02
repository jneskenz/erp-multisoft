<?php

namespace App\Traits;

trait HasDataTable
{
    // Propiedades de búsqueda y filtrado
    public $search = '';
    public $perPage = 10;
    public $sortField = 'created_at';
    public $sortDirection = 'desc';
    
    // Propiedades de filtros
    public $filters = [];
    
    // Propiedades de selección
    public $selected = [];
    public $selectAll = false;

    /**
     * Reset page when search changes
     */
    public function updatingSearch()
    {
        $this->resetPage();
    }

    /**
     * Reset page when per page changes
     */
    public function updatingPerPage()
    {
        $this->resetPage();
    }

    /**
     * Reset page when filters change
     */
    public function updatingFilters()
    {
        $this->resetPage();
    }

    /**
     * Sort by field
     */
    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortDirection = 'asc';
        }
        
        $this->sortField = $field;
        $this->resetPage();
    }

    /**
     * Clear search
     */
    public function clearSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    /**
     * Clear all filters
     */
    public function clearFilters()
    {
        $this->filters = [];
        $this->resetPage();
    }

    /**
     * Clear selection
     */
    public function clearSelection()
    {
        $this->selected = [];
        $this->selectAll = false;
    }

    /**
     * Toggle select all
     */
    public function updatedSelectAll($value)
    {
        if ($value) {
            $this->selected = $this->getQuery()->pluck('id')->toArray();
        } else {
            $this->selected = [];
        }
    }

    /**
     * Get sort icon for column
     */
    public function getSortIcon($field)
    {
        if ($this->sortField !== $field) {
            return 'ti-chevrons-up-down';
        }
        
        return $this->sortDirection === 'asc' ? 'ti-chevron-up' : 'ti-chevron-down';
    }

    /**
     * Check if column is sorted
     */
    public function isSorted($field)
    {
        return $this->sortField === $field;
    }

    /**
     * Get CSS class for sortable column
     */
    public function getSortClass($field)
    {
        $class = 'cursor-pointer user-select-none';
        
        if ($this->isSorted($field)) {
            $class .= ' text-primary';
        }
        
        return $class;
    }

    /**
     * Export data (to be implemented in child components)
     */
    public function export($format = 'excel')
    {
        // Override in child component
    }

    /**
     * Bulk delete selected items
     */
    public function bulkDelete()
    {
        if (empty($this->selected)) {
            $this->dispatch('show-alert', [
                'type' => 'warning',
                'message' => 'No hay elementos seleccionados para eliminar.'
            ]);
            return;
        }

        try {
            $this->getModel()::whereIn('id', $this->selected)->delete();
            
            $this->dispatch('show-alert', [
                'type' => 'success',
                'message' => count($this->selected) . ' elementos eliminados exitosamente.'
            ]);
            
            $this->clearSelection();
            
        } catch (\Exception $e) {
            $this->dispatch('show-alert', [
                'type' => 'error',
                'message' => 'Error al eliminar los elementos: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Bulk toggle status
     */
    public function bulkToggleStatus($status = true)
    {
        if (empty($this->selected)) {
            $this->dispatch('show-alert', [
                'type' => 'warning',
                'message' => 'No hay elementos seleccionados.'
            ]);
            return;
        }

        try {
            $this->getModel()::whereIn('id', $this->selected)->update(['estado' => $status]);
            
            $action = $status ? 'activados' : 'desactivados';
            $this->dispatch('show-alert', [
                'type' => 'success',
                'message' => count($this->selected) . " elementos {$action} exitosamente."
            ]);
            
            $this->clearSelection();
            
        } catch (\Exception $e) {
            $this->dispatch('show-alert', [
                'type' => 'error',
                'message' => 'Error al actualizar los elementos: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Get the model class (to be implemented in child components)
     */
    abstract protected function getModel();

    /**
     * Get the base query (to be implemented in child components)
     */
    abstract protected function getQuery();
}