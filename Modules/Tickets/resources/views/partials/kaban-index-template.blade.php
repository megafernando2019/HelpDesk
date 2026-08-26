<script type="text/template" id="ticket-card-template">
    <div class="col-md-4 mb-3">
        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background-color: #fff;">
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                
                <div>
                    <!-- Encabezado: Servicio y Prioridad -->
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <span class="badge text-dark fw-normal px-2 py-1" style="border-radius: 6px; font-size: 11px; background-color: {current_color};">
                            {service_name}
                        </span>
                        <span class="badge fw-normal px-2 py-1 d-flex align-items-center gap-1" style="border-radius: 12px; font-size: 11px; color: {txt_current_color_priority} !important; background-color: {current_color_priority};">
                            <i class="ti ti-pin fs-12"></i> Prioridad {priority_name}
                        </span>
                    </div>

                    <!-- Título -->
                    <h6 class="text-mega fw-bold mb-0 text-truncate">
                        {uid} - {title}
                    </h6>

                    <!-- Fecha -->
                    <small class="text-muted d-block mb-2" style="font-size: 11px;">
                        Creado el {created_at}
                    </small>

                    <!-- Descripción -->
                    <p class="text-secondary mb-3 small" style="font-size: 11px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                        "{description}"
                    </p>
                </div>

                <!-- Footer: Acciones y Encargado -->
                <div class="pt-2 d-flex border-top justify-content-between align-items-center">
                    <div>
                        <small class="text-muted d-block fw-semibold mb-1" style="font-size: 10px;">Acciones</small>
                        <div class="d-flex gap-2">
                            <a href="javascript:void(0);" data-action="ticket-show" data-id="{id}" class="text-secondary" title="Ver">
                                <i class="ti ti-eye fs-18"></i>
                            </a>
                            <a href="javascript:void(0);" data-action="ticket-edit" data-id="{id}" class="text-secondary" title="Editar">
                                <i class="ti ti-edit fs-18"></i>
                            </a>
                        </div>
                    </div>

                    <div class="border-start ps-3 text-start">
                        <small class="text-muted d-block fw-semibold mb-1" style="font-size: 10px;">Encargado</small>
                        <span class="fw-medium text-dark" style="font-size: 11px;">
                            {assigned_name}
                        </span>
                    </div>
                </div>

            </div>
        </div>
    </div>
</script>