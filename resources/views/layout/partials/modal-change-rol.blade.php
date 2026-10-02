
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
                    <!--listado de roles 
                    <div class="col-md-12">
                        <div class="btn-group">
                            <button type="button" class="btn btn-mega rounded-pill dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                Roles
                            </button>
                            <ul class="dropdown-menu" style="">
                                <li><a class="dropdown-item" href="javascript:void(0);">Action</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Another action</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Something else here</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Separated link</a></li>
                            </ul>
                        </div>
                    </div> -->
                    <div class="col-md-12">
                        Cambia tu rol en el sistema
                    </div>
                    <div class="col-md-12 d-flex justify-content-center mt-2">
                        <picture>
                            <img width="140px" height="140" src="{{asset('build/img/icons/tugui_en_computadora.png')}}" alt="Tugui">
                        </picture>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-center loading-roles-panel gap-2 d-none" style="align-items: center;">
                            <div class="spinner-border" role="status"></div>
                            <p> Cargando roles...</p>
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

