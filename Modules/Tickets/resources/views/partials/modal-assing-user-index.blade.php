   <!-- Modal asignar usuario a ticket -->
<div class="modal fade" id="assingUserModal" tabindex="-1" aria-labelledby="assingUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 p-3" style="border-radius: 20px; box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);">
            
            <!-- Header -->
            <div class="modal-header border-0 pb-0 align-items-start">
                <div class="d-flex align-items-start gap-2">
                    <i class="ti ti-user-check text-secondary fs-2 mt-1"></i>
                    <div>
                        <h5 class="modal-title fw-bold text-dark" id="assingUserModalLabel">Asignar ticket</h5>
                        <p class="text-muted small mb-0" style="font-size: 13px;">
                            Selecciona a un encargado para atender el ticket
                        </p>
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
                <form id="addAssignUserForm">
                    <input type="hidden" class="current-user-assing">
                    <input type="hidden" class="status-id-modal-assing-user">
                    <input type="hidden" class="ticket-id-modal-assign-user">
                    <div class="mb-3">
                        <select class="form-control select2-assignees"
                                name="assign"
                                style="width: 100%;">
                        </select>
                    </div>

                    <!-- Footer -->
                    <div class="text-center mt-4 mb-2">
                        <button type="submit" class="btn btn-mega rounded-pill save-modal-user-assign">
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>