<!-- Modal Body -->
<div
    class="modal fade"
    id="modalSuccessCreate"
    tabindex="-1"
    {{-- data-bs-backdrop="static" --}}
    data-bs-keyboard="false"
    role="dialog"
    aria-labelledby="modalTitleId"
    aria-hidden="true"
>
    <div
        class="modal-dialog modal-dialog-scrollable modal-dialog-centered"
        role="document"
    >
        <div class="modal-content">
            <div class="modal-header" style="border: none;">
                
                <button
                    type="button"
                    class="btn-close"
                    style="background-color: #fff;"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                ></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <!-- Contenedor con posición relativa para ubicar los brillos -->
                    <div class="ticket-icon-wrapper d-flex align-items-center justify-content-center">
                        <div class="row-icons">
                            <!-- Brillo Izquierdo -->
                            <i class="ti ti-sparkles text-warning fs-3 spark-left"></i>
            
                            <!-- Ícono Principal de Ticket -->
                            <i style="font-size: 9em;" class="ti ti-ticket ticket-main-icon"></i>
            
                            <!-- Brillo Derecho -->
                            <i class="ti ti-sparkles text-warning fs-3 spark-right"></i>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                     <h3 class="text-center">
                        ¡El ticket fue creado con exito!
                    </h3>
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-center" style="border: none;">
                <a href="{{route('tickets.index')}}" class="btn btn-mega rounded-pill w-50">Ir a mis tickets</a>
            </div>
        </div>
    </div>
</div>