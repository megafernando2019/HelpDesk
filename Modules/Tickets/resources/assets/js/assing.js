
'use strict';

import axios from "axios";

// Carga inicial al cargar el DOM
$(document).ready(function () {

    let selectedTickets = [];
    let departmentUsers = [];
    let currentPage = 1;
    let currentSortOrder = 'desc';
    const $selectUser = $('#select-responsible');
    

    $('#sort-tickets-menu').on('click', '.sort-option', function (e) {
        e.preventDefault();

        const selectedText = $(this).text().trim();
        const order = $(this).data('order');
        const pageOrder = $('.indicador-page').data('currentPage');

        
        $('#btn-sort-label').text(selectedText);

       
        $('.sort-option').removeClass('active');
        $(this).addClass('active');

        currentSortOrder = order;
        fetchAvailableTickets(pageOrder);
    });


    /**
     * Carga y renderiza los tickets disponibles con paginación
     * @param {number} page - Número de página a consultar
     */
    function fetchAvailableTickets(page = 1) {

        const container = document.getElementById('tickets-container');
        const paginationContainer = document.getElementById('tickets-pagination');
        currentPage = page;

        // Estado de carga visual (Loader)
        container.innerHTML = `
            <div class="text-center py-4 text-muted">
                <div class="spinner-border spinner-border-sm text-blue me-2" role="status"></div>
                Cargando tickets...
            </div>
        `;

        axios.get(`/tickets/get_tickets_status_assgin?page=${page}`)
            .then(response => {
                const { data: tickets, prev_page_url, next_page_url, current_page } = response.data;

                // Manejo de estado vacío
                if (!tickets || tickets.length === 0) {
                    container.innerHTML = `
                        <div class="text-center py-4 text-muted">
                            <i class="ti ti-ticket-off fs-2 mb-2"></i>
                            <p class="mb-0">No hay tickets pendientes por asignar.</p>
                        </div>
                    `;
                    paginationContainer.innerHTML = '';
                    return;
                }


              
                tickets.sort((a, b) => {
                    // Si la respuesta incluye 'id' o 'created_at'
                    const valA = a.id || a.uid;
                    const valB = b.id || b.uid;

                    if (currentSortOrder === 'asc') {
                        return valA > valB ? 1 : -1;
                    } else {
                        return valA < valB ? 1 : -1;
                    }
                });

                // Renderizado de Cards
                container.innerHTML = tickets.map(ticket => {
                    const {
                        uid,
                        title,
                        priority_name,
                        services_name,
                        user_ticket_first_name,
                        user_ticket_last_name,
                        created_at_human,
                        user_initial_ticket,
                        priority_colors,
                        description
                    } = ticket;

                    return `
                        <div class="card shadow-sm border rounded-3 user-select-text draggable-ticket mb-2" 
                             draggable="true" 
                                data-uid="${uid || ''}"
                                data-title="${title || ''}"
                                data-first-name="${user_ticket_first_name || ''}"
                                data-last-name="${user_ticket_last_name || ''}"
                                data-service="${services_name || ''}"
                                data-priority="${priority_name || ''}"
                                data-initials="${user_initial_ticket || 'U'}"
                                data-color-text="${priority_colors?.text || ''}"
                                data-color-bg="${priority_colors?.bg || ''}"
                             >
                            <div class="card-body p-3">
                                <!-- Meta: Prioridad y Fecha -->
                                <div class="d-flex align-items-center gap-2 justify-content-end mb-2">
                                    <span class="badge rounded-pill fw-semibold d-inline-flex align-items-center gap-1"
                                          style="color: ${priority_colors?.text || '#eab308'} !important;
                                          background-color: ${priority_colors?.bg || '#eab3081a'} !important; font-size: 0.75rem;">
                                        <i class="ti ti-pin" style="font-size: 0.85rem;"></i>
                                        Prioridad ${priority_name}
                                    </span>
                                    <small class="text-muted fw-normal" style="font-size: 0.75rem;">
                                        ${created_at_human}
                                    </small>
                                </div>

                                <!-- Encabezado de la card: Avatar, Título y Badges -->
                                <div class="d-flex align-items-center gap-3">
                                    <!-- Avatar con Iniciales -->
                                    <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0 fw-bold"
                                         style="width: 42px; height: 42px; font-size: 0.95rem;">
                                        ${user_initial_ticket || 'U'}
                                    </div>

                                    <!-- Contenido Principal -->
                                    <div class="flex-grow-1 min-w-0">
                                    
                                        <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap mb-1">
                                            <!-- UID y Título -->
                                            <h6 style="text-wrap: auto;" class="mb-0 fw-bold text-mega text-truncate">
                                                ${uid} - ${title}
                                            </h6>
                                        </div>

                                        <!-- Nombre de Usuario y Badge de Servicio -->
                                        <div class="d-flex align-items-center gap-2 flex-wrap mt-1">
                                            <small class="text-secondary">
                                                ${user_ticket_first_name} ${user_ticket_last_name}
                                            </small>

                                            ${services_name ? `
                                                <span style="background-color: #eff4ff; border:none;" class="badge text-secondary border" style="font-size: 0.725rem;">
                                                    ${services_name}
                                                </span>
                                            ` : ''}
                                        </div>
                                    </div>
                                </div>  
                                <div class="mt-2">"${description}"</div>
                            </div>
                        </div>
                    `;
                }).join('');

                // Renderizado de la Paginación Simple
                paginationContainer.innerHTML = `
                    <button class="btn-paginate btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" 
                            ${!prev_page_url ? 'disabled' : ''} 
                            data-page="${current_page - 1}">
                        <i class="ti ti-chevron-left"></i> Anterior
                    </button>

                    <span data-current-page="${current_page}" class="small text-muted fw-semibold indicador-page">Página ${current_page}</span>

                    <button class="btn-paginate btn btn-sm btn-outline-secondary d-flex align-items-center gap-1" 
                            ${!next_page_url ? 'disabled' : ''} 
                            data-page="${current_page + 1}">
                        Siguiente <i class="ti ti-chevron-right"></i>
                    </button>
                `;
            })
            .catch(error => {
                console.error('Error al obtener los tickets:', error);
                container.innerHTML = `
                    <div class="alert alert-danger py-2 px-3 small" role="alert">
                        Ocurrió un error al cargar los tickets. Por favor, reintenta.
                    </div>
                `;
                paginationContainer.innerHTML = '';
            });
    }

    /**
     * Delegación de eventos para la paginación dinámica
     */
    $('#tickets-pagination').on('click', '.btn-paginate', function () {
        const page = $(this).data('page');
        if (page && page > 0) {
            fetchAvailableTickets(page);
        }
    });

    fetchAvailableTickets(1);


        function loadDepartmentUsers() {
            axios.get('/users/get_by_department', {
                params: { department_id: 2 } 
            })
            .then(response => {
                const usersData = response.data.data || [];

                // Mapeo al formato esperado por Select2 y guardado en memoria
                departmentUsers = usersData.map(user => ({
                    id: user.id,
                    text: `${user.first_name} ${user.last_name}`,
                    email: user.email,
                    tickets_count: user.active_tickets_count || 0,
                    initials: user?.initials ?? null,
                    tickets_count: user?.tickets_count || 0
                }));

                $selectUser.empty();

                $selectUser.select2({
                    placeholder: 'Buscar y seleccionar un usuario responsable...',
                    allowClear: true,
                    data: departmentUsers, 
                    matcher: customUserMatcher, // Buscador personalizado (busca por nombre y email)
                    templateResult: formatUserOption,
                    templateSelection: formatUserSelection
                });

                // Disparar evento para asegurar que esté limpio inicialmente
                $selectUser.val(null).trigger('change');
            })
            .catch(error => {
                console.error('Error al cargar los usuarios del departamento:', error);
                ui.showToast('error', 'Error al cargar los usuarios del departamento:');
            });
        }

        
        function customUserMatcher(params, data) {
            // Si no hay término de búsqueda, mostrar todos los elementos
            if ($.trim(params.term) === '') {
                return data;
            }

            // Si no hay texto en la opción, ignorar
            if (typeof data.text === 'undefined') {
                return null;
            }

            const term = params.term.toLowerCase();
            const text = data.text.toLowerCase();
            const email = (data.email || '').toLowerCase();

            // Buscar coincidencia en Nombre o Email
            if (text.indexOf(term) > -1 || email.indexOf(term) > -1) {
                return data;
            }

            return null;
        }

        
        function formatUserOption(user) {
            if (!user.id) return user.text;

            const fullName = user.text || `${user.first_name} ${user.last_name}`;
            const initials = user.initials || 'U';
            const bgColors = [
                "bg-primary",
                "bg-secondary",
                "bg-success",
                "bg-warning",
                "bg-danger",
                "bg-info"
            ];

            const randomColor = bgColors[user.id % bgColors.length];
            
            return $(`
                <div class="d-flex align-items-center justify-content-between py-1">
                    <div class="d-flex align-items-center gap-2">
                        <!-- Avatar con las iniciales del backend -->
                        <div class="rounded-circle ${randomColor} text-white d-flex align-items-center justify-content-center flex-shrink-0 fw-bold"
                             style="width: 32px; height: 32px; font-size: 0.8rem;">
                            ${initials}
                        </div>
                        <div>
                            <strong class="d-block text-dark" style="font-size: 0.875rem;">${fullName}</strong>
                            <small class="text-muted" style="font-size: 0.75rem;">${user.email || ''}</small>
                        </div>
                    </div>
                    <span class="badge badge-soft-info text-mega fw-semibold" style="box-shadow: none !important;font-size: 0.7rem;">
                        Carga actual: ${selectedTickets.length || 0}/${user.tickets_count} tickets
                    </span>
                </div>
            `);
        }

        function formatUserSelection(user) {
            return user.text || user.placeholder;
        }

        

        $selectUser.on('change', function () {
            const selectedId = $(this).val();
        
            if (selectedId) {
                // Buscar la información completa desde nuestro arreglo en memoria
                const data = departmentUsers.find(user => user.id == selectedId);
                if (data) {
                    $('.display-name-user-asing-preview').text(`${data.text}`);
                    $('#assigned-user-info').html(`Carga actual: <small class="event-reload-count">${selectedTickets.length}</small> /${data.tickets_count}`);
                    
                    console.log(data)
                    
                }
            } else {
              
                $('.display-name-user-asing-preview').text(``);
                $('#assigned-user-info').text('');
              
            }

            checkConfirmButton();
        });

        
        loadDepartmentUsers();

        // ==========================================
        // EVENTOS DRAG & DROP
        // ==========================================
        const $dropZone = $('#drop-zone');
        const $assignedContainer = $('#assigned-tickets-container');


        // Inicio del arrastre en las cards de la izquierda
        $('#tickets-container').on('dragstart', '.draggable-ticket', function (e) {
           
            const ticketData = {
                uid: $(this).data('uid'),
                title: $(this).data('title'),
                firstName: $(this).data('first-name'),
                lastName: $(this).data('last-name'),
                service: $(this).data('service'),
                priority: $(this).data('priority'),
                initials: $(this).data('initials'),
                colorText: $(this).data('color-text'),
                colorBg: $(this).data('color-bg')
            };

            e.originalEvent.dataTransfer.setData(
                'text/plain',
                 JSON.stringify(ticketData)
            );

            e.originalEvent.dataTransfer.effectAllowed = 'move';
            $(this).addClass('opacity-50');
        });

        $('#tickets-container').on('dragend', '.draggable-ticket', function () {
            $(this).removeClass('opacity-50');
        });

        // Permitir Drop en la zona
        $dropZone.on('dragover', function (e) {
            
            e.preventDefault();

            e.originalEvent.dataTransfer.dropEffect = 'move';

            $(this)
            .removeClass('border-dashed')
            .addClass('border-solid');
           
        });

        $dropZone.on('dragleave', function () {
             $(this)
            .addClass('border-dashed')
            .removeClass('border-solid');
        });

        $dropZone.on('drop', function (e) {
            e.preventDefault();

            const rawData = e.originalEvent.dataTransfer.getData('text/plain');
            if (!rawData) return;

            // Convertimos la cadena de texto de nuevo a Objeto JS
            const ticket = JSON.parse(rawData);

            // Guardamos en un arreglo de objetos en lugar de solo IDs
            if (!selectedTickets.some(t => t.uid === ticket.uid)) {
                selectedTickets.push(ticket);

                // Ocultar card original de la izquierda
                $(`.draggable-ticket[data-uid="${ticket.uid}"]`).slideUp();

                renderAssignedTickets();
            }
        });

        $('#btn-confirm-assign').on('click', function () {
            const $btn = $(this);
            const userId = $selectUser.val();
            const selectedText = $selectUser.find('option:selected').text();

            if (!userId) {
                ui.showToast( 'warning', 'Debe seleccionar un usuario responsable');
                return;
            }

            if (selectedTickets.length === 0) {
                ui.showToast('warning', 'No hay tickets seleccionados para asignar');
                return;
            }

            // Bloquear el botón durante la petición
            $btn.prop('disabled', true).html(`
                <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
                Asignando...
            `);

            axios.post('/tickets/assign_bulk', {
                user_id: userId,
                uids: selectedTickets, 
                selectedName: selectedText
            })
            .then(response => {
                ui.showToast( 'success', response.data.message || 'Tickets asignados con éxito');

                selectedTickets = [];

                
                $assignedContainer.empty();
                $('#assigned-user-info').empty();

                
                $selectUser.val(null).trigger('change');


                loadDepartmentUsers();
                fetchAvailableTickets(currentPage);
            })
            .catch(error => {
                const errorMsg = error.response?.data?.message || 'Error al procesar la asignación';
                ui.showToast('error', errorMsg);
            })
            .finally(() => {
               
                console.log(selectedTickets)
                $btn.prop('disabled', false).html('Confirmar Asignación');
                checkConfirmButton();
            });
        });

        // Renderizar tarjetas en la zona asignada
        function renderAssignedTickets() {
            if (selectedTickets.length === 0) {
                $assignedContainer.html(`
                    <div class="text-center text-muted py-3 small">
                        No hay tickets arrastrados aún.
                    </div>
                `);
            } else {
               

                const html = selectedTickets.map(t =>  `
                    <div 
                    class="card border border-primary-subtle shadow-sm
                     p-2 d-flex flex-row align-items-center rounded-3 gap-2" style="border-left: 0.5em solid #fbca41 !important;">
                        <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0 fw-bold" style="width: 42px; height: 42px; font-size: 0.95rem;">
                            ${t?.initials ?? 'U'}
                        </div>
                        <div>
                            <div class="d-flex align-items-center gap-2">
                                <span class="text-mega">${t?.uid} - ${t?.title}</span>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                <span>${t?.firstName} ${t?.lastName}</span>
                                <span class="badge bg-ocean rounded p-2">${t?.service}</span>
                                <span class="badge rounded-pill p-2" style="background-color:${t?.colorBg} !important;color: ${t?.colorText} !important;">
                                    <i class="ti ti-pin"></i> Prioridad ${t?.priority}
                                </span>
                            </div>
                        </div>
                    </div>
                `).join('');

                $assignedContainer.html(html);

                $('.event-reload-count').text(selectedTickets.length);
            }

            checkConfirmButton();
        }

        // Remover ticket asignado y devolverlo a la lista
        $assignedContainer.on('click', '.btn-remove-ticket', function () {
            const uid = $(this).data('uid');
            selectedTickets = selectedTickets.filter(id => id !== uid);

            $(`.draggable-ticket[data-uid="${uid}"]`).slideDown();
            renderAssignedTickets();
        });

        function checkConfirmButton() {
            const userId = $selectUser.val();
            const hasTickets = selectedTickets.length > 0;
            $('#btn-confirm-assign').prop('disabled', !(userId && hasTickets));
        }
});