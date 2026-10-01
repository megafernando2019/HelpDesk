@extends('layout.mainlayout')

@section('title', 'HelpDesk - Reportes Categorías')

@section('content')
@vite('Modules/Reports/resources/assets/css/reports_category.css')

    <div class="page-wrapper">
        <div class="content container-fluid">

            <div class="page-header metadata-page-index" data-team-id="{{$user_team_id}}">
            </div>

            <div class="row w-100">
                <div class="col-md-3">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white" style="height: calc(100vh - 120px);">
                        <!-- Encabezado -->
                        <div class="d-flex align-items-center gap-2 mb-3 text-secondary">
                            <i class="ti ti-chart-pie fs-4"></i>
                            <h6 class="fw-bold mb-0 text-dark">Reportes | Categorías</h6>
                        </div>

                        <!-- Filtros de Entradas -->
                        <div class="mb-2">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text bg-white border-end-0 text-muted rounded-start-3">
                                    <i class="ti ti-calendar"></i>
                                </span>
                                <input type="text" id="flatpickr-range"
                                    class="form-control border-start-0 rounded-end-3 fs-7"
                                    placeholder="Selecciona rango de fecha">
                            </div>
                        </div>

                        <!-- Lista de Integrantes -->
                        <div class="d-flex flex-column gap-3 render-members">
                        </div>
                    </div>
                </div>
                <div class="col-md-9 set-loading">
                    <!-- Botones de Exportación -->
                    <div class="d-flex align-items-center gap-2 mb-3">
                        <button type="button"
                            id="btn-export-pdf"
                            data-bs-toggle="tooltip" 
                            title="Exportar a PDF"
                            class="btn btn-outline-light text-dark bg-white border px-4 py-2 fw-semibold shadow-sm rounded-2">
                            PDF
                        </button>
                        <button type="button"
                            id="btn-export-excel"
                            data-bs-toggle="tooltip" 
                            title="Exportar a Excel"
                            class="btn btn-outline-success bg-white px-4 py-2 fw-semibold rounded-2">
                            <i class="ti ti-file-type-xls"></i>
                            Excel
                        </button>
                    </div>

                    <!-- Contenedor de la Tabla -->
                    <div class="card border-0 shadow-sm rounded-3">
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table id="categories-report-table"
                                    class="table datatable table-hover align-middle mb-0 text-center">
                                    <thead class="table-light text-secondary">
                                        <tr>
                                            <th class="py-3 fw-bold">No.</th>
                                            <th class="py-3 fw-bold text-start">Categoría</th>
                                            <th class="py-3 fw-bold">Total Recibidos</th>
                                            <th class="py-3 fw-bold">Por Asignar</th>
                                            <th class="py-3 fw-bold">En proceso</th>
                                            <th class="py-3 fw-bold">En espera</th>
                                            <th class="py-3 fw-bold">Solucionados</th>
                                            <th class="py-3 fw-bold">Cerrados</th>
                                            <th class="py-3 fw-bold">Cancelados</th>
                                            <th class="py-3 fw-bold">Cumplimiento</th>
                                            <th class="py-3 fw-bold">TPS</th>
                                        </tr>
                                    </thead>
                                    <tbody class="text-secondary fs-14">
                                    </tbody>
                                </table>
                            </div>

                            <div class="d-flex justify-content-end align-items-center mt-3 p-2">
                                <div id="pagination-container" class="pagination-buttons"></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

            @include('tickets::partials.modal-assing-user-index')
            @include('tickets::partials.modal-add-observation')

        </div>
    </div>

@vite('Modules/Reports/resources/assets/js/reports_category.js')
@endsection
