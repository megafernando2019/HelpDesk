   <!-- Modal Agregar  -->
<div class="modal fade" id="addTagModal" tabindex="-1" aria-labelledby="addTagModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-3" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
            
            <!-- Header -->
            <div class="modal-header border-0 pb-0 align-items-start">
                <div class="d-flex align-items-start gap-2">
                    <div>
                        <i class="ti ti-tag text-secondary fs-2 mt-1"></i>
                        Agregar etiqueta
                    </div>
                </div>
                <button 
                 type="button"
                 style="color: #000!important;background-color:#fff !important;"
                 class="btn-close text-muted"
                 data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <!-- Body -->
            <div class="modal-body py-3">
                <form id="addTagForm">
                    <div class="row g-3">
                        <!-- Campo Nombre -->
                        <div class="col-md-12">
                            <label for="tag_name" class="form-label text-muted fs-13 mb-1 fw-semibold">Nombre</label>
                            <input type="text" class="form-control rounded-pill px-3 fs-13" id="tag_name" 
                            name="name" placeholder="Agrega un nombre a la etiqueta">
                        </div>

                        <!-- Campo Descripción -->
                        <div class="col-md-12">
                            <label for="tag_description" class="form-label text-muted fs-13 mb-1 fw-semibold">Descripción</label>
                            <input type="text" class="form-control rounded-pill px-3 fs-13" 
                            id="tag_description" name="description" placeholder="Agrega una descripción para la etiqueta">
                        </div>

                        <!-- Selector de Color -->
                        <div class="col-md-12">
                            <label class="form-label text-muted fs-13 mb-2 fw-semibold">Elige un color para identificar la etiqueta</label>
                            <div class="d-flex flex-wrap gap-2 color-picker-options">
                                <label class="color-option" style="background-color: #C4C4C4; width: 32px; height: 32px; border-radius: 8px; cursor: pointer;">
                                    <input type="radio" name="color" value="#C4C4C4" class="d-none" checked>
                                </label>
                                <label class="color-option" style="background-color: #FF8A8A; width: 32px; height: 32px; border-radius: 8px; cursor: pointer;">
                                    <input type="radio" name="color" value="#FF8A8A" class="d-none">
                                </label>
                                <label class="color-option" style="background-color: #FFB07C; width: 32px; height: 32px; border-radius: 8px; cursor: pointer;">
                                    <input type="radio" name="color" value="#FFB07C" class="d-none">
                                </label>
                                <label class="color-option" style="background-color: #FFD966; width: 32px; height: 32px; border-radius: 8px; cursor: pointer;">
                                    <input type="radio" name="color" value="#FFD966" class="d-none">
                                </label>
                                <label class="color-option" style="background-color: #FFF275; width: 32px; height: 32px; border-radius: 8px; cursor: pointer;">
                                    <input type="radio" name="color" value="#FFF275" class="d-none">
                                </label>
                                <label class="color-option" style="background-color: #E2C299; width: 32px; height: 32px; border-radius: 8px; cursor: pointer;">
                                    <input type="radio" name="color" value="#E2C299" class="d-none">
                                </label>
                                <label class="color-option" style="background-color: #72D8A7; width: 32px; height: 32px; border-radius: 8px; cursor: pointer;">
                                    <input type="radio" name="color" value="#72D8A7" class="d-none">
                                </label>
                                <label class="color-option" style="background-color: #6CD2EC; width: 32px; height: 32px; border-radius: 8px; cursor: pointer;">
                                    <input type="radio" name="color" value="#6CD2EC" class="d-none">
                                </label>
                                <label class="color-option" style="background-color: #A3EAD8; width: 32px; height: 32px; border-radius: 8px; cursor: pointer;">
                                    <input type="radio" name="color" value="#A3EAD8" class="d-none">
                                </label>
                                <label class="color-option" style="background-color: #6C9CFF; width: 32px; height: 32px; border-radius: 8px; cursor: pointer;">
                                    <input type="radio" name="color" value="#6C9CFF" class="d-none">
                                </label>
                                <label class="color-option" style="background-color: #B2A2FF; width: 32px; height: 32px; border-radius: 8px; cursor: pointer;">
                                    <input type="radio" name="color" value="#B2A2FF" class="d-none">
                                </label>
                                <label class="color-option" style="background-color: #E2A2FF; width: 32px; height: 32px; border-radius: 8px; cursor: pointer;">
                                    <input type="radio" name="color" value="#E2A2FF" class="d-none">
                                </label>
                                <label class="color-option" style="background-color: #FFA2E5; width: 32px; height: 32px; border-radius: 8px; cursor: pointer;">
                                    <input type="radio" name="color" value="#FFA2E5" class="d-none">
                                </label>
                                <label class="color-option" style="background-color: #FFA2BD; width: 32px; height: 32px; border-radius: 8px; cursor: pointer;">
                                    <input type="radio" name="color" value="#FFA2BD" class="d-none">
                                </label>
                                <label class="color-option" style="background-color: #FFBDB2; width: 32px; height: 32px; border-radius: 8px; cursor: pointer;">
                                    <input type="radio" name="color" value="#FFBDB2" class="d-none">
                                </label>
                                <label class="color-option" style="background-color: #A0A0A0; width: 32px; height: 32px; border-radius: 8px; cursor: pointer;">
                                    <input type="radio" name="color" value="#A0A0A0" class="d-none">
                                </label>
                            </div>
                        </div>

                        <!-- Botón existente -->
                        <div class="col-md-12 text-center pt-2">
                            <button type="submit" class="btn btn-mega rounded-pill store-modal-tag">
                                <i class="ti ti-circle-plus fs-18"></i>
                                Agregar etiqueta
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer" style="border: none;"></div>
        </div>
    </div>
</div>