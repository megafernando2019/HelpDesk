@extends('layout.mainlayout')

@section('content')
        <div class="page-wrapper">
            <div class="content container-fluid">
            
                <div class="page-header">
                    <div class="row">
                        <div class="col-md-12">
                            <h3 class="page-title">
                                <i class="ti ti-ticket"></i>
                                Vista de ticket
                            </h3>
                        </div>
                    </div>
                </div>

                <div class="row current-info content-show" data-ticket-id="{{$ticket?->id ?? 0}}">
                    <!-- Detalles del ticket col-md-9 -->
                    <div class="col-md-8 bg-white shadow current-rounded">
                        <div style="border: none;" class="card">
                            <div class="card-header" style="border: none;">
                                <h3>
                                    {{$ticket?->uid ?? 'Folio no disponible'}}
                                </h3>

                                <div class="info-user-aut mt-2">
                                    <div class="d-flex gap-2 align-items-center">
                                        <div class="minimalist-avatar">
                                            <div class="bg-avatar">
                                                <span style="
                                                    background-color: #edcda6; 
                                                    color: #fafafa !important;
                                                    padding: .5em;
                                                    width: 40px;
                                                    height: 40px;
                                                    border-radius: 50%;
                                                    font-weight: bold;
                                                    text-align: center;" class="profile-acount-initials">
                                                    {{$initials}}
                                                </span>
                                            </div>
                                           
                                        </div>
                                        <div class="info-user-auth-heldesk">
                                                <p class="p-0 m-0">
                                                    {{$full_name}} <i class="ti ti-point"></i> {{$user?->department?->name ?? 'Departamento no disponible'}}
                                                </p>
                                                <small class="text-muted">{{$user?->email}}</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                    <!-- <informacion:general> -->
                                    <div style="border: 1px solid #eee;" class="p-3 current-rounded mb-3">
                                        <div class="row">
                                            <div class="col-md-12 mb-2">
                                                <h3 class="text-info">INFORMACIÓN GENERAL</h3>
                                            </div>
                                            <!-- Categoria y titulo -->
                                            <div class="col-md-2 mb-2">
                                                <i class="ti ti-writing"></i> Título
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <strong class="text-mega float-left">{{$ticket?->uid ?? 'Dato no disponible'}}</strong>
                                                <span class="text-mega">{{$ticket?->title ?? 'Dato no disponible'}}</span>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <i class="ti ti-file-stack"></i> Categoria
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <p class="badge rounded float-left" style="background: #ff751f32; color: #2b2b2b;">
                                                    {{$ticket?->ticketService?->category?->name ?? 'Dato no disponible'}}
                                                </p>
                                            </div>
                                            <!-- servicio y fecha de creación -->
                                            <div class="col-md-2 mb-2">
                                                <i class="ti ti-hotel-service"></i> Servicio
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                 <p class="badge rounded float-left" style="background: #5ce1e655; color: #0097b2;">
                                                    {{$ticket?->ticketService?->name ?? 'Dato no disponible'}}
                                                </p>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <i class="ti ti-calendar-plus"></i> Creado
                                            </div>
                                            <div class="col-md-4 mb-2 d-flex align-items-center">
                                                <p class="p-0 m-0 float-left">
                                                  
                                                   {{ucfirst($ticket?->created_at->locale('es')->translatedFormat('l'))}}, 
                                                   {{$ticket?->created_at->format('d')}} 
                                                   de {{$ticket?->created_at->locale('es')->translatedFormat('F')}}  
                                                   del {{$ticket?->created_at->format('Y')}}
                                                </p>
                                            </div>
                                            <!-- Prioridad y ultima actiualizacion -->
                                            <div class="col-md-2 mb-2">
                                                <i class="ti ti-pin"></i> Prioridad
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                 <p class="badge rounded float-left" style="background: #ff575753; color: #ff5757;">
                                                    <i class="ti ti-pin"></i> {{$ticket?->priority?->name ?? 'Dato no disponible'}}
                                                </p>
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <i class="ti ti-calendar-time"></i> Ultima actualización
                                            </div>
                                            <div class="col-md-4 mb-2 d-flex align-items-center">
                                                <p class="p-0 m-0 float-left">
                                                   
                                                   {{ucfirst($ticket?->updated_at?->locale('es')->translatedFormat('l'))}}, 
                                                   {{$ticket?->updated_at->format('d')}} 
                                                   de {{$ticket?->updated_at->locale('es')->translatedFormat('F')}}  
                                                   del {{$ticket?->updated_at->format('Y')}}
                                                </p>
                                            </div>
                                            <!-- Descripción y estatus -->
                                            <div class="col-md-2 mb-2">
                                                <i class="ti ti-text-caption"></i> Descripción
                                            </div>
                                            <div class="col-md-4 mb-2">  
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <i class="ti ti-calendar-plus"></i> Estatus
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <p class="badge rounded float-left" style="background: #eee; color:#2b2b2b;">
                                                    <i class="ti ti-loader"></i>
                                                    {{$ticket?->status?->name}}
                                                </p>
                                            </div>
                                            <div class="col-md-12">
                                               <textarea disabled class="form-control" name="" id="" rows="3">{{$ticket?->description ?? ''}}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- <informacion:general /> -->

                                    <!-- <informacion:adicional> -->
                                    <div style="border: 1px solid #eee;" class="p-3 current-rounded">
                                        <div class="row">
                                            <div class="col-md-12 mt-2 mb-2">
                                                <h3 class="text-info">INFORMACIÓN ADICIONAL</h3>
                                            </div>
                                            <!-- attachments y url -->
                                            <div class="col-md-2 mb-2">
                                                <i class="ti ti-file"></i> Archivos adjuntos
                                            </div>
                                            <div class="col-md-4 mb-2" style="font-size: 1.2em;">
                                                
                                                @forelse ($attachments as $file)
                                                    @php
                                                        //Extension del archivo
                                                        $mime = $file?->mime_type ?? null;
                                                    @endphp

                                                    @switch($mime)
                                                        @case(Str::contains($mime, 'pdf'))
                                                            <a href="{{Storage::url($file->file_path ?? '')}}" 
                                                                target="_blank" rel="noopener noreferrer" 
                                                                class="badge rounded" style="background: #ff575753; color: #ff5757;">
                                                                <i class="ti ti-file-type-pdf"></i>
                                                            </a> 
                                                            @break
                                                        @case(Str::contains($mime, 'png'))
                                                            <a href="{{Storage::url($file->file_path ?? '')}}" 
                                                                target="_blank" rel="noopener noreferrer" 
                                                                class="badge rounded" style="background: #ffbd594e; color: #ffbd59;">
                                                                <i class="ti ti-file-type-png"></i>
                                                            </a> 
                                                            
                                                            @break
                                                        @case(Str::contains($mime, 'jpg'))
                                                            <a href="{{Storage::url($file->file_path ?? '')}}" 
                                                                target="_blank" rel="noopener noreferrer" 
                                                                class="badge rounded" 
                                                                style="background: #5ce1e655; color: #0097b2;">
                                                                <i class="ti ti-file-type-jpg"></i>
                                                            </a> 
                                                            @break
                                                        @default
                                                            <a href="{{Storage::url($file->file_path ?? '')}}" 
                                                                target="_blank" rel="noopener noreferrer" 
                                                                class="badge rounded" 
                                                                style="background: #5ce1e655; color: #0097b2;">
                                                                <i class="ti ti-file-type-jpg"></i>
                                                            </a> 
                                                    @endswitch
                                                @empty
                                                    Sin archivos por mostrar.
                                                @endforelse
                                            </div>
                                            <div class="col-md-2 mb-2">
                                                <i class="ti ti-link"></i> URL
                                            </div>
                                            
                                            <div class="col-md-4 mb-2">
                                                <a class="fs-12 float-left" href="{{$ticket?->url?->url ?? ''}}" target="_blank" rel="noopener noreferrer">
                                                    {{$ticket?->url?->url ?? ''}}
                                                </a>
                                            </div>
                                            <!-- attachments y url -->
                                        </div>
                                        <form action="" class="action-save-observation" method="post">
                                            <div class="row">
                                                 <!-- etiquetas -->
                                                <div class="col-md-2 mb-2">
                                                    <i class="ti ti-file"></i> Etiquetas
                                                </div>
                                                <div class="col-md-10 mb-2">
                                                    <div class="">
                                                        <select 
                                                            name="tags[]" 
                                                            id="tags-select" 
                                                            class="form-control select2" 
                                                            multiple="multiple" 
                                                            data-placeholder="Agregar etiquetas que ayuden a la atención del ticket">
                                                        </select>
                                                    
                                                    </div>
                                                
                                                </div>
                                                <!-- etiquetas -->
                                                <!-- observaciones -->
                                                <div class="col-md-3">
                                                    <i class="ti ti-edit"></i>
                                                    Observaciones
                                                </div>
                                                <div class="col-md-9">
                                                    <button class="action-save-observation btn btn-grey btn-sm float-right">
                                                         <i class="ti ti-edit"></i>
                                                        Guardar observación
                                                    </button>
                                                </div>
                                                <div class="col-md-12 mt-2 focus-area">
                                                    <textarea 
                                                     class="form-control observation_d"
                                                     name="observation_d" 
                                                     id="" 
                                                     rows="3" 
                                                     placeholder="Agregar observación">{{$ticket?->observation?->description ?? ''}}</textarea>
                                                </div>
                                            </div>
                                            <input type="hidden" class="record-status_id" 
                                                   name="status_id" value="{{$ticket?->status_id ?? 0}}">
                                            <input type="hidden" class="record-ticket-id" 
                                                   name="ticket_id" value="{{$ticket?->id ?? 0}}">
                                            <input type="hidden" class="record-ticket_priority_id" 
                                                   name="ticket_priority_id" value="{{$ticket?->ticket_priority_id ?? 0}}">
                                            <input type="hidden" class="record-user-id" 
                                                   name="user_id" value="{{$ticket?->user_id ?? 0}}">
                        
                                        </form>
                                    </div>
                                    <!-- <informacion:adicional /> -->
                            </div>
                            <div class="card-footer border-none" style="border: none;"></div>
                        </div>
                    </div>
                    
                    <!-- Acciones col-md-3 -->
                    <div class="col-md-4">
                        <div class="card shadow current-rounded" style="border: none;">
                            <div style="border: none;" class="card-header d-flex justify-content-between">
                                <h3>
                                    Encargado
                                </h3>

                                <button {{$currentUserAssing === 0 ? 'disabled' : ''}} 
                                        class="btn btn-sm {{$currentUserAssing === 0 ? 'btn-grey' : 'btn-mega'}} btn-assign-users"
                                        data-exist-user-assing='@json($UserAssignEntity)'
                                        >
                                    <i 
                                      class="{{$currentUserAssing === 0 ? 'ti ti-user-check' 
                                                                       : 'ti ti-replace-user'}}"></i>
                                    {{$currentUserAssing === 0 ? 'Confirmar asignación' : 'Confirmar reasignación'}}
                                </button>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        @if ($ticket)
                                            @if ($ticket->status_id === 5 || $ticket->status_id === 4)
                                                @include('tickets::partials.show.view-user-default-assign',
                                                    [
                                                        'supportUsers' => $supportUsers,
                                                        'currentUserAssing' => $currentUserAssing
                                                    ]
                                                )
                                            @else
                                                @include(
                                                    'tickets::partials.show.view-user-permision-action',
                                                        [
                                                            'supportUsers' => $supportUsers,
                                                            'currentUserAssing' => $currentUserAssing
                                                        ]
                                                    )
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div  style="border: none;" class="card-footer text-body-secondary"></div>
                        </div>

                        <div class="card shadow current-rounded" style="border: none;">
                            <div style="border: none;" class="card-header">
                                <h3>
                                    Acciones rápidas
                                </h3>
                            </div>
                            <div class="card-body">
                                <div class="d-flex gap-2 icons-group-actions">
                                    <button type="button" 
                                            class="btn btn-status-action"
                                            data-status="2"
                                            data-name="En proceso">
                                        <i class="ti ti-progress-check"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-status-action"
                                            data-status="6"
                                            data-name="Cancelado">
                                        <i class="ti ti-cancel"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn btn-status-observation"
                                            >
                                        <i class="ti ti-edit-circle"></i>
                                    </button>
                                </div>
                            </div>
                            <div style="border: none;" 
                                 class="card-footer text-body-secondary"></div>
                        </div>
                        
                        <div style="border: none;" class="card shadow current-rounded">
                            <div style="border: none;" class="card-header">Detalle</div>
                            <div class="card-body">
                                <div data-logs='@json($ticket?->logs ?? collect())'
                                     class="ticket-log-chanel-endpoint">
                                </div>
                            </div>
                            <div style="border: none;" class="card-footer text-body-secondary"></div>
                        </div>
                        
                    </div>
                </div>

            </div>
        </div>
@endsection