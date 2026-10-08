@extends('layout.mainlayout')

@section('title', 'HelpDesk | Categorías')

@section('content')
<style>
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
                <i class="ti ti-file-stack"></i>
                <h3 class="page-title mb-0 fw-bold text-dark">Categorías</h3>
            </div>
            <div class="d-flex align-items-center gap-2">
                <span class="text-muted fs-13">Vista</span>
                <div class="btn-group" role="group">
                    <button type="button" class="btn btn-sm btn-primary active"><i class="ti ti-layout-grid"></i></button>
                    <button type="button" class="btn btn-sm btn-outline-secondary"><i class="ti ti-list"></i></button>
                </div>
            </div>
        </div>

        <!-- GRID DE CATEGORÍAS -->
        <div class="row g-3">

            <!-- TARJETA ESPECIAL: CREAR NUEVA CATEGORÍA -->

            <div class="col-md-4">
                <div data-bs-toggle="tooltip" title="Ver todo" class="card border shadow-sm rounded-4 team-card active-team-card overflow-hidden all-tugui-option-wave h-100" 
                     data-member-id="all">
                    <div class="card-body p-3 d-flex align-items-center gap-3 h-100">
                        <img src="/build/img/icons/tugui_en_computadora.png" alt="Tugui" style="width: 60px; height: 60px; object-fit: cover;">
                        <div class="title-all">
                            <button 
                                class="btn btn-mega rounded-pill px-3 py-2 fw-semibold d-flex align-items-center gap-1 shadow-sm"
                                id="modal-add-category">
                                <i class="ti ti-circle-plus fs-18"></i>
                                <span class="text-light">Agregar categoría</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CARDS DE CATEGORÍAS (ITERACIÓN DE LA PAGINACIÓN) -->
            @forelse($categories as $category)
                <div class="col-md-4">
                    <div class="card card-category border shadow-sm rounded-4 p-3 d-flex flex-column justify-content-between h-100">
                        <div>
                            <!-- Header de la Card: Nombre + Icono Editar -->
                            <div class="d-flex align-items-center justify-content-between mb-2">
                                <span class="badge badge-soft-purple px-2 py-1 fs-12">
                                    {{ $category?->name ?? '' }}
                                </span>
                                <a href="javascript:void(0);" class="edit-icon-btn" data-id="{{ $category->id ?? 0 }}" data-uid="{{ $category->uid ?? '' }}" title="Editar Categoría">
                                    <i class="ti ti-pencil fs-18"></i>
                                </a>
                            </div>

                            <!-- Descripción -->
                            <p class="text-muted fs-13 mb-0 lh-sm">
                                {{ $category->description ?? 'Sin descripción disponible.' }}
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

        <!-- CONTROLES DE PAGINACIÓN (simplePaginate renderiza Anterior / Siguiente) -->
        <div class="d-flex justify-content-end mt-4">
            {{ $categories->withQueryString()->links() }}
        </div>

    </div>
</div>

@include('categories::partials.modal-create-category')

@vite('Modules/Categories/resources/assets/js/index.js')
@endsection