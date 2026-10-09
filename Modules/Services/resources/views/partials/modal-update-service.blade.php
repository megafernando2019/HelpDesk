<!-- Modal Editar Servicio -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-3" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
            
            <!-- Header -->
            <div class="modal-header border-0 pb-0 align-items-start">
                <div class="d-flex align-items-start gap-2">
                    <div>
                        <i class="ti ti-hotel-service text-secondary mt-1"></i>
                        <span class="fw-bold text-dark">Editar servicio</span>
                    </div>
                </div>
                <button type="button" class="btn-close text-muted" style="color: #000!important; background-color:#fff !important;" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body py-3">
                <form id="editServiceForm">
                    <input type="hidden" id="edit_service_id" name="id">

                    <div class="row g-3">
                        <!-- Campo Nombre -->
                        <div class="col-md-12">
                            <label for="edit_service_name" class="form-label text-muted fs-13 mb-1 fw-semibold">Nombre</label>
                            <input type="text" class="form-control rounded-pill px-3 fs-13" id="edit_service_name" name="name" placeholder="Nombre del servicio">
                        </div>

                        <!-- Campo Descripción -->
                        <div class="col-md-12">
                            <label for="edit_service_description" class="form-label text-muted fs-13 mb-1 fw-semibold">Descripción</label>
                            <input type="text" class="form-control rounded-pill px-3 fs-13" id="edit_service_description" name="description" placeholder="Descripción del servicio">
                        </div>

                        <!-- Campo Categoría -->
                        <div class="col-md-12">
                            <label for="edit_category_id" class="form-label text-muted fs-13 mb-1 fw-semibold">Categoría</label>
                            <select name="category_id" class="form-select rounded-pill fs-13 edit_category_id" id="edit_category_id">
                                @forelse ($categorias as $item)
                                    <option value="{{ $item?->id ?? 0 }}">
                                        {{ $item?->name ?? '' }}
                                    </option>
                                @empty
                                    <option value="" disabled>No hay categorías disponibles</option>
                                @endforelse
                            </select>
                        </div>

                        <!-- Checkbox Aplicar Plantilla -->
                        <div class="col-md-12 mb-2">
                            <div class="form-check d-flex align-items-center gap-2 ps-0">
                                <input class="form-check-input ms-0 mt-0" type="checkbox" id="edit_applyTemplateCheck" name="has_template" value="1">
                                <label class="form-check-label fs-14 fw-medium text-dark" for="edit_applyTemplateCheck">
                                    Aplicar Plantilla
                                </label>
                            </div>
                        </div>

                        <!-- Textarea de Plantilla -->
                        <div class="col-md-12 mb-2 d-none" id="edit_templateContainer">
                            <label for="edit_template" class="form-label text-muted fs-13 mb-1 fw-semibold">Plantilla</label>
                            <textarea name="template" id="edit_template" class="form-control" rows="4" placeholder="Escribe el contenido de la plantilla aquí..."></textarea>
                        </div>

                        <!-- Selector de Color -->
                        <div class="col-md-12">
                            <label class="form-label text-muted fs-13 mb-2 fw-semibold">Elige un color para identificar la etiqueta</label>
                            <div class="d-flex flex-wrap gap-2 color-picker-options">
                                @php
                                    $colors = ['#C4C4C4', '#FF8A8A', '#FFB07C', '#FFD966', '#FFF275', '#E2C299', '#72D8A7', '#6CD2EC', '#A3EAD8', '#6C9CFF', '#B2A2FF', '#E2A2FF', '#FFA2E5', '#FFA2BD', '#FFBDB2', '#A0A0A0'];
                                @endphp
                                @foreach ($colors as $color)
                                    <label class="color-option" style="background-color: {{ $color }}; width: 32px; height: 32px; border-radius: 8px; cursor: pointer;">
                                        <input type="radio" name="edit_color" value="{{ $color }}" class="d-none">
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Switch de Estado -->
                        <div class="col-md-12">
                            <label class="form-label text-muted fs-13 mb-1 fw-semibold">Estado</label>
                            <div class="form-check form-switch d-flex align-items-center gap-2 ps-0">
                                <input class="form-check-input ms-0 mt-0" type="checkbox" id="edit_serviceStatus" role="switch">
                                <label class="form-check-label fs-14 fw-medium text-dark" for="edit_serviceStatus" id="edit_serviceStatusLabel">
                                    Activado
                                </label>
                            </div>
                        </div>

                        <!-- Sección de Detalles del Creador -->
                        <div class="col-md-12">
                            <label class="form-label text-muted fs-13 mb-1 fw-semibold">Detalles</label>
                            <div class="d-flex align-items-center gap-2">
                                <span class="badge rounded-circle bg-primary p-1" style="width: 12px; height: 12px;"></span>
                                <span class="fs-13 text-secondary" id="edit_serviceDetailsText">--</span>
                            </div>
                        </div>

                        <!-- Botón Guardar Cambios -->
                        <div class="col-md-12 text-center pt-2">
                            <button type="submit" class="btn btn-mega rounded-pill update-modal-service">
                                <i class="ti ti-circle-plus fs-18"></i>
                                Guardar cambios
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border: none;"></div>
        </div>
    </div>
</div>