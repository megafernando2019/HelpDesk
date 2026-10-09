   <!-- Modal Agregar  -->
<div class="modal fade" id="showCatModal" tabindex="-1" aria-labelledby="showCatModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-3" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
            
            <!-- Header -->
            <div class="modal-header border-0 pb-0 align-items-start">
                <div class="d-flex align-items-start gap-2">
                    <div>
                        <i class="ti ti-file-stack text-secondary fs-2 mt-1"></i>
                        Categoría
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
                <!-- los detalles -->
                <div class="row">
                    <div class="mb-3">
                         <div class="col-md-3">Nombre</div>
                         <div class="col-md-9 show-name"></div>
                    </div>
                    <div class="mb-3">
                        <div class="col-md-3">Descripción</div>
                        <div class="col-md-9 show-description"></div>
                    </div>
                    <div class="mb-3">
                        <div class="col-md-3">Servicios</div>
                        <div class="col-md-9 show-services">
                            <div class="wrap-container d-flex flex-wrap gap-2"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="col-md-3">Creado</div>
                        <div class="col-md-9 show-created"></div>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border: none;"></div>
        </div>
    </div>
</div>