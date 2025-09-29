{{-- headerCard|start --}}

<div class="card-header">
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
        <div class="d-flex flex-column justify-content-center mb-4 mb-md-0">
            <div class="alert {{ $dataHeaderCard['bgColor'] }} alert-dismissible d-flex mb-0" role="alert">
                <span class="alert-icon rounded"><i class="{{ $dataHeaderCard['icon'] }}"></i></span>
                <div class="d-flex flex-column ps-1">

                    <h6 class="alert-heading fw-bold mb-1">{{ $dataHeaderCard['title'] }}</h6>
                    <p class="mb-0 d-none d-md-block">{{ $dataHeaderCard['description'] }}</p>

                    @if ($dataHeaderCard['allowClose'] ?? false)
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    @endif
                </div>
            </div>
        </div>
        <div class="d-flex align-content-center flex-wrap gap-3 mb-4 mb-md-0">
            <div class="d-flex gap-3">
                @if ($dataHeaderCard['actions'] ?? false)
                    @foreach ($dataHeaderCard['actions'] as $action)
                        @can($action['permission'])
                            <a href="{{ $action['url'] }}"
                                class="btn {{ $action['typebtn'] ?? 'btn-primary' }} waves-effect">
                                <i class="{{ $action['icon'] }} me-2"></i>
                                {{ $action['name'] }}
                            </a>
                        @endcan
                    @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

{{-- headerCard|end --}}
