'use strict';


import axios from "axios";

$(document).ready(function () {

    const $selectUserOld = $('.select2-users-old-assing');
    const $selectUserNewAssign = $('.select2-users-new-assing');
    let selectedTickets = [];
    let ticketsDataUserOld = [];
    let ticketsDataUserNew = [];

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


    function formatUserOption(user, typeSelect) {
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
        const isNew = (typeSelect === 'new');

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
                Carga actual: ${isNew ? 
                    ticketsDataUserNew.length || 0 :
                    ticketsDataUserOld.length || 0
                }/${user.tickets_count} tickets
            </span>
        </div>
    `);
    }

    function formatUserSelection(user) {
        return user.text || user.placeholder;
    }

    //usuario anterior asignado select2
    async function initSelectOldAssingU() {
        $selectUserOld.prop('disabled', true);
        let dataUsers = await loadDepartmentUsers();

        $selectUserOld.prop('disabled', false);
        $selectUserOld.empty();

        $selectUserOld.select2({
            placeholder: 'Buscar y seleccionar un usuario responsable...',
            allowClear: true,
            data: dataUsers,
            matcher: customUserMatcher, 
            templateResult: function(user) {
                return formatUserOption(user, 'old');
            },
            templateSelection: formatUserSelection
        });

    
        $selectUserOld.val(null).trigger('change');
    }


    //usuario a asignar select2
    async function initSelectNewAssingU() {
        $selectUserNewAssign.prop('disabled', true);
        let dataUsers = await loadDepartmentUsers();

        $selectUserNewAssign.prop('disabled', false);
        $selectUserNewAssign.empty();

        $selectUserNewAssign.select2({
            placeholder: 'Buscar y seleccionar un usuario responsable...',
            allowClear: true,
            data: dataUsers,
            matcher: customUserMatcher, 
            templateResult: function(user) {
                return formatUserOption(user, 'new');
            },
            templateSelection: formatUserSelection
        });

    
        $selectUserNewAssign.val(null).trigger('change');
    }

    async function loadDepartmentUsers() {
      return axios.get('/users/get_by_department', {
            params: { department_id: 2 }
        })
            .then(response => {
                const usersData = response.data.data || [];
                let departmentUsers = [];

                // Mapeo al formato esperado por Select2 y guardado en memoria
                departmentUsers = usersData.map(user => ({
                    id: user.id,
                    text: `${user.first_name} ${user.last_name}`,
                    email: user.email,
                    tickets_count: user.active_tickets_count || 0,
                    initials: user?.initials ?? null,
                    tickets_count: user?.tickets_count || 0
                }));

                
                return departmentUsers

            })
            .catch(error => {
                console.error('Error al cargar los usuarios del departamento:', error);
                ui.showToast('error', 'Error al cargar los usuarios del departamento:');
            });
    }

    async function fetchTicketsByUser(userId = 0) {
        try {
            const response = await axios.get('/get_tickets_to_user_assing', {
                params: { user_id: userId }
            });

            return response.data;

        } catch (error) {
            console.error('Error al cargar los usuarios del departamento:', error);
            ui.showToast('error', 'Error al cargar los usuarios del departamento:');
            return [];
        }
    }


    $($selectUserOld).change( async function () { 
        const userId = $(this).val();
        
        if (userId) {
            ui.showToast('info', 'Mostrando tickets...');
        $('#containerUserOld').addClass('opacity-50 pe-none');
           ticketsDataUserOld = await fetchTicketsByUser(userId);

           renderTicketsList(ticketsDataUserOld, '#containerUserOld');

           $('#containerUserOld').removeClass('opacity-50 pe-none');
        } else {
            renderTicketsList([], '#containerUserOld');
        }
       
    });

    $($selectUserNewAssign).change(async function () { 
        const userId = $(this).val();
        
        if (userId) {
             ui.showToast('info', 'Mostrando tickets...');
             $('#containerUserNew').addClass('opacity-50 pe-none');
             ticketsDataUserNew = await fetchTicketsByUser(userId);

             renderTicketsList(ticketsDataUserNew, '#containerUserNew');

             $('#containerUserNew').removeClass('opacity-50 pe-none');
        } else {
            renderTicketsList([], '#containerUserNew');
        }
       
    });


    /**
     * Renderiza una lista de cards de tickets en el contenedor especificado.
     * @param {Array} tickets - Array de objetos ticket provenientes del servidor.
     * @param {string|jQuery} containerSelector - Selector jQuery o elemento donde se insertará el HTML.
     */
    function renderTicketsList(tickets, containerSelector) {
        const $container = $(containerSelector);

        // Validar que el array exista y no esté vacío
        if (!Array.isArray(tickets) || tickets.length === 0) {
            $container.html(`
                <div class="text-center text-muted p-4 border rounded-3 bg-light">
                    <i class="ti ti-ticket-off fs-2 mb-2 d-block"></i>
                    <span>Sin tickets por mostrar aún.</span>
                </div>
            `);
            return;
        }

        
        const htmlCards = tickets.map(ticket => {
            const uid = ticket?.uid ?? '';
            const title = ticket?.title ?? 'Sin título';
            const description = ticket?.description ?? 'Sin descripción';
            const firstName = ticket?.user_ticket_first_name ?? '';
            const lastName = ticket?.user_ticket_last_name ?? '';
            const fullName = `${firstName} ${lastName}`.trim() || 'Usuario Desconocido';
            const servicesName = ticket?.services_name ?? '';
            const priorityName = ticket?.priority_name ?? 'N/A';
            const createdAtHuman = ticket?.created_at_human ?? ticket?.created_at ?? '';
            const initials = ticket?.initials ?? 'U';

            // Colores con fallbacks seguros
            const textColor = ticket?.priority_colors?.text || '#eab308';
            const bgColor = ticket?.priority_colors?.bg || '#eab3081a';

            return `
                <div class="card shadow-sm border rounded-3 user-select-text draggable-ticket mb-2" 
                     draggable="true" 
                     data-uid="${uid}"
                     data-title="${title}"
                     data-first-name="${firstName}"
                     data-last-name="${lastName}"
                     data-service="${servicesName}"
                     data-priority="${priorityName}"
                     data-initials="${initials}"
                     data-color-text="${textColor}"
                     data-color-bg="${bgColor}"
                >
                    <div class="card-body p-3">
                        <!-- Meta: Prioridad y Fecha -->
                        <div class="d-flex align-items-center gap-2 justify-content-end mb-2">
                            <span class="badge rounded-pill fw-semibold d-inline-flex align-items-center gap-1"
                                  style="color: ${textColor} !important; background-color: ${bgColor} !important; font-size: 0.75rem;">
                                <i class="ti ti-pin" style="font-size: 0.85rem;"></i>
                                Prioridad ${priorityName}
                            </span>
                            <small class="text-muted fw-normal" style="font-size: 0.75rem;">
                                ${createdAtHuman}
                            </small>
                        </div>

                        <!-- Encabezado de la card: Avatar, Título y Badges -->
                        <div class="d-flex align-items-center gap-3">
                            <!-- Avatar con Iniciales -->
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center flex-shrink-0 fw-bold"
                                 style="width: 42px; height: 42px; font-size: 0.95rem;">
                                ${initials}
                            </div>

                            <!-- Contenido Principal -->
                            <div class="flex-grow-1 min-w-0">
                                <div class="d-flex align-items-center justify-content-between gap-2 flex-wrap mb-1">
                                    <!-- UID y Título -->
                                    <h6 style="text-wrap: auto;" class="mb-0 fw-bold text-mega text-truncate">
                                        ${uid ? `${uid} - ` : ''}${title}
                                    </h6>
                                </div>

                                <!-- Nombre de Usuario y Badge de Servicio -->
                                <div class="d-flex align-items-center gap-2 flex-wrap mt-1">
                                    <small class="text-secondary">
                                        ${fullName}
                                    </small>

                                    ${servicesName ? `
                                        <span style="background-color: #eff4ff; border:none;" class="badge text-secondary border" style="font-size: 0.725rem;">
                                            ${servicesName}
                                        </span>
                                    ` : ''}
                                </div>
                            </div>
                        </div>  
                        <div class="mt-2 text-break">"${description}"</div>
                    </div>
                </div>
            `;
        }).join('');

        $container.html(htmlCards);
    }

    /**
     * DRAG & DROP
     */
    $('#btnSaveAssignments').on('click', async function () {
        
        const $btn = $(this);
        const $selectNew = $('.select2-users-new-assing');
        const newUserId = $selectNew.val();
        const selectedUserData = $selectNew.select2('data')[0];
        const selectedName = selectedUserData ? selectedUserData.text : '';

        // Extraer todos los UIDs que quedaron en la columna del usuario nuevo
        const uidsToAssign = ticketsDataUserNew.map(ticket => ticket.uid);

        if (!newUserId) {
            ui.showToast('warning', 'Seleccione un usuario destino para asignar los tickets.');
            return;
        }

        if (uidsToAssign.length === 0) {
            ui.showToast('info', 'No hay tickets en la lista del nuevo usuario para reasignar.');
            return;
        }

        try {

            $btn.prop('disabled', true).html(`
                <span class="spinner-border spinner-border-sm me-1" 
                      role="status" 
                      aria-hidden="true"></span>
                Reasignando...
            `);

            ui.showToast('info', 'Reasignando usuarios...');

            const response = await axios.post('/tickets/assign_bulk', {
                user_id: newUserId,
                uids: uidsToAssign,
                selectedName: selectedName
            });

            
            ui.showToast('success', 'Tickets reasignados correctamente.');

            // Vacio mis arrays
            ticketsDataUserOld = [];
            ticketsDataUserNew = [];

            // Limpiar los contenedores HTML
            renderTicketsList([], '#containerUserOld');
            renderTicketsList([], '#containerUserNew');
            
            initSelectNewAssingU();
            initSelectOldAssingU();

            $btn.prop('disabled', false).html('Confirmar Asignación');
            
        } catch (error) {
            console.error('Error al reasignar tickets:', error);
            ui.showToast('error', 'Error al guardar la reasignación.');
        } finally {
            $btn.prop('disabled', false).html(`<i class="ti ti-replace-user me-1"></i>
             Confirmar reasignación`);
        }
    });

    function initDragAndDrop() {
        // Escuchar eventos en las cards mediante delegación de eventos en el document
        $(document).on('dragstart', '.draggable-ticket', function (e) {
            const uid = $(this).attr('data-uid');

            console.log(uid)
            
            // Determinar si la card viene del contenedor Old o New
            const originContainer = $(this).closest('#containerUserOld').length ? 'old' : 'new';

            console.log('origin container ', originContainer)
            
            // Guardar metadatos en el DataTransfer de la API de Drag & Drop
            e.originalEvent.dataTransfer.setData('text/plain', JSON.stringify({ uid, originContainer }));
            e.originalEvent.dataTransfer.effectAllowed = 'move';
            
            $(this).addClass('opacity-50 border-primary');
        });

        $(document).on('dragend', '.draggable-ticket', function () {
            $(this).removeClass('opacity-50 border-primary');
        });

        // Configurar las zonas de soltar (Dropzones)
        setupDropzone('#containerUserOld', 'old');
        setupDropzone('#containerUserNew', 'new');
    }


    function setupDropzone(containerSelector, containerType) {
        const $container = $(containerSelector);

        $container.on('dragover', function (e) {
            e.preventDefault();
            e.originalEvent.dataTransfer.dropEffect = 'move';
            $(this).addClass('bg-light border-dashed border-primary');
        });

        $container.on('dragleave border-light', function (e) {
            $(this).removeClass('bg-light border-dashed border-primary');
        });

        $container.on('drop', function (e) {
            e.preventDefault();
            $(this).removeClass('bg-light border-dashed border-primary');

            const dataRaw = e.originalEvent.dataTransfer.getData('text/plain');
            if (!dataRaw) return;

            const { uid, originContainer } = JSON.parse(dataRaw);

            // Evitar procesar si se suelta en el mismo contenedor de origen
            if (originContainer === containerType) return;

            // Transferir la data en las variables de memoria JS
            moveTicketData(uid, originContainer, containerType);
        });
    }

    function moveTicketData(uid, origin, destination) {
        let sourceArray = origin === 'old' ? ticketsDataUserOld : ticketsDataUserNew;
        let targetArray = destination === 'old' ? ticketsDataUserOld : ticketsDataUserNew;

        // Buscar el ticket por su UID en el array origen
        const ticketIndex = sourceArray.findIndex(t => t.uid === uid);

        // console.log('ticket index', ticketIndex)
        debugger;
        if (ticketIndex === -1) return;

        // Extraer el ticket del origen e insertarlo en el destino
        const [movedTicket] = sourceArray.splice(ticketIndex, 1);
        targetArray.push(movedTicket);

        // Volver a renderizar ambos contenedores para reflejar los cambios
        renderTicketsList(ticketsDataUserOld, '#containerUserOld');
        renderTicketsList(ticketsDataUserNew, '#containerUserNew');

        // console.log('Que contiene target array', targetArray)
        console.log('Tickets Usuario Origen actualizados:', ticketsDataUserOld);
        console.log('Tickets Usuario Destino actualizados:', ticketsDataUserNew);
    }

    initSelectOldAssingU();
    initSelectNewAssingU();
    initDragAndDrop();

});
