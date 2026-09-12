@extends('layout.mainlayout')

@section('content')
@vite('Modules/Tickets/resources/assets/css/archive.css')

<div class="page-wrapper">
    <div class="content container-fluid">
            
        <div class="page-header">
            <div class="row w-100">
                <div class="col-md-4 d-flex align-items-center">
                    <h3 class="page-title">
                        <i class="ti ti-clipboard-check"></i>
                        Archivo
                    </h3>
                </div>
                    
                <div class="col-md-3">
                    
                </div>

                <div class="col-md-5 d-flex align-items-center justify-content-end gap-3">
                    <div style="width: 250px;">
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted pe-1">
                                <i class="ti ti-pin fs-16"></i>
                            </span>
                            <select class="form-control border-start-0  ps-1" 
                                    name="priority_param_id"
                                    data-action=filter-by-priority>
                                <option value="">Prioridad</option>
                                @forelse ($details->priorities as $item)
                                    <option value="{{ $item?->id ?? 0 }}">
                                        {{ $item?->name ?? 'Dato no disponible' }}
                                    </option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>

                    <div style="width: 250px";>
                        <div class="input-group">
                            <span class="input-group-text bg-white text-muted pe-1">
                                <i class="ti ti-calendar-week fs-16"></i>
                            </span>
                            <input type="text" 
                                   class="form-control border-start-0  ps-1" 
                                   placeholder="Selecciona rango de fecha" 
                                   id="flatpickr-range-tickets">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gap-1" style="flex-wrap: nowrap !important;">
            <!-- detalles -->
            <div class="col-md-4 current-rounded p-2 border d-flex gap-2" style="background-color: #f5fff9;">
                <div>
                    <i class="ti ti-circle-check icon-success text-success"></i>
                </div>
                <div class="info-alert-header">
                    <h3>
                        {{$successTotal}}
                    </h3>
                    <span>
                        Solucionados
                    </span>
                </div>
            </div>
            <div class="col-md-4 current-rounded p-2 border d-flex gap-2" style="background-color: #fff9f1;">
                <div>
                    <i class="ti ti-lock-check text-primary icon-ticket-close"></i>
                </div>
                <div class="info-alert-header">
                    <h3>
                         {{$closeTotal}}
                    </h3>
                    <span>
                        Cerrados
                    </span>
                </div>
            </div>
            <div class="col-md-4 current-rounded p-2 border d-flex gap-2" style="background-color: #fffafa;">
                <div>
                    <i class="ti ti-cancel text-danger icon-ticket-cancel"></i>
                </div>
                <div class="info-alert-header">
                    <h3>
                         {{$cancelTotal}}
                    </h3>
                    <span>
                        Cancelados
                    </span>
                </div>
            </div>
        </div>

      
        <div class="row gap-1 mt-4" style="flex-wrap: nowrap !important;">
            <div id="tickets-container-success"  style="background-color: #f5fff9; height: 600px;
                overflow-x: auto;"
                 class="col-md-4 border current-rounded p-3"></div>

            <div id="tickets-container-close"  style="background-color: #fff9f1; height: 600px;
            overflow-x: auto;" 
             class="col-md-4 current-rounded p-3 border"></div>

             <div id="tickets-container-cancel"
                  style="background-color: #fffafa; height: 600px;
                overflow-x: auto;" 
                  class="col-md-4 current-rounded p-3 border"
              ></div>
        </div>
      
        @include('tickets::partials.modal-add-observation')

    </div>
</div>


@vite('Modules/Tickets/resources/assets/js/archive.js')
@endsection