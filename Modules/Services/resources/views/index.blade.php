@extends('layout.mainlayout')

@section('title', 'HelpDesk | Categorías')

@section('content')
<style>

    .option-card-active,
    .option-card-active:focus,
    .option-card-active:active {
        box-shadow: 0 4px 12px rgba(14, 114, 255, 0.35) !important;
        border-color: #1556b13b !important;
        transform: translateY(-2px);
        transition: all 0.2s ease-in-out;
        outline: none !important;
    }

    .btn-category-pill:focus,
    .btn-category-pill:active {
        box-shadow: none;
        outline: none !important;
    }

    .select-color {
        border: 3px solid #3e3e3e;
    }

    .bg-light-blue {
        background: linear-gradient(135deg, #e0f2fe 0%, #f0f9ff 100%);
    }
    /* .card-category {
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
    } */
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

    /* Ocultar scrollbar pero mantener funcionalidad */
    .category-pills-container::-webkit-scrollbar {
        display: none;
    }
    .category-pills-container {
        -ms-overflow-style: none;
        scrollbar-width: none;
        transition: -webkit-mask-image 0.2s ease;
    }

    /* Máscara cuando está al inicio (desvanecer solo derecha) */
    .category-pills-container.mask-scroll-right {
        -webkit-mask-image: linear-gradient(to right, black 85%, transparent 100%);
        mask-image: linear-gradient(to right, black 85%, transparent 100%);
    }

    /* Máscara cuando está scrolleado al centro (desvanecer izquierda y derecha) */
    .category-pills-container.mask-scroll-both {
        mask-image: linear-gradient(to right, transparent 0%, black 5%, black 85%, transparent 100%);
    }

    /* Máscara cuando llega al final (desvanecer solo izquierda) */
    .category-pills-container.mask-scroll-left {
        -webkit-mask-image: linear-gradient(to right, transparent 0%, black 15%);
        mask-image: linear-gradient(to right, transparent 0%, black 15%);
    }

</style>

<div class="page-wrapper">
    <div class="content container-fluid">
        
        <!-- HEADER -->
        <div class="d-flex align-items-center justify-content-between mb-4">
            <div class="d-flex align-items-center gap-2">
                <i class="ti ti-hotel-service"></i>
                <h3 class="page-title mb-0 fw-bold text-dark">Servicios</h3>
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

            <!-- Cabecera de categorias -->
            <div class="col-md-12 mb-3">
                <div class="d-flex align-items-center gap-2 overflow-auto p-3 py-2 category-pills-container mask-scroll-both">
                    @forelse ($categorias as $cat)
                        <!-- categorías asociadas -->
                        <button type="button" 
                                class="mt-2 mb-2 {{$queryParamCard === $cat->id ? 'option-card-active' : ''}} btn btn-sm fs-10 shadow-sm btn-category-pill bg-white rounded-pill px-3 py-2 fs-13 fw-semibold text-dark text-nowrap" 
                                data-id="{{ $cat->id }}">
                            {{ $cat->name }}
                        </button>
                    @empty
                        
                    @endforelse
                </div>
            </div>

            <!-- TARJETA ESPECIAL: CREAR NUEVA CATEGORÍA -->

            <div class="col-md-4">
                <div data-bs-toggle="tooltip" class="card border shadow-sm rounded-4 team-card active-team-card overflow-hidden all-tugui-option-wave h-100" 
                     data-member-id="all">
                    <div class="card-body p-3 d-flex align-items-center gap-3 h-100">
                        <img src="/build/img/icons/tugui_en_computadora.png" alt="Tugui" style="width: 60px; height: 60px; object-fit: cover;">
                        <div class="title-all">
                            <button 
                                class="btn btn-mega rounded-pill px-3 py-2 fw-semibold d-flex align-items-center gap-1 shadow-sm"
                                id="modal-add-service">
                                <i class="ti ti-circle-plus fs-18"></i>
                                <span class="text-light">Agregar servicio</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARDS DE CATEGORÍAS -->
            @forelse($services as $service)
                @php
                    $color = $service?->color_service ?? null;
                @endphp
                <div class="col-md-4">
                    <div class="card card-service border shadow-sm rounded-4 p-3 d-flex flex-column justify-content-between h-100">
                        <div>
                            <!-- Header de la Card: Nombre + Icono Editar -->
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span 
                                @if (!$color)
                                 class="badge px-2 py-1 fs-12"
                                 style="background-color: #C4C4C4; text-wrap: wrap;"
                                @else
                                 class="badge px-2 py-1 fs-12"
                                 style="background-color: {{$color}}; text-wrap: wrap;"
                                @endif  
                                >
                                    {{ $service?->service_name ?? '' }}
                                </span>
                                <a href="javascript:void(0);" 
                                   class="edit-icon-btn edit-action-service" 
                                   data-id="{{ $service?->service_id ?? 0 }}"
                                   data-name="{{ $service?->service_name ?? '' }}" 
                                   data-description="{{ $service?->service_description ?? '' }}"
                                   data-category-id="{{ $service?->category_id ?? 0 }}"
                                   data-color="{{ $color ?? '#C4C4C4' }}"
                                   data-template="{{ $service?->service_template ?? '' }}"
                                   data-status="{{ $service?->service_status ?? 1 }}"
                                   data-details="{{ ($service?->first_name ?? '') . ' ' . ($service?->last_name ?? 'Un empleado') . ' creó este servicio el ' . \Carbon\Carbon::parse($service?->service_created_at)->translatedFormat('l d \d\e F \d\e\l Y \a \l\a\s h:i a') }}"
                                   data-bs-toggle="tooltip"
                                   title="Editar Servicio">
                                    <i class="ti ti-pencil fs-18"></i>
                                </a>
                            </div>

                            <!-- Descripción -->
                            <p class="text-muted fs-13 mb-0 lh-sm">
                                {{ $service?->service_description ?? 'Sin descripción disponible.' }}
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
            <div class="col-md-12 mb-3 gap-2 d-flex" style="justify-content: flex-end;">
                <button 
                    class="float-right btn btn-mega rounded-pill px-3 py-2 fw-semibold d-flex align-items-center gap-1 shadow-sm"
                    id="modal-add-service-table-action">
                    <i class="ti ti-circle-plus fs-18"></i>
                    <span class="text-light">Agregar servicio</span>
                </button>

                <select style="width: 250px;" name="category_query_string" id="category_query_string_select" class="form-select select2-categories">
                    <option value="" disabled selected hidden>Selecciona una categoría...</option>
                    @forelse ($categorias as $cat)
                        <option value="{{ $cat->id }}" 
                                {{$queryParamCard === $cat->id ? 'selected': ''}}
                                data-id="{{ $cat->id }}">
                            {{ $cat->name }}
                        </option>
                    @empty
                        <option value="" disabled>No hay categorías disponibles</option>
                    @endforelse
                </select>
            </div>
            <div class="col-md-12">
                <div class="card border-0 shadow-sm rounded-3">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4 py-3 text-muted fw-semibold fs-13">Categoría</th>
                                        <th class="ps-4 py-3 text-muted fw-semibold fs-13">Nombre</th>
                                        <th class="py-3 text-muted fw-semibold fs-13">Descripción</th>
                                        <th class="pe-4 py-3 text-end text-muted fw-semibold fs-13">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($services as $service)
                                        @php
                                            $color = $service?->color_service ?? null;
                                        @endphp
                                        <tr>
                                             <td class="ps-4 py-3 text-secondary fs-13">
                                                {{$service?->category_name ?? ''}}
                                            </td>

                                            <td class="ps-4 py-3">
                                                <div class="d-flex align-items-center gap-2">
                                                    <span class="rounded-circle" style="width: 10px; height: 10px; background-color: {{ $color ?? '#C4C4C4' }}; flex-shrink: 0;"></span>
                                                    <span class="fw-medium text-dark fs-14">{{ $service?->service_name ?? '' }}</span>
                                                </div>
                                            </td>

                                            <!-- Descripción -->
                                            <td class="py-3 text-secondary fs-13">
                                                {{ Str::limit($service?->service_description, 90, '...') }}
                                            </td>

                                            <!-- Botón de Acción / Editar -->
                                            <td class="pe-4 py-3 text-end">
                                                <a href="javascript:void(0);" 
                                                   class="edit-icon-btn edit-action-service" 
                                                   data-id="{{ $service?->service_id ?? 0 }}"
                                                   data-name="{{ $service?->service_name ?? '' }}" 
                                                   data-description="{{ $service?->service_description ?? '' }}"
                                                   data-category-id="{{ $service?->category_id ?? 0 }}"
                                                   data-color="{{ $color ?? '#C4C4C4' }}"
                                                   data-template="{{ $service?->service_template ?? '' }}"
                                                   data-status="{{ $service?->service_status ?? 1 }}"
                                                   data-details="{{ ($service?->first_name ?? '') . ' ' . ($service?->last_name ?? 'Un empleado') . ' creó este servicio el ' . \Carbon\Carbon::parse($service?->service_created_at)->translatedFormat('l d \d\e F \d\e\l Y \a \l\a\s h:i a') }}"
                                                   data-bs-toggle="tooltip"
                                                   title="Editar Servicio">
                                                    <i class="ti ti-pencil fs-18"></i>
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
            {{-- {{ $services->withQueryString()->links() }} --}}
        </div>

    </div>
</div>

@include('services::partials.modal-create-service')
@include('services::partials.modal-update-service')

@vite('Modules/Services/resources/assets/js/index.js')
@endsection