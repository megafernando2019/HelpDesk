$(document).ready(function () {

    const ctxOffcanvas = document.getElementById("offcanvasRight");

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
        $('#contenedor-resultados').empty();
    });

    
    $('.action-offcanvas-notifications').click(function () {$('.offcanvas-action').trigger('click');

        if (ctxOffcanvas.offsetWidth > 0 || ctxOffcanvas.offsetHeight > 0) {
            $('.sidebar').css('z-index', '0');
        }

        $('#offcanvasRightLabel').text('');
        $('#offcanvasRightLabel').html('<i class="ti ti-bell"></i> Notificaciones');

        let contenedor = $('#contenedor-resultados');
        contenedor.empty();

         $.ajax({
            url: '/get_current_notifications',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                // Extraemos los datos del paginador de Laravel
                const notifications = response?.data ?? response;

                if (notifications.length === 0) {
                    contenedor.html('<p class="text-muted text-center p-3">No hay notificaciones recientes.</p>');
                    return;
                }

                notifications.forEach(function (item) {
                   let colorBorder = '';

                let descriptionHtml = item.description;

                if (item.ticket_id && item.ticket_url) {
                    // Buscamos patrones entre comillas angulares o normales y los convertimos en enlace con estilos de subrayado y color azul
                    descriptionHtml = descriptionHtml.replace(
                        /(“[^”]+”|\bTKT[A-Z0-9]+\b)/g, 
                        `<a href="${item.ticket_url}" class="text-primary text-decoration-underline fw-semibold">$1</a>`
                    );
                }

                   switch (item.ticket_action_id) {
                     case 7:
                     case 10:
                     case 9:
                     case 1:
                     case 11:
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
                        <div class="card border shadow-sm p-2 rounded-4 mb-2" style="background-color: ${item.bg_color}; border: 1px solid ${colorBorder} !important;">
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-3">
                                    <div class="avatar-sm rounded-circle p-2 text-center d-flex align-items-center justify-content-center" style="background: rgba(0,0,0,0.04);">
                                        <i class="${item.icon} fs-4"></i>
                                    </div>
                                    <div>
                                       ${descriptionHtml}
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    `;
                    contenedor.append(cardHtml);
                });
            },
            error: function (xhr, status, error) {
                console.error('Error al cargar las notificaciones:', error);
                contenedor.html('<p class="text-danger text-center p-3">Error al cargar notificaciones.</p>');
            }
        });
    });
  
});