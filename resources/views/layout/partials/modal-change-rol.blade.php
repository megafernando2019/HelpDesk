
<!-- Modal Body -->
<!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
<div
    class="modal fade"
    id="modalChangeRolId"
    tabindex="-1"
    data-bs-keyboard="false"
    role="dialog"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-lg"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header" style="border: none;">
                <h5 class="modal-title" id="modalTitleId">
                    Herramientas de sistemas
                </h5>
                <button
                    type="button"
                    class="btn-close"
                    style="background-color: #fff;"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-12">
                        Cambia tu rol en el sistema
                    </div>
                    <div class="col-md-12 d-flex justify-content-center mt-2">
                        <picture class="default-picture-tugui-roles">
                            <img width="140px" height="140" src="{{asset('build/img/icons/tugui_en_computadora.png')}}" alt="Tugui">
                        </picture>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-center loading-roles-panel gap-2 d-none" style="align-items: center;">
                            <img src="{{asset('build/img/icons/gif_tugui_en_computadora_sin_fondo.gif')}}"
                                 width="95" height="95" alt="gif tugui">
                        </div>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="" class="form-label">Actual</label>
                        <select
                            disabled
                            class="form-select form-select-lg roles-actual"
                            name=""
                            id=""
                        >
                           
                        </select>
                    </div>
                    <div class="mb-3 col-md-6">
                        <label for="" class="form-label">Nuevo</label>
                        <select
                            class="form-select form-select-lg roles-nuevos"
                            name=""
                            id=""
                        >
                            
                        </select>
                    </div>
                    <div class="col-md-12 d-flex justify-content-center">
                        <button class="btn btn-mega rounded-pill" id="btnGuardarRol">
                            <i class="ti ti-circle-plus"></i>
                            Guardar cambios
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-footer" style="border: none;">
            </div>
        </div>
    </div>
</div>

