$(document).ready(function () {

    $('.canvas-not-action').submit(function (e) { 
        e.preventDefault();
        
    });
    
    $('.offcanvas-event').on('input' ,function () { 
       
        let busqueda = $(this).val().trim();
        let contenedor = $('#contenedor-resultados');

        ui.showToast('info', 'Consultando tickets...');
        
        if (busqueda !== "") {

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
                                        <h6 class="mb-1 text-primary fw-bold">${ticket.uid} - ${ticket.title}</h6>
                                        <p class="mb-1 text-muted small">${ticket.description}</p>
                                        <small class="text-secondary">Creado el: ${ticket.created_at}</small>
                                        
                                    </div>
                                    <div>
                                        <a href="/tickets/${ticket.uid}" target="_blank" title="Ver detalle" class="btn btn-sm btn-info">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        `;
                        contenedor.append(cardHtml);
                    });

                     $('.offcanvas-action').trigger('click');
                },
                error: function (xhr, status, error) {
                    console.error('Error en la búsqueda:', error);
                
                }
            });

        } else {
            $('#contenedor-resultados').html('<p class="text-muted">Escribe algo en el buscador para ver resultados...</p>');
        }
    });
  
});