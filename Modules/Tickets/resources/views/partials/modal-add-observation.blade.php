   <!-- Modal Agregar Observación -->
    <div class="modal fade" id="addObservationModal" tabindex="-1" aria-labelledby="addObservationModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 p-3" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
            
                <!-- Header -->
                <div class="modal-header border-0 pb-0 align-items-start">
                    <div class="d-flex align-items-start gap-2">
                        <i class="ti ti-edit-circle text-secondary fs-2 mt-1"></i>
                        <div>
                            <h5 class="modal-title fw-bold text-dark" id="addObservationModalLabel">Agregar observación</h5>
                            <p class="text-muted small mb-0" style="font-size: 13px;">Estas observaciones estarán relacionadas al estatus del ticket</p>
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
                    <form id="addObservationForm">
                        <input type="hidden" id="modal_ticket_id" name="ticket_id">
                        <input type="hidden" id="modal_ob_priority_id" name="ticket_priority_id">
                        <input type="hidden" id="modal_ob_user_id" name="user_id">
                        <input type="hidden" id="modal_ob_status_id" name="status_id">
                        <div class="mb-3">
                            <textarea 
                                class="form-control p-3" 
                                id="observationDescription" 
                                rows="5" 
                                name="description"
                                placeholder="Describe el servicio" 
                                ></textarea>
                            <small style="color: rgb(226, 53, 53)" class="error-input-observation"></small>
                        </div>

                        <!-- Footer -->
                        <div class="text-center mt-4 mb-2">
                            <button type="submit" class="btn btn-mega rounded-pill save-modal-observation">
                                <i class="ti ti-edit-circle fs-16"></i>
                                Agregar observación
                            </button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>