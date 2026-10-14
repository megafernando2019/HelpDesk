<div class="modal fade" id="viewFileModal" tabindex="-1" aria-labelledby="viewFileModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 p-3" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
            
            <!-- Header -->
            <div class="modal-header border-0 pb-0 align-items-start">
                <div class="d-flex align-items-start gap-2">
                    <i class="ti ti-file text-secondary fs-2 mt-1"></i>
                    <h5 class="modal-title fw-bold text-dark" id="viewFileModalLabel">Visualizador de archivo</h5>
                </div>
                <button 
                 type="button"
                 style="color: #000!important;background-color:#fff !important;"
                 class="btn-close text-muted"
                 data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <!-- Body -->
            <div class="modal-body py-3">
                <iframe class="file-render" src="" width="100%" style="height: 400px;" frameborder="0"></iframe>
            </div>

        </div>
    </div>
</div>