$(document).ready(function () {

    const ctxOffcanvas = document.getElementById("offcanvasRight");
    let currentNotificationFilter = 'today';

    const getCountNotificationsPending = () => {
         $.ajax({
            url: '/get_count_notifications_pendings',
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
               $('.count-notifications').text('0');
            },
            success: function (response) {
                
                const total = response ?? 0;

                console.log(response)

                $('.count-notifications').text(total);
            },
            error: function (xhr, status, error) {
                console.error('Error al cargar:', error);
            },
            finally: function() {
                
            }
        });
    }

    getCountNotificationsPending();

    $('.canvas-not-action').submit(function (e) { 
        e.preventDefault();
        
        const offcanvas = $('.offcanvas-event');

        let busqueda = offcanvas.val().trim();
        let contenedor = $('#contenedor-resultados');

        $('#offcanvasRightLabel').html('');
        $('#offcanvasRightLabel').text('Resultados');

        ui.showToast('info', 'Consultando tickets...');

            // $('.offcanvas-action').trigger('click');
            $.ajax({
                url: '/search_offcanvas_event',
                type: 'GET',
                data: { query: busqueda },
                dataType: 'json',
                success: function (tickets) {
                    // Limpiamos resultados anteriores
                    contenedor.empty();

                    // Si no hay resultados
                    if (tickets.length === 0) {
                        ui.showToast('warning', 'No se encontraron búsquedas relacionadas con el folio.');
                        contenedor.html('<p class="text-muted">No se encontraron tickets.</p>');
                        return;
                    }

                    // Recorremos cada ticket recibido para armar la card
                    tickets.forEach(function(ticket) {
                        let cardHtml = `
                            <div class="card border shadow-sm p-3 rounded-4">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-sm bg-light-primary rounded-circle p-2 text-center">
                                        <i class="ti ti-ticket fs-4"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-1 text-mega fw-bold">${ticket.uid} - ${ticket.title}</h6>
                                        <p class="mb-1 text-muted small">${ticket.description}</p>
                                    </div>
                                </div>
                                <div class="row" style="margin-right: 0 !important;margin-left: 0 !important;">
                                     <div class="col-md-9">
                                        <small class="text-secondary">Creado el: ${ticket.created_at}</small>
                                     </div>
                                     <div class="col-md-3">
                                        <a href="/tickets/${ticket.uid}"
                                           target="_blank" title="Ver detalle" 
                                           class="btn btn-sm btn-info"
                                           style="float: right;">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                     </div>
                                </div>
                            </div>
                        `;
                        contenedor.append(cardHtml);
                    });

                    $('.offcanvas-action').trigger('click');

                    if (ctxOffcanvas.offsetWidth > 0 || ctxOffcanvas.offsetHeight > 0) {
                        $('.sidebar').css('z-index', '0');
                    }
                     
                },
                error: function (xhr, status, error) {
                    console.error('Error en la búsqueda:', error);
                
                }
            });
    });

    ctxOffcanvas.addEventListener('hidden.bs.offcanvas', function () {
        
        $('.sidebar').css('z-index', '1001');
        $('.offcanvas-event').val('');
        $('#notification-filters').addClass('d-none');
        $('#contenedor-resultados').empty();
    });

    
    // Función reutilizable para cargar notificaciones por página
    function loadNotifications(url = '/get_current_notifications') {
        let contenedor = $('#contenedor-resultados');
        contenedor.empty();

        let separator = url.includes('?') ? '&' : '?';
        let fullUrl = `${url}${separator}filter=${currentNotificationFilter}`;

        $.ajax({
            url: fullUrl,
            type: 'GET',
            dataType: 'json',
            beforeSend: function() {
                $('.loading-tugui').removeClass('d-none');
            },
            success: function (response) {
                // Laravel devuelve los datos dentro de 'data' cuando está paginado
                const notifications = response?.data ?? [];
                const prevPageUrl = response?.prev_page_url;
                const nextPageUrl = response?.next_page_url;
                const currentPage = response?.current_page || 1;
                const lastPage = response?.last_page || 1;
                const pluckIds = notifications.map(item => item.id);

                if (notifications.length === 0) {
                    contenedor.html('<p class="text-muted text-center p-3">No hay notificaciones recientes.</p>');
                    return;
                }

                // Renderizar cada tarjeta de notificación
                notifications.forEach(function (item) {
                   let colorBorder = '';

                   switch (item.ticket_action_id) {
                     case 7: case 10: case 9: case 1: case 11:
                        colorBorder = 'purple';
                        break;
                    case 2:
                        colorBorder = 'blue';
                        break;
                    case 3:
                        colorBorder = 'grey';
                        break;
                    case 4:
                        colorBorder = 'green';
                        break;
                    case 5:
                        colorBorder = 'orange';
                        break;
                     case 6:
                        colorBorder = 'red';
                        break;
                    default:
                        break;
                   }

                    let cardHtml = `
                        <div class="card border shadow-sm p-2 rounded-4 mb-2 ${item?.badge_class ?? ''}" style="background-color: ${item.bg_color}; border: 1px solid ${colorBorder} !important;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-sm rounded-circle p-2 text-center d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.04);">
                                        <i class="${item.icon} fs-4"></i>
                                    </div>
                                    <div>
                                       ${item?.matched ?? ''}
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    contenedor.append(cardHtml);
                });

                // Renderizar los controles de paginación al final de las cards
                let paginationHtml = `
                    <div class="d-flex justify-content-between align-items-center mt-3 px-2">
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-page-notif" data-url="${prevPageUrl}" ${!prevPageUrl ? 'disabled' : ''}>
                            <i class="ti ti-chevron-left"></i> Anterior
                        </button>
                        <span class="text-muted small">Página ${currentPage}</span>
                        <button type="button" class="btn btn-sm btn-outline-secondary btn-page-notif" data-url="${nextPageUrl}" ${!nextPageUrl ? 'disabled' : ''}>
                            Siguiente <i class="ti ti-chevron-right"></i>
                        </button>
                    </div>
                `;

               $('.loading-tugui').addClass('d-none');

                contenedor.append(paginationHtml);

                $.ajax({
                    url: '/mark_notifications_as_read', 
                    type: 'GET',
                    dataType: 'json',
                    contentType: 'application/json', 
                    data: {
                        filtro_tipo: 'today',                            
                        notification_ids: pluckIds
                    },
                    success: function (response) {
                        console.log(response.count)
                        $('.count-notifications').text(response?.count??0);
                    },
                    error: function (xhr, status, error) {
                        console.error('Error en la petición POST:', error);
                    }
                });
                
            },
            error: function (xhr, status, error) {
                console.error('Error al cargar las notificaciones:', error);
                contenedor.html('<p class="text-danger text-center p-3">Error al cargar notificaciones.</p>');
            },
            finally: function() {
                 $('.loading-tugui').addClass('d-none');
                 getCountNotificationsPending();
            }
        });
    }

    $('.action-offcanvas-notifications').click(function () 
    
        {$('.offcanvas-action').trigger('click');

        if (ctxOffcanvas.offsetWidth > 0 || ctxOffcanvas.offsetHeight > 0) {
            $('.sidebar').css('z-index', '0');
        }

        $('#notification-filters').removeClass('d-none');

        $('#offcanvasRightLabel').text('');
        $('#offcanvasRightLabel').html('<i class="ti ti-bell"></i> Notificaciones');

        // Llamamos a la función cargando la primera página por defecto
        loadNotifications('/get_current_notifications');
    });

    $(document).on('click', '.btn-notif-filter', function () {
        $('.btn-notif-filter').removeClass('btn-info active').addClass('btn-light text-muted');
        $(this).removeClass('btn-light text-muted').addClass('btn-info active');

        currentNotificationFilter = $(this).attr('data-filter');
        loadNotifications('/get_current_notifications');
    });


    // Delegación de eventos para los botones de paginación dinámicos
    $(document).on('click', '.btn-page-notif', function () {
        let url = $(this).attr('data-url');
        if (url && url !== 'null') {
            loadNotifications(url);
        }
    });
    
});