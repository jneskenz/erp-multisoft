<!-- breadcrumbs|start -->
   {{-- como optener esos datos aqui  --}}
   <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-2 row-gap-4">
      <div class="d-flex flex-column justify-content-center">
         <p class="mb-0">
            @foreach ($dataBreadcrumb['breadcrumbs'] as $breadcrumb)
            @if (!$loop->last)
               <a href="{{ $breadcrumb['url'] }}" class="text-secondary">{{ $breadcrumb['name'] }}</a>
               <span class="text-secondary"> › </span>
            @else
               <span class="text-primary">{{ $breadcrumb['name'] }}</span>
            @endif
            
         @endforeach
         </p>
         <h4 class="mb-1">
            <button type="button" class="btn btn-label-secondary btn-sm px-2 waves-effect">
               <span class="alert-icon rounded"><i class="{{ $dataBreadcrumb['icon'] }}"></i></span>
            </button>
            {{ $dataBreadcrumb['title'] }}
         </h4>
      </div>
      <div class="d-flex align-content-center flex-wrap gap-4">
         
         {{-- estatus --}}
         @foreach ($dataBreadcrumb['stats'] as $stat)
            <div class="d-flex align-items-center">
               <span class="badge {{ $stat['color'] }} me-2">
                  <i class="{{ $stat['icon'] }}"></i>
               </span>
               <span class="text-muted">{{ $stat['name'] }}: {{ $stat['value'] }}</span>
            </div>
         @endforeach

         {{-- acciones --}}
         <div class="d-grid gap-2 d-md-flex justify-content-md-end">
            @foreach ($dataBreadcrumb['actions'] as $action)
               @can($action['permission']) 
                  {{-- agrega en la etiqueta a una clase para cuando es responsive --}}
                  <a href="{{ $action['url'] }}" class="btn btn-primary ">
                     <i class="{{ $action['icon'] }} me-2"></i>
                     {{ $action['name'] }}
                  </a>
               @endcan
            @endforeach
         </div>

      </div>
   </div>
<!-- breadcrumbs|end -->