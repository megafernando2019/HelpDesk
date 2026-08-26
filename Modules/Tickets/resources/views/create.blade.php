@extends('layout.mainlayout')

@section('content')
        <div class="page-wrapper">
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

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3>
                                    Ticket
                                </h3>
                            </div>
                            <div class="card-body">
                                <form action="#" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 mb-2">
                                            <h3 class="text-info">INFORMACIÓN GENERAL</h3>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Título <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" name="title" placeholder="Añade un título al ticket">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Tipo <span class="text-danger">*</span></label>
                                                <select class="form-control" name="type">
                                                    <option>Selecciona un tipo de ticket</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Categoria <span class="text-danger">*</span></label>
                                                <select class="form-control" name="type">
                                                    <option>Selecciona una categoria</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Servicio <span class="text-danger">*</span></label>
                                                <select class="form-control" name="type">
                                                    <option>Selecciona un servicio</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">Prioridad  <span class="text-danger">*</span></label>
                                                <select class="form-control" name="type">
                                                    <option>Selecciona una prioridad </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-6"></div>
                                        <div class="col-md-12">
                                            <div class="mb-3">
                                                <label class="form-label">Descripción   <span class="text-danger">*</span></label>
                                                <textarea class="form-control" name="" id="" placeholder="Describe tu solicitud"></textarea>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-12 mt-2 mb-2">
                                            <h3 class="text-info">INFORMACIÓN ADICIONAL</h3>
                                        </div>

                                        <div class="col-md-6 d-flex justify-content-center">
                                            <style>
                                                /* Contenedor principal de la zona de arrastre */
                                                .drop-zone {
                                                  padding: 14px;
                                                  display: flex;
                                                  flex-direction: column;
                                                  align-items: center;
                                                  justify-content: center;
                                                  text-align: center;
                                                  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
                                                  font-weight: 500;
                                                  font-size: 1.2rem;
                                                  cursor: pointer;
                                                  border-radius: 10px;
                                                  transition: background-color 0.3s, border-color 0.3s;
                                                }

                                                /* Cambio de color interactivo al pasar el mouse */
                                                .drop-zone:hover {
                                                  background-color: #f8f9fa;
                                                  border-color: #007058;
                                                }

                                                /* Ocultar el input original de manera segura */
                                                .drop-zone__input {
                                                  display: none;
                                                }

                                                /* Estilo opcional para cuando el archivo ya está cargado (se gestiona con JS) */
                                                .drop-zone--over {
                                                  border-style: solid;
                                                  background-color: #e8f4f1;
                                                  color: #009578;
                                                }
                                            </style>

                                            <div class="w-100 drop-zone rounded border-grey bg-ocean">
                                              <span class="drop-zone__prompt">Agrega archivos</span>
                                              <small class="text-muted fs-11">Puedes cargar archivos PDF, JPG, PNG</small>
                                              <!-- El input real permanece oculto pero vinculado al flujo -->
                                              <input type="file" name="myFile" id="myFile" class="drop-zone__input">
                                            </div>
                                        </div>

                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label">URL</label>
                                                <input type="text" class="form-control" 
                                                name="url" 
                                                placeholder="Agregar enlace de ayuda complementaria">
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
