@extends('layout.mainlayout')

@section('content')
        <div class="page-wrapper">

            @include('tickets::partials.create.modal-confirm-create-ticket-success')

            <div class="content container-fluid">
            
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-12">
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                         <div class="card">
                            <div class="card-header">
                                <h3>
                                    Tickets disponibles
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="content-cards">
                                    <!-- Ordenamiento -->
                                    <div class="order-by-tickets-container d-flex justify-content-end mb-3">
                                        <div class="btn-group dropup d-flex align-items-center">
                                            <label for="" style="margin-right: 10px;">
                                                <i class="ti ti-arrows-sort"></i>
                                                Ordenar por
                                            </label>
                                            <button type="button"
                                                    id="btn-sort-label"
                                                    style="color: #949494 !important;background: none; border: 1px solid #eee !important;" 
                                                    class="btn rounded-pill dropdown-toggle sort-tickets-action" 
                                                    data-bs-toggle="dropdown" 
                                                    aria-haspopup="true" 
                                                    aria-expanded="false">
                                                Más reciente
                                            </button>
                                            <ul class="dropdown-menu" id="sort-tickets-menu">
                                                <li>
                                                    <a class="dropdown-item sort-option active" href="#" data-order="desc">
                                                        Más reciente
                                                    </a>
                                                </li>
                                                <li>
                                                    <a class="dropdown-item sort-option" href="#" data-order="asc">
                                                        Más antiguos
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!-- Contenedor donde se inyectan las cards -->
                                    <div id="tickets-container" class="content-cards d-flex flex-column gap-3"></div>

                                    <!-- Contenedor de Paginación -->
                                    <div id="tickets-pagination" class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top"></div>
                                </div>
                            </div>
                            <div class="card-footer text-body-secondary" style="border: none;"></div>
                         </div>
                         
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header p-0" style="border: none;"></div>
                            <div class="card-body">
                                <!-- Pasos del Proceso -->
                                <div class="row text-center g-2">
                                    <div class="col-md-4">
                                        <div class="p-2 rounded-pill bg-ocean text-secondary small">
                                            <i class="ti ti-user me-1"></i> Seleccionar responsable
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-2 rounded-pill bg-ocean text-secondary small">
                                            <i class="ti ti-ticket drop me-1"></i> Arrastra ticket(s)
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="p-2 rounded-pill bg-ocean text-secondary small">
                                            <i class="ti ti-user-check me-1"></i> Confirma asignación
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer text-body-secondary p-0" style="border: none;"></div>
                        </div>
                        
                        <!-- Card del Proceso / Asignación -->
                        <div class="card shadow-sm border rounded-3">
                            <div class="card-header" style="border: none;">
                                  <h3>
                                     Proceso
                                  </h3>
                            </div>
                            <div class="card-body p-3">

                                <!-- Seleccionar Responsable -->
                                <div class="mb-4">
                                    <label for="select-responsible" class="form-label fw-bold">Selecciona un responsable</label>
                                    <select id="select-responsible" class="form-select select2-users" style="width: 100%;">
                                        <option value="">Buscar y seleccionar un usuario responsable...</option>
                                    </select>
                                </div>

                                <!-- Dropzone / Zona de Arrastre -->
                                <div class="mb-4 d-flex" style="
                                        flex-direction: column;
                                    ">
                                    <label class="form-label fw-bold">Asignar ticket</label>
                                    <div id="drop-zone"  class="badge badge-soft-info border border-2 border-dashed rounded-3 p-4 text-center bg-light transition-all" style="min-height: 120px; border-color: #0d6efd !important;">
                                        <i class="ti ti-ticket text-secondary fs-1 mb-2 d-block ticket-section-icon"></i>
                                        <span class="text-mega fw-semibold">Arrastra ticket para asignar</span>
                                    </div>
                                </div>

                                <!-- Tickets Asignados Temporales -->
                                <div>
                                    <div class="mb-2">
                                        <h6 class="fw-bold mb-1">Tickets asignados</h6>
                                        <small class="text-muted display-name-user-asing-preview" style="margin-right: 5px;"></small>
                                        <small id="assigned-user-info" style="box-shadow: none !important;" class="badge badge-soft-info text-mega fw-semibold">
                                        </small>
                                    </div>

                                    <div id="assigned-tickets-container" class="d-flex flex-column gap-2" style="min-height: 100px;">
                                        <div class="text-center text-muted py-3 small">
                                            No hay tickets arrastrados aún.
                                        </div>
                                    </div>
                                </div>

                                <!-- Botón Confirmar -->
                                <div class="mt-4 text-end">
                                    <button id="btn-confirm-assign" class="btn btn-mega float-right rounded-pill" disabled>
                                        <i class="ti ti-user-check me-1"></i> Confirmar asignación
                                    </button>
                                </div>

                            </div>
                            <div class="card-footer" style="border: none;">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@vite(['Modules/Tickets/resources/assets/js/assing.js'])
@endsection