@if ($paginator->hasPages())
    <nav aria-label="Pagination Navigation" role="navigation">
        <ul class="pagination pagination-sm justify-content-end mb-0">
            {{-- First Page Link --}}
            @if ($paginator->currentPage() > 3)
                <li class="page-item">
                    <button type="button" class="page-link" wire:click="gotoPage(1)" title="Primera página">
                        <i class="ti ti-chevrons-left"></i>
                    </button>
                </li>
            @endif

            {{-- Previous Page Link --}}
            @if ($paginator->onFirstPage())
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.previous')">
                    <span class="page-link">
                        <i class="ti ti-chevron-left"></i>
                    </span>
                </li>
            @else
                <li class="page-item">
                    <button type="button" class="page-link" wire:click="previousPage" rel="prev" aria-label="@lang('pagination.previous')" title="Página anterior">
                        <i class="ti ti-chevron-left"></i>
                    </button>
                </li>
            @endif

            {{-- Pagination Elements (máximo 5 botones numéricos) --}}
            @php
                $current = $paginator->currentPage();
                $last = $paginator->lastPage();
                
                // Determinar el rango de páginas a mostrar (máximo 5)
                if ($last <= 5) {
                    // Si hay 5 páginas o menos, mostrar todas
                    $start = 1;
                    $end = $last;
                    $showFirstDots = false;
                    $showLastDots = false;
                } else {
                    // Más de 5 páginas - aplicar lógica de 5 botones máximo
                    if ($current <= 3) {
                        // Al inicio: [1] [2] [3] ... [last]
                        $start = 1;
                        $end = 3;
                        $showFirstDots = false;
                        $showLastDots = true;
                    } elseif ($current >= $last - 2) {
                        // Al final: [1] ... [last-2] [last-1] [last]
                        $start = $last - 2;
                        $end = $last;
                        $showFirstDots = true;
                        $showLastDots = false;
                    } else {
                        // En el medio: [1] ... [current-1] [current] [current+1] ... [last]
                        $start = $current - 1;
                        $end = $current + 1;
                        $showFirstDots = true;
                        $showLastDots = true;
                    }
                }
            @endphp

            {{-- Primera página y puntos suspensivos iniciales --}}
            @if ($showFirstDots)
                <li class="page-item">
                    <button type="button" class="page-link" wire:click="gotoPage(1)" title="Ir a página 1">1</button>
                </li>
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">...</span>
                </li>
            @endif

            {{-- Botones numéricos del rango actual --}}
            @for ($page = $start; $page <= $end; $page++)
                @if ($page == $current)
                    <li class="page-item active" aria-current="page">
                        <span class="page-link fw-bold">{{ $page }}</span>
                    </li>
                @else
                    <li class="page-item">
                        <button type="button" class="page-link" wire:click="gotoPage({{ $page }})" title="Ir a página {{ $page }}">
                            {{ $page }}
                        </button>
                    </li>
                @endif
            @endfor

            {{-- Puntos suspensivos finales y última página --}}
            @if ($showLastDots)
                <li class="page-item disabled" aria-disabled="true">
                    <span class="page-link">...</span>
                </li>
                <li class="page-item">
                    <button type="button" class="page-link" wire:click="gotoPage({{ $last }})" title="Ir a página {{ $last }}">{{ $last }}</button>
                </li>
            @endif

            {{-- Next Page Link --}}
            @if ($paginator->hasMorePages())
                <li class="page-item">
                    <button type="button" class="page-link" wire:click="nextPage" rel="next" aria-label="@lang('pagination.next')" title="Página siguiente">
                        <i class="ti ti-chevron-right"></i>
                    </button>
                </li>
            @else
                <li class="page-item disabled" aria-disabled="true" aria-label="@lang('pagination.next')">
                    <span class="page-link">
                        <i class="ti ti-chevron-right"></i>
                    </span>
                </li>
            @endif

            {{-- Last Page Link --}}
            @if ($paginator->currentPage() < $paginator->lastPage() - 2)
                <li class="page-item">
                    <button type="button" class="page-link" wire:click="gotoPage({{ $paginator->lastPage() }})" title="Última página">
                        <i class="ti ti-chevrons-right"></i>
                    </button>
                </li>
            @endif
        </ul>

        {{-- Page Info with Jump Input --}}
        <div class="d-flex align-items-center mt-2 justify-content-end">
            <span class="text-muted me-3">
                <small>
                    Página <strong>{{ $paginator->currentPage() }}</strong> de <strong>{{ $paginator->lastPage() }}</strong>
                </small>
            </span>
            
            @if ($paginator->lastPage() > 10)
                <div class="input-group input-group-sm" style="width: 120px;">
                    <input type="number" 
                           class="form-control form-control-sm text-center" 
                           placeholder="Ir a..."
                           min="1" 
                           max="{{ $paginator->lastPage() }}"
                           wire:keydown.enter="gotoPage($event.target.value)"
                           title="Escriba el número de página y presione Enter">
                    <span class="input-group-text">
                        <i class="ti ti-corner-down-left" style="font-size: 0.75rem;"></i>
                    </span>
                </div>
            @endif
        </div>
    </nav>
@endif