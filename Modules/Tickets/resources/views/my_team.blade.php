@extends('layout.mainlayout')

@section('title', 'HelpDesk - Mi equipo')

@section('content')
@vite('Modules/Tickets/resources/assets/css/my_team.css')

<div class="page-wrapper">
    <div class="content container-fluid">
       
        <div class="page-header metadata-page-index">
        </div>

       <div class="row w-100">
          <div class="col-md-3">
            <div class="card border-0 shadow-sm rounded-4 p-3 bg-white" style="max-width: 280px;">
                <!-- Encabezado -->
                <div class="d-flex align-items-center gap-2 mb-3 text-secondary">
                    <i class="ti ti-users fs-4"></i>
                    <h6 class="fw-bold mb-0 text-dark">Mi equipo</h6>
                </div>

                <!-- Filtros de Entradas -->
                <div class="mb-2">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0 text-muted rounded-start-3">
                            <i class="ti ti-calendar"></i>
                        </span>
                        <input type="text" id="flatpickr-range" class="form-control border-start-0 rounded-end-3 fs-7" placeholder="Selecciona rango de fecha">
                    </div>
                </div>

                <div class="mb-2">
                    <select class="form-select form-select-sm rounded-3 text-muted select2-filter" id="filter_category">
                        <option value="" selected disabled>Selecciona categoría(s)</option>
                        <option value="1">Soporte Técnico</option>
                        <option value="2">Desarrollo</option>
                    </select>
                </div>

                <div class="mb-4">
                    <select class="form-select form-select-sm rounded-3 text-muted select2-filter" id="filter_service">
                        <option value="" selected disabled>Selecciona servicio(s)</option>
                        <option value="1">Mantenimiento</option>
                        <option value="2">Incidencia</option>
                    </select>
                </div>

                <!-- Lista de Integrantes -->
                <div class="d-flex flex-column gap-3 render-members">
                </div>
            </div>
          </div>
          <div class="col-md-9">
              @include('tickets::partials.my_team.widget_header')
              @include('tickets::partials.my_team.widget_chars_tickets')
          </div>
       </div>

        @include('tickets::partials.kaban-index-template')
        @include('tickets::partials.modal-assing-user-index')
        @include('tickets::partials.modal-add-observation')

    </div>
</div>

@vite(['Modules/Tickets/resources/assets/js/my_team.js'])
@endsection