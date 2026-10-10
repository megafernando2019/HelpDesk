@extends('layout.mainlayout')

@section('title', 'HelpDesk | Etiquetas')

@section('content')
<style>
    .select-color {
        border: 3px solid #3e3e3e;
    }

    .bg-light-blue {
        background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%);
    }
    .card-category {
        border: 1px solid #f1f5f9;
        border-radius: 16px;
        background-color: #ffffff;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.03);
        transition: all 0.2s ease-in-out;
        min-height: 160px;
    }
    .card-category:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.06);
    }
    .badge-soft-purple {
        background-color: #f3e8ff;
        color: #6b21a8;
        font-weight: 600;
        border-radius: 8px;
    }
    .edit-icon-btn {
        color: #94a3b8;
        transition: color 0.15s ease;
        cursor: pointer;
    }
    .edit-icon-btn:hover {
        color: #475569;
    }

    .all-tugui-option-wave {
        background-image: url(http://127.0.0.1:8000/build/img/icons/wave_tugui.svg);
        background-repeat: no-repeat;
        background-position: bottom;
        cursor: pointer;
    }

</style>

<div class="page-wrapper">
    <div class="content container-fluid">
        
        <!-- HEADER -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center gap-2">
                <i class="ti ti-tag"></i>
                <h3 class="page-title mb-0 fw-bold text-dark">Etiquetas</h3>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted fs-13">Vista</span>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-info active display-kaban"><i class="ti ti-layout-grid"></i></button>
                    <button type="button" class="btn btn-sm btn-outline-info display-table"><i class="ti ti-list"></i></button>
                </div>
            </div>
        </div>

        <!-- GRID KABAN DE CATEGORÍAS -->
        <div class="row g-3" id="kanban-partial">

            <!-- TARJETA ESPECIAL: CREAR NUEVA CATEGORÍA -->

            <div class="col-md-4">
                <div data-bs-toggle="tooltip" class="card border shadow-sm rounded-4 team-card active-team-card overflow-hidden all-tugui-option-wave h-100" 
                     data-member-id="all">
                    <div class="card-body p-3 d-flex align-items-center gap-3 h-100">
                        <img src="/build/img/icons/tugui_en_computadora.png" alt="Tugui" style="width: 60px; height: 60px; object-fit: cover;">
                        <div class="title-all">
                            <button 
                                class="btn btn-mega rounded-pill px-3 py-2 fw-semibold d-flex align-items-center gap-1 shadow-sm"
                                id="modal-add-tag">
                                <i class="ti ti-circle-plus fs-18"></i>
                                <span class="text-light">Agregar etiqueta</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARDS DE ETIQUETAS -->
            @forelse($tags as $tag)
                @php
                    $color = $tag?->color ?? null;
                @endphp
                <div class="col-md-4">
                    <div class="card card-category border shadow-sm rounded-4 p-3 d-flex flex-column justify-content-between h-100">
                        <div>
                            <!-- Header de la Card: Nombre + Icono Editar -->
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span 
                                @if (!$color)
                                 class="badge px-2 py-1 fs-12"
                                 style="background-color: #C4C4C44D; color: #c4c4c4;"
                                @else
                                 class="badge px-2 py-1 fs-12"
                                 style="background-color: {{$color}}3D; color: {{$color}} !important;"
                                @endif  
                                >
                                    {{ $tag?->name ?? '' }}
                                </span>
                                <div class="d-flex container justify-content-end">
                                    <a href="javascript:void(0);" class="edit-icon-btn edit-action-tag" 
                                       data-id="{{ $tag?->id ?? 0 }}"
                                       data-name="{{ $tag?->name ?? '' }}" 
                                       data-description="{{ $tag?->description ?? '' }}"
                                       data-color="{{$color}}"
                                       data-status="{{$tag?->status ?? 0}}"
                                       data-logs='@json($tag->logs_actions)'
                                       data-bs-toggle="tooltip"
                                       title="Editar Etiqueta">
                                        <i class="ti ti-pencil fs-18"></i>
                                    </a>

    

                                    <!-- btn show -->
                                    <a href="javascript:void(0);"
                                           class="btn-show-tag edit-icon-btn"
                                           data-bs-toggle="tooltip"
                                           title="Ver Etiqueta"
                                           data-id="{{ $tag?->id ?? 0 }}"
                                           data-name="{{ $tag?->name ?? '' }}" 
                                           data-description="{{ $tag?->description ?? '' }}"
                                           data-color="{{$color}}"
                                           data-status="{{$tag?->status ?? 0}}"
                                           data-created-at="{{ ($tag?->first_name ?? '') . ' ' . ($tag?->last_name ?? 'Un empleado') . ' creó esta etiqueta el ' . (\Carbon\Carbon::parse($tag?->created_at)->translatedFormat('l d \d\e F \d\e\l Y \a \l\a\s h:i a')) }}"               
                                    >
                                        <i class="ti ti-eye fs-18"></i>
                                    </a>
                                </div>
                            </div>

                            <!-- Descripción -->
                            <p class="text-muted fs-13 mb-0 lh-sm">
                                {{ $tag?->description ?? 'Sin descripción disponible.' }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-4">
                    <p class="text-muted">No se encontraron categorías registradas.</p>
                </div>
            @endforelse

        </div>

        <!-- TABLA DE CATEGORÍAS -->
        <div class="row d-none" id="table-partial">
            <div class="col-md-12 mb-2">
                <button 
                    class="float-right btn btn-mega rounded-pill px-3 py-2 fw-semibold d-flex align-items-center gap-1 shadow-sm"
                    id="modal-add-tag-table-action">
                    <i class="ti ti-circle-plus fs-18"></i>
                    <span class="text-light">Agregar etiqueta</span>
                </button>
            </div>
            <div class="col-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3 text-muted fw-semibold fs-13">Nombre</th>
                                        <th class="py-3 text-muted fw-semibold fs-13">Descripción</th>
                                        <th class="pe-4 py-3 text-end text-muted fw-semibold fs-13">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tags as $tag)
                                        <tr>
                                            <!-- Nombre -->
                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="rounded-circle" style="width: 10px; height: 10px; background-color: {{ $tag->color ?? '#C4C4C4' }}; flex-shrink: 0; opacity: 30%;"></span>
                                                    <span class="fw-medium fs-14" style="color: {{$tag->color ?? '#C4C4C4'}};">{{ $tag->name }}</span>
                                                </div>
                                            </td>

                                            <!-- Descripción -->
                                            <td class="py-3 text-secondary fs-13">
                                                {{ Str::limit($tag->description, 90, '...') }}
                                            </td>

                                            <!-- Botón de Acción / Editar -->
                                            <td class="pe-4 py-3 d-flex align-items-center">
                                                <a href="javascript:void(0);" 
                                                   class="btn btn-icon btn-sm btn-ghost-secondary edit-action-tag rounded-circle" 
                                                   data-id="{{ $tag->id }}"
                                                   data-name="{{ $tag->name }}" 
                                                   data-description="{{ $tag->description }}"
                                                   data-color="{{ $tag->color ?? '#C4C4C4' }}"
                                                   data-status="{{ $tag->status ?? 1 }}"
                                                   data-logs='@json($tag->logs_actions)'
                                                   data-bs-toggle="tooltip"
                                                   title="Editar Etiqueta">
                                                    <i class="ti ti-pencil fs-18 text-muted"></i>
                                                </a>
                                                
                                                <!-- btn show -->
                                                <a href="javascript:void(0);"
                                                       class="btn-show-tag btn-icon"
                                                       data-bs-toggle="tooltip"
                                                       title="Ver Etiqueta"
                                                       data-id="{{ $tag?->id ?? 0 }}"
                                                       data-name="{{ $tag?->name ?? '' }}" 
                                                       data-description="{{ $tag?->description ?? '' }}"
                                                       data-color="{{$color}}"
                                                       data-status="{{$tag?->status ?? 0}}"
                                                       data-created-at="{{ ($tag?->first_name ?? '') . ' ' . ($tag?->last_name ?? 'Un empleado') . ' creó esta etiqueta el ' . (\Carbon\Carbon::parse($tag?->created_at)->translatedFormat('l d \d\e F \d\e\l Y \a \l\a\s h:i a')) }}"
                                                       
                                                >
                                                    <i class="ti ti-eye fs-18 text-muted"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="3" class="text-center py-4 text-muted fs-14">
                                                No se encontraron categorías registradas.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- CONTROLES DE PAGINACIÓN -->
        <div class="d-flex justify-content-end mt-4">
            {{ $tags->withQueryString()->links() }}
        </div>

    </div>
</div>

@include('tags::partials.modal-create-tag')
@include('tags::partials.modal-show-tag')
@include('tags::partials.modal-update-tag')

@vite('Modules/Tags/resources/assets/js/index.js')
@endsection