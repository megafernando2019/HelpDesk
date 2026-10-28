@extends('layout.mainlayout')

@section('title', 'HelpDesk | Reincidencias')

@section('content')
@include('recurringincidents::partials.show_tickets')

    <div class="page-wrapper">
        <div class="content container-fluid">
            <div class="row g-3">

                <!-- Usuarios con incidencias -->
                <div class="col-12 col-md-4">
                    <div style="background-color: #f3f6ff;" class="card border border-info rounded-4 p-2 shadow-sm">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                             
                                <img src="{{asset('build/img/icons/tugui_en_computadora.png')}}" alt="Usuarios" style="height: 100px;
                                width: 140px;">
                            </div>
                            <div>
                                <h2 class="fw-bold mb-0 text-dark total_usuarios">0</h2>
                                <span class="text-muted small">Usuarios con incidencias</span>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Servicios afectados -->
                <div class="col-12 col-md-4">
                    <div style="background-color: #ffecec;" class="card border border-danger rounded-4 p-2 shadow-sm">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <!-- Reemplaza con la ruta de tu icono -->
                                 <img src="{{asset('build/img/file_incidents_2-removebg-preview.png')}}" alt="Servicios afectados" style="height: 100px;
                                width: 90px;">
                            </div>
                            <div>
                                <h2 class="fw-bold mb-0 text-dark total_servicios">0</h2>
                                <span class="text-muted small">Servicios afectados</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Total de tickets recurrentes -->
                <div class="col-12 col-md-4">
                    <div class="card rounded-4 p-2 shadow-sm" style="border: 1px solid #a855f7 !important; background-color: #faf8ff !important;">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <!-- Reemplaza con la ruta de tu icono -->
                                 <img src="{{asset('build/img/file_incidents_3-removebg-preview.png')}}" alt="Tickets recurrentes" style="height: 100px;
                                width: 90px;">
                            </div>
                            <div>
                                <h2 class="fw-bold mb-0 text-dark total_row_tickets">0</h2>
                                <span class="text-muted small">Total de tickets recurrentes</span>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- Fila principal de filtros -->
            <div class="row g-3 align-items-center mb-4">
    
                <!-- Rango de fecha -->
                <div class="col-md-3 p-2">
                   
                    <div class="input-group">
                        <span class="input-group-text text-muted ps-1">
                            <!-- Icono de calendario -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-calendar-week">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12" />
                                <path d="M16 3v4" />
                                <path d="M8 3v4" />
                                <path d="M4 11h16" />
                                <path d="M7 14h.013" />
                                <path d="M10.01 14h.005" />
                                <path d="M13.01 14h.005" />
                                <path d="M16.015 14h.005" />
                                <path d="M13.015 17h.005" />
                                <path d="M7.01 17h.005" />
                                <path d="M10.01 17h.005" />
                            </svg>
                        </span>
                        <input type="text" id="dateRangePicker" class="form-control" placeholder="Selecciona rango de fecha">
                    </div>
                </div>

                <!-- Usuario -->
                <div class="col-md-3 p-2">
                    <div class="input-group">
                        <span class="input-group-text text-muted ps-1">
                            <!-- Icono de usuario -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-user">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M8 7a4 4 0 1 0 8 0a4 4 0 0 0 -8 0"></path>
                                <path d="M6 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2"></path>
                            </svg>
                        </span>
                        <div class="w-100">
                            <select class="form-control" id="filterUser">
                                <option value="">Usuario</option>
                                 @forelse ($usersAll as $item)
                                <option value="{{$item?->id ?? 0}}">{{$item?->first_name ?? ''}} {{$item?->last_name ?? ''}}</option>
                                 @empty
                                     
                                 @endforelse
                            </select>
                        </div>
                    </div>
                </div>

                <style>
               
                    
                </style>

                <!-- Categoría(s) -->
                <div class="col-md-3 p-2">
                    <div class="input-group">
                        <span class="input-group-text  text-muted ps-1">
                            <!-- Icono de categoría -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-stack">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                <path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" />
                                <path d="M5 21h14" />
                                <path d="M5 18h14" />
                                <path d="M5 15h14" />
                            </svg> 
                            
                        </span>
                        <select class="form-control" id="filterCategory">
                            <option  value="">Selecciona categoría(s)</option>
                            @forelse ($categorias as $item)
                            <option value="{{$item?->id ?? 0}}">{{$item?->name ?? ''}}</option>
                            @empty
                                
                            @endforelse
                        </select>
                    </div>
                </div>

                <!-- Servicio(s) -->
                <div class="col-md-3 p-2">
                    <div class="input-group">
                        <span class="input-group-text  text-muted ps-1">
                            <!-- Icono de servicio -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-hotel-service">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M8.5 10a1.5 1.5 0 0 1 -1.5 -1.5a5.5 5.5 0 0 1 11 0v10.5a2 2 0 0 1 -2 2h-7a2 2 0 0 1 -2 -2v-2c0 -1.38 .71 -2.444 1.88 -3.175l4.424 -2.765c1.055 -.66 1.696 -1.316 1.696 -2.56a2.5 2.5 0 1 0 -5 0a1.5 1.5 0 0 1 -1.5 1.5" />
                            </svg>
                        </span>
                        <select class="form-control" id="filterService">
                            <option  value="">Selecciona servicio(s)</option>
                             @forelse ($servicios as $item)
                             <option value="{{$item?->id ?? 0}}">{{$item?->name ?? ''}}</option>
                            @empty
                                
                            @endforelse
                        </select>
                    </div>
                </div>

                <!-- Estatus -->
                {{-- <div class="col-md-6">
                    <div class="input-group border px-2 py-1">
                        <span class="input-group-text  text-muted ps-1">
                            <!-- Icono de estatus -->
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-loader-4">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M12 21v-3m6.36 .36l-2.12 -2.12m4.76 -4.24h-3m.36 -6.36l-2.12 2.12m-4.24 -4.76v3m-6.36 -.36l2.12 2.12m-3.76 4.24h2m1 4.95l.71 -.71" />
                            </svg>
                        </span>
                        <select class="form-select border-0 bg-transparent shadow-none form-select-sm" id="filterStatus">
                            <option  value="">Estatus</option>
                            @forelse ($ctxStatus as $item)
                            <option value="{{$item?->id ?? 0}}">{{$item?->name ?? ''}}</option>
                            @empty
                                
                            @endforelse
                        </select>
                    </div>
                </div> --}}

            </div>

           
            <!-- datatable -->
            <div class="row">
                <!-- Buscador General (Input de texto) -->
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3"></div>
                <div class="col-md-3 mb-2">
                    <div class="input-group bg-white rounded-3 shadow-sm border px-2 py-1">
                        <span class="input-group-text bg-transparent border-0 text-muted ps-1">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.444.066.915.068l3.5 3.5a.75.75 0 1 0 1.06-1.06l-3.5-3.5a6.5 6.5 0 0 0-.077-.915zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                            </svg>
                        </span>
                        <input type="text" id="searchInput" class="float-right form-control border-0 bg-transparent shadow-none form-control-sm" placeholder="Buscar...">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="card border-0 shadow-sm rounded-4 p-3 bg-white">
                        <div class="table-responsive">
                            <table id="recurringTable" class="table table-hover align-middle mb-0">
                                <thead class="text-muted small text-uppercase bg-light">
                                    <tr>
                                        <th class="py-3 ps-3 rounded-start">Usuario</th>
                                        <th class="py-3">Categoría</th>
                                        <th class="py-3">Servicio</th>
                                        <th class="py-3">Tickets</th>
                                        <th class="py-3 pe-3 rounded-end">Estatus</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- Si usas datos estáticos de prueba o iteración con Blade -->
                                    <tr>
                                        <td class="ps-3 fw-medium text-dark">Cargando...</td>
                                        <td class="text-muted">Cargando...</td>
                                        <td class="text-muted">Cargando...</td>
                                        <td>
                                            Cargando...
                                            <button class="btn btn-sm btn-link text-muted p-0 ms-1" title="Ver detalle">
                                                <!-- Icono de ojo -->
                                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 b8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                                </svg>
                                            </button>
                                        </td>
                                        <td>
                                            <span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-normal">Cargando...</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 mb-2">
                    <!-- Contenedor para los botones de paginación AJAX -->
                    <div class="d-flex justify-content-between align-items-center mt-3" id="ajaxPagination">
                        <!-- Se llenará dinámicamente desde JS -->
                    </div>
                </div>
            </div>
        </div>
    </div>

   @vite('Modules/RecurringIncidents/resources/assets/js/app.js')
@endsection