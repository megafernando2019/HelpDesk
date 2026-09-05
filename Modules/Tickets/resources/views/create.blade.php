@extends('layout.mainlayout')

@section('content')
        <div class="page-wrapper">

            @include('tickets::partials.create.modal-confirm-create-ticket-success')

            <div class="content container-fluid">
            
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="page-title">
                                <i class="ti ti-ticket"></i>
                                Crear Ticket
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="row current-info" data-department-id="{{$department_session_id}}">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>
                                    Ticket
                                </h3>
                            </div>
                            <div class="card-body">
                                <form class="action-create" action="#" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <h3 class="text-info">INFORMACIÓN GENERAL</h3>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Título <span class="text-danger">*</span></label>
                                                <input 
                                                    type="text" 
                                                    class="form-control" 
                                                    name="title" 
                                                    placeholder="Añade un título al ticket">
                                                <div class="message-feedback error-title text-danger"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tipo <span class="text-danger">*</span></label>
                                                <select class="form-control ticket-types-s" name="ticket_type_id">
                                                    <option>Selecciona un tipo de ticket</option>
                                                </select>
                                                <div class="message-feedback error-ticket_type_id text-danger"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Categoria <span class="text-danger">*</span></label>
                                                <select class="form-control category-select select2" name="category">
                                                    <option>Selecciona una categoria</option>
                                                </select>
                                                <div class="message-feedback error-category text-danger"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Servicio <span class="text-danger">*</span></label>
                                                <select class="form-control service-select select2" name="ticket_service_id">
                                                    <option>Selecciona un servicio</option>
                                                </select>
                                                <div class="message-feedback error-ticket_service_id text-danger"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Prioridad  <span class="text-danger">*</span></label>
                                                <select class="form-control ticket-priorities-s" name="ticket_priority_id">
                                                    <option>Selecciona una prioridad </option>
                                                </select>
                                                <div class="message-feedback error-ticket_priority_id"></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Descripción <span class="text-danger">*</span></label>
                                                <textarea class="form-control" 
                                                         name="description" 
                                                         id="" 
                                                         placeholder="Describe tu solicitud"
                                                ></textarea>
                                                <div class="message-feedback error-description text-danger"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 mt-2 mb-2">
                                            <h3 class="text-info">INFORMACIÓN ADICIONAL</h3>
                                        </div>

                                        <div class="col-md-6 justify-content-center">
                                            <div class="w-100 drop-zone rounded border-grey bg-ocean">
                                              <span class="drop-zone__prompt">Agrega archivos</span>
                                              <small class="text-muted fs-11">Puedes cargar archivos PDF, JPG, PNG</small>
                                            </div>
                                            <!-- Contenedor donde se apilan los archivos -->
                                            <div id="file-list" class="file-list"></div>
                                            <div class="message-feedback error-attachments text-danger"></div>
                                            <input multiple 
                                            type="file" 
                                            name="attachments[]" 
                                            id="myFile" 
                                            class="drop-zone__input">
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">URL</label>
                                                <input type="text" class="form-control" 
                                                name="url" 
                                                placeholder="Agregar enlace de ayuda complementaria">
                                                <div class="message-feedback error-url text-danger"></div>
                                            </div>
                                        </div>

                                        <div class="col-md-6"></div>
                                        <div class="col-md-6 mt-3 d-flex justify-content-end gap-3">
                                            <a class="btn btn-outline-mega rounded-pill">
                                                Cancelar
                                            </a>
                                             <button type="submit"
                                                     class="btn btn-mega rounded-pill">
                                                <i class="ti ti-circle-plus me-1"></i>Crear ticket
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="card-footer border-none"></div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
@endsection