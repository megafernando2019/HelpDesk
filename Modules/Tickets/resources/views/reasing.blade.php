@extends('layout.mainlayout')

@section('content')
        <div class="page-wrapper">

            <div class="content container-fluid">
            
                <div class="page-header">
                </div>

                <!-- row content -->
                <div class="row">
                     <!-- instrucciones -->
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header p-0" style="border: none;"></div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-12">
                                        <h3 class="text-start mb-2">
                                            Proceso
                                        </h3>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="p-2 rounded-pill bg-ocean text-secondary small">
                                            <i class="ti ti-user-check me-1"></i> Selecciona un responsable
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="p-2 rounded-pill bg-ocean text-secondary small">
                                            <i class="ti ti-user me-1"></i> Selecciona otro responsable
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="p-2 rounded-pill bg-ocean text-secondary small">
                                            <i class="ti ti-status-change me-1"></i> Intercambia tickets entre encargados
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="p-2 rounded-pill bg-ocean text-secondary small">
                                            <i class="ti ti-replace-user me-1"></i> Confirma reasignación
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer p-0 text-body-secondary" 
                                 style="border: none;"></div>
                        </div>
                    </div>
                    <!-- reasignacion body -->
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header" style="border: none;">
                                <h3>
                                    Selecciona responsable
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <select 
                                                class="form-select select2-users-old-assing" 
                                                style="width: 100%;">
                                            <option value="">Buscar y seleccionar un usuario responsable...</option>
                                        </select>
                                    </div>
                                    <div class="col-md-12 mt-3" 
                                         style="overflow-x: auto;max-height: 400px;" id="containerUserOld"></div>
                                </div>
                            </div>
                            <div class="card-footer text-body-secondary" style="border: none;"></div>
                        </div>
                        
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header" style="border: none;">
                                <h3>
                                    Selecciona responsable
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <select 
                                                class="form-select select2-users-new-assing" 
                                                style="width: 100%;">
                                            <option value="">Buscar y seleccionar un usuario responsable...</option>
                                        </select>
                                    </div>
                                    <div id="containerUserNew" style="overflow-x: auto;max-height: 400px;" class="mt-3 col-md-12"></div>
                                </div>
                            </div>
                            <div class="card-footer text-body-secondary" style="border: none;"></div>
                        </div>
                        
                    </div>
                    <div class="col-md-12 mb-2">
                        <button id="btnSaveAssignments" type="button" class="btn btn-mega float-right rounded-pill">
                             <i class="ti ti-replace-user me-1"></i>
                             Confirmar reasignación
                        </button>
                    </div>
                </div>
            </div>
        </div>

@vite(['Modules/Tickets/resources/assets/js/reassing.js'])
@endsection