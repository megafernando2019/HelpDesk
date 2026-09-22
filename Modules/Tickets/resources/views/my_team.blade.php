@extends('layout.mainlayout')

@section('title', 'HelpDesk - Mi equipo')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
       
        <div class="page-header metadata-page-index" data-team-id='@json($teamIds)'>
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
                        <input type="text" id="filter_date_range" class="form-control border-start-0 rounded-end-3 fs-7" placeholder="Selecciona rango de fecha">
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
                <div class="d-flex flex-column gap-3">
                    <div class="card border-0 shadow-sm rounded-4 team-card active-team-card overflow-hidden" style="background: linear-gradient(135deg, #f0f4ff 0%, #ffffff 100%); cursor: pointer;">
                        <div class="card-body p-2 d-flex align-items-center gap-3">
                            <img src="{{ asset('build/img/icons/tugui_en_computadora.png') }}" alt="Tugui" style="width: 45px; height: 45px; object-fit: contain;">
                            <span class="fw-bold text-dark fs-6">Todos</span>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm rounded-4 team-card overflow-hidden" style="background: linear-gradient(135deg, #fff3e0 0%, #ffffff 100%); cursor: pointer;">
                        <div class="card-body p-2 d-flex align-items-center gap-3">
                            <div class="avatar-circle text-white fw-bold d-flex align-items-center justify-content-center rounded-circle" style="width: 45px; height: 45px; background-color: #f89d59; flex-shrink: 0;">
                                AJ
                            </div>
                            <div class="text-truncate">
                                <div class="fw-bold text-dark fs-7 lh-sm text-truncate">Alan Juárez</div>
                                <small class="text-muted fs-8 text-truncate d-block">soporte3@megatravel.com.mx</small>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm rounded-4 team-card overflow-hidden" style="background: linear-gradient(135deg, #e0f2f1 0%, #ffffff 100%); cursor: pointer;">
                        <div class="card-body p-2 d-flex align-items-center gap-3">
                            <div class="avatar-circle text-white fw-bold d-flex align-items-center justify-content-center rounded-circle" style="width: 45px; height: 45px; background-color: #00a896; flex-shrink: 0;">
                                BJ
                            </div>
                            <div class="text-truncate">
                                <div class="fw-bold text-dark fs-7 lh-sm text-truncate">Brayan Jiménez</div>
                                <small class="text-muted fs-8 text-truncate d-block">soporte4@megatravel.com.mx</small>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm rounded-4 team-card overflow-hidden" style="background: linear-gradient(135deg, #fff9c4 0%, #ffffff 100%); cursor: pointer;">
                        <div class="card-body p-2 d-flex align-items-center gap-3">
                            <div class="avatar-circle text-white fw-bold d-flex align-items-center justify-content-center rounded-circle" style="width: 45px; height: 45px; background-color: #fbc02d; flex-shrink: 0;">
                                HG
                            </div>
                            <div class="text-truncate">
                                <div class="fw-bold text-dark fs-7 lh-sm text-truncate">Hector Garay</div>
                                <small class="text-muted fs-8 text-truncate d-block">soporte1@megatravel.com.mx</small>
                            </div>
                        </div>
                    </div>
                    <div class="card border-0 shadow-sm rounded-4 team-card overflow-hidden" style="background: linear-gradient(135deg, #efebe9 0%, #ffffff 100%); cursor: pointer;">
                        <div class="card-body p-2 d-flex align-items-center gap-3">
                            <div class="avatar-circle text-white fw-bold d-flex align-items-center justify-content-center rounded-circle" style="width: 45px; height: 45px; background-color: #cb9b7a; flex-shrink: 0;">
                                LV
                            </div>
                            <div class="text-truncate">
                                <div class="fw-bold text-dark fs-7 lh-sm text-truncate">Luis Fernando Valdov...</div>
                                <small class="text-muted fs-8 text-truncate d-block">lvaldovinos@megatravel.com.mx</small>
                            </div>
                        </div>
                    </div>

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