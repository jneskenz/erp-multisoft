
{{-- headerCard|start --}}

<div class="card-header d-flex justify-content-between align-items-center">
    <div>
        <div class="alert {{ $dataHeaderCard['bgColor'] }} alert-dismissible d-flex mb-0" role="alert">
            <span class="alert-icon rounded"><i class="ti ti-building"></i></span>
            <div class="d-flex flex-column ps-1">

                <h6 class="alert-heading fw-bold mb-1">{{ $dataHeaderCard['title'] }}</h6>
                <p class="mb-0">{{ $dataHeaderCard['description'] }}</p>

                @if($dataHeaderCard['allowClose'] ?? false)
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                @endif
            </div>
        </div>
    </div>
    <div>
        <div class="d-flex justify-content-end">
            @if($dataHeaderCard['actions'] ?? false)
                @foreach ($dataHeaderCard['actions'] as $action)
                    @can($action['permission'])
                        {{-- agrega en la etiqueta a una clase para cuando es responsive --}}
                        <a href="{{ $action['url'] }}" class="btn {{ $action['typebtn'] ?? 'btn-primary' }} waves-effect">
                            <i class="{{ $action['icon'] }} me-2"></i>
                            {{ $action['name'] }}
                        </a>
                    @endcan
                @endforeach
            @endif
        </div>
    </div>
</div>

{{-- headerCard|end --}}
