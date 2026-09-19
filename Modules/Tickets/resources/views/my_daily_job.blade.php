@extends('layout.mainlayout')

@section('title', 'HelpDesk | Mi trabajo diario')

@section('content')
@vite('Modules/Tickets/resources/assets/css/my_daily_job.css')

<div class="page-wrapper metadata-page-asing"  data-team-id='@json($teamIds)'>
    <div class="content container-fluid">
            
        <div class="page-header">
            <div class="row w-100">
                <div class="col-md-4 d-flex align-items-center">
                    <h3 class="page-title">
                        <i class="ti ti-clipboard-smile"></i>
                        Mi trabajo diario
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
                                   id="flatpickr-range-tickets-job-daily">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gap-1" style="flex-wrap: nowrap !important;">
            <!-- detalles -->
            <div class="col-md-4 current-rounded p-2 border d-flex gap-2" style="background-color: #faf8ff;">
                <div>
                    <i class="ti ti-user icon-ticket-to-assing"></i>
                </div>
                <div class="info-alert-header">
                    <h3 class="count-to-assing">
                       Cargando...
                    </h3>
                    <span>
                        Por asignar
                    </span>
                </div>
            </div>
            <div class="col-md-4 current-rounded p-2 border d-flex gap-2" style="background-color: #f3f6ff;">
                <div>
                    <i class="ti ti-progress-check icon-ticket-progress"></i>
                </div>
                <div class="info-alert-header">
                    <h3 class="count-progress">
                        Cargando...
                    </h3>
                    <span>
                        En proceso
                    </span>
                </div>
            </div>
            <div class="col-md-4 current-rounded p-2 border d-flex gap-2" style="background-color: #fafbfb;">
                <div>
                    <i class="ti ti-clock icon-ticket-waiting"></i>
                </div>
                <div class="info-alert-header">
                    <h3 class="count-waiting">
                         Cargando...
                    </h3>
                    <span>
                        En espera
                    </span>
                </div>
            </div>
        </div>

        <div class="row gap-1 mt-4 container-load-tickets" style="flex-wrap: nowrap !important;">
            <div id="tickets-container-to-assing" 
                 style="background-color: #faf8ff; height: calc(100vh - 220px); overflow-y: auto;"
                 class="col-md-4 border current-rounded p-3">
            </div>

            <div id="tickets-container-progress" 
                 style="background-color: #f3f6ff; height: calc(100vh - 220px); overflow-y: auto;" 
                 class="col-md-4 current-rounded p-3 border">
            </div>

            <div id="tickets-container-waiting"
                 style="background-color: #fafbfb; height: calc(100vh - 220px); overflow-y: auto;" 
                 class="col-md-4 current-rounded p-3 border">
            </div>
        </div>
      
        @include('tickets::partials.modal-add-observation')
        @include('tickets::partials.modal-assing-user-index')

    </div>
</div>

@vite('Modules/Tickets/resources/assets/js/my_daily_job.js')
@endsection