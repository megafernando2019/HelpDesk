$(document).ready(function () {

    const priorityConfig = {
        'baja': { text: '#eab308', bg: '#eab3081a' },
        'media': { text: '#fa995c', bg: '#fa995c1a' },
        'alta': { text: '#ff5757', bg: '#ff57571a' },
        'muy alta': { text: '#aa1515', bg: '#aa15151a' }
    };

    // Inicializar DataTable (desactivamos su paginación interna para usar la de simplePaginate)
    const table = $('#recurringTable').DataTable({
        responsive: true,
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        dom: '<"top">rt<"bottom"><"clear">', // Quitamos 'ip' de DataTables para usar nuestros botones AJAX
        paging: false, // Gestionado por simplePaginate
        columnDefs: [
            { orderable: false, targets: [3, 4] }
        ]
    });

    // Rango de fechas con Flatpickr
    $("#dateRangePicker").flatpickr({
        mode: "range",
        dateFormat: "Y-m-d",
        locale: "es",
        onChange: function (selectedDates) {
            if (selectedDates.length === 2 || selectedDates.length === 0) {
                fetchFilteredData();
            }
        }
    });

    // Función principal que acepta una URL opcional (para la paginación)
    function fetchFilteredData(url = '/incidents/data_incidents') {
        const search = $('#searchInput').val() || '';
        const userId = $('#filterUser').val() || '';
        const categoryId = $('#filterCategory').val() || '';
        const serviceId = $('#filterService').val() || '';
        const statusId = $('#filterStatus').val() || '';
        
        let dateRange = $('#dateRangePicker').val() || '';
        let dateStart = '';
        let dateEnd = '';

        $('.total_usuarios').text('0');
        $('.total_servicios').text('0');
        $('.total_row_tickets').text('0');

         ui.showToast('info', 'Consultando información.');

        if (dateRange.includes('to')) {
            const dates = dateRange.split(' to ');
            dateStart = dates[0];
            dateEnd = dates[1];
        } else if (dateRange) {
            dateStart = dateRange;
            dateEnd = dateRange;
        }

        // Si es la carga inicial o cambio de filtro, enviamos los datos por GET. 
        // Si la URL ya trae parámetros de página (ej. ?page=2), jQuery los respeta si usamos un objeto o URL.
        $.ajax({
            url: url,
            type: 'GET',
            data: url.includes('?') ? {} : {
                search: search,
                user_id: userId,
                category_id: categoryId,
                service_id: serviceId,
                status_id: statusId,
                date_start: dateStart,
                date_end: dateEnd
            },
            dataType: 'json',
            success: function (result) {
                // result contiene el objeto de simplePaginate

                console.log(result?.metricts)
                //Actualizar contadores
                $('.total_usuarios').text(result?.metricts?.count_user ?? 0);
                $('.total_servicios').text(result?.metricts?.count_service ?? 0);
                $('.total_row_tickets').text(result?.metricts?.count_row_tickets ?? 0);

                updateTable(result.reincidencias.data);
                renderPagination(result.reincidencias);
            },
            error: function (xhr) {
                console.error("Error al obtener datos filtrados:", xhr);
            }
        });
    }

    function updateTable(items) {
        table.clear();

        if (items && Array.isArray(items)) {
            items.forEach(item => {
                let fullName = `${item.first_name_user} ${item.last_name_user}`;
            
                let actionButton = `
                    <button class="btn btn-sm btn-link text-muted p-0 ms-1 ver-detalle" data-user="${item.usuario_id}" data-servicio="${item.servicio_id}" title="Ver detalle">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                        </svg>
                    </button>
                `;

                let badgeStatus = `<span class="badge bg-danger-subtle text-danger px-3 py-2 rounded-pill fw-normal">Reincidencia</span>`;

                table.row.add([
                    `<span class="ps-3 fw-medium text-dark">${fullName}</span>`,
                    `<span class="text-muted">${item.categoria}</span>`,
                    `<span class="text-muted">${item.servicio}</span>`,
                    `${item.total_tickets} ${actionButton}`,
                    badgeStatus
                ]);
            });
        }

        table.draw();
    }

    // Renderizar botones de Anterior / Siguiente basados en simplePaginate
    function renderPagination(result) {

        const paginationContainer = $('#ajaxPagination');
        paginationContainer.html('');

        let prevDisabled = !result.prev_page_url ? 'disabled' : '';
        let nextDisabled = !result.next_page_url ? 'disabled' : '';

        let html = `
            <span class="text-muted small">Mostrando página <strong>${result.current_page}</strong></span>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-secondary btn-sm prev-page" ${prevDisabled} data-url="${result.prev_page_url}">Anterior</button>
                <button type="button" class="btn btn-outline-secondary btn-sm next-page" ${nextDisabled} data-url="${result.next_page_url}">Siguiente</button>
            </div>
        `;


        paginationContainer.html(html);
    }

    // Evento clic para los botones de paginación AJAX
    $(document).on('click', '.prev-page, .next-page', function () {
        const url = $(this).data('url');
        if (url && !$(this).prop('disabled')) {
            fetchFilteredData(url);
        }
    });

    // Eventos para filtros y buscador
    $('#filterUser, #filterCategory, #filterService, #filterStatus').on('change', function () {
        fetchFilteredData();
    });

    $('#searchInput').on('input', debounce(function () {
        fetchFilteredData();
    }, 400));

    // Carga inicial
    fetchFilteredData();

    // Evento del Modal
    $(document).on('click', '.ver-detalle', function () {
        const btn = $(this);
        const user = btn.data('user');
        const servicio = btn.data('servicio');

        let dateRange = $('#dateRangePicker').val() || '';
        let dateStart = '';
        let dateEnd = '';

        if (dateRange.includes('to')) {
            const dates = dateRange.split(' to ');
            dateStart = dates[0];
            dateEnd = dates[1];
        } else if (dateRange) {
            dateStart = dateRange;
            dateEnd = dateRange;
        }

        verDetalle(user, servicio, dateStart, dateEnd);
    });

    function verDetalle(usuarioId, servicioId, dateStart, dateEnd) {
        $('#verDetallestickets .modal-body').html('<p class="text-center text-muted py-3">Cargando tickets...</p>');
        $('#verDetallestickets').modal('show'); 

        $.ajax({
            url: '/incidents/tickets_detalle',
            type: 'GET',
            data: {
                usuario_id: usuarioId,
                servicio_id: servicioId,
                date_start: dateStart,
                date_end: dateEnd
            },
            success: function(tickets) {
                let htmlContent = '';

                if (!tickets || tickets.length === 0) {
                    htmlContent = '<p class="text-center text-muted py-3">No se encontraron tickets para este servicio en el rango seleccionado.</p>';
                } else {
                    tickets.forEach(ticket => {
                        let fechaCreacion = new Date(ticket.created_at).toLocaleString('es-ES', {
                            day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
                        });

                        const priorityKey = (ticket?.priority_name || '').toLowerCase().trim();
                        const priorityStyles = priorityConfig[priorityKey] || { text: '#6c757d', bg: '#6c757d1a' };

                        htmlContent += `
                            <div class="card mb-3 border-0 shadow-sm position-relative" style="border-left: 4px solid #f97316 !important; border-radius: 8px;">
                                <div class="card-body py-3 px-3">
                                    <div class="row align-items-center">
                                        <div class="col-md-9 d-flex align-items-start gap-3">
                                            <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold" style="width: 40px; height: 40px; background-color: #d946ef; font-size: 14px; flex-shrink: 0;">
                                                ${ticket?.initials ?? ''}
                                            </div>
                                            <div>
                                                <div class="d-flex align-items-center gap-2 mb-1">
                                                    <h6 class="text-info fw-bold mb-0">${ticket?.uid ?? ''} - ${ticket?.title || 'Sin asunto'}</h6>
                                                </div>
                                                <p class="text-muted small mb-2">
                                                    <strong>${ticket?.first_name ?? ''} ${ticket.last_name ?? ''}</strong> 
                                                    <span class="text-muted">(${ticket?.email ?? ''})</span> &bull; 
                                                    <span class="badge bg-light text-dark border ms-1 rounded-pill">${ticket?.categoria ?? ''}</span>
                                                    <span class="badge ms-1 rounded-pill" style="background-color: ${priorityStyles?.bg ?? ''} !important; color: ${priorityStyles?.text ?? ''} !important;">
                                                        <i class="ti ti-pin"></i> ${ticket?.priority_name || ''}
                                                    </span>
                                                </p>
                                                <p class="mb-2 text-dark">"${ticket?.description ?? ''}"</p>
                                            
                                                <div class="d-flex align-items-center gap-3">
                                                    <span class="badge ${ticket.status_color ?? ''} px-2 py-1 rounded">
                                                        <i class="${ticket?.status_icon ?? ''}"></i> ${ticket?.status_name ?? 'N/A'}
                                                    </span>
                                                    <small class="text-muted">Encargado: <strong>${ticket?.display_name_user_assing ?? 'Sin asignar'}</strong></small>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 text-end d-flex align-items-center justify-content-end gap-2 text-muted small">
                                            <a href="/tickets/${ticket?.uid ?? ''}" target="_blank" rel="noopener noreferrer">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                    <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8M1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.12 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z"/>
                                                    <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5M4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0"/>
                                                </svg>
                                            </a>
                                            <span>Creado el ${fechaCreacion} h</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        `;
                    });
                }

                $('#verDetallestickets .modal-body').html(htmlContent);
            },
            error: function(xhr) {
                console.error("Error al obtener los detalles", xhr);
                $('#verDetallestickets .modal-body').html('<p class="text-center text-danger py-3">Ocurrió un error al cargar los tickets.</p>');
            }
        });
    }

    $('#filterUser').select2({
        placeholder: "Selecciona una opción",
        allowClear: true,
        width: '100%',
    });

    function debounce(func, wait) {
        let timeout;
        return function(...args) {
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(this, args), wait);
        };
    }
});