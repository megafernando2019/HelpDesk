import axios from 'axios';
import { ui } from '@/helpers/helper.js';
import Swal from 'sweetalert2';

'use strict';

$(document).ready(function () {

    let dateRangePicker = null;
    const modalObservation = $('#addObservationModal');
    const modalAssingUser = $('#assingUserModal');
    const observationDescription = $('#observationDescription');
    let supportUsersInMemory = [];

    /**
     * data actions
     */
    $('body').on('click', '[data-action=filter-by-status]', function (e) {
        const $card = $(e.currentTarget);
        const statusId = $card.data('id');
        const bgColor = $card.data('bgColor');
        const $container = $('#tickets-container');
        const priority = $('[data-action=filter-by-priority]').val() || 0;

        $container.attr('data-current-status', statusId);
        $('[data-action=filter-by-status]').removeClass('shadow shadow-lg');
        $card.addClass('shadow-lg');

        getTicketsDataKanban(statusId, bgColor, priority);
    });

    $(document).on('click', '.btn-assing-user', function () {
        const userAssing = $(this).data('userAssingId');
        console.log(userAssing)
        $('.current-user-assing').val(userAssing);

        fetchSupportUsers(parseInt(userAssing));

        modalAssingUser.modal('show');
    });

    $(document).on('click', '.ticket-add-observation', function () {
        const $this = $(this);
        const ticketId = $this.data('id');
        const priorityId = $this.data('priorityId');
        const userId = $this.data('userId');
        const statusId = $this.data('statusId');
        const observation = $this.data('observation');

        $('#modal_ticket_id').val(ticketId);
        $('#modal_ob_priority_id').val(priorityId);
        $('#modal_ob_status_id').val(statusId);
        $('#modal_ob_user_id').val(userId);
        observationDescription.val(observation);


        if (!observation || observation === '' || observation === undefined) {
            $('.save-modal-observation').prop('disabled', true);
            
        } else {
            $('.save-modal-observation').prop('disabled', false);
        }

        modalObservation.modal('show');
    });
   

    $('body').on('change', '[data-action=filter-by-priority]', function (e) {
        const $item = $(e.currentTarget);
        const priority = $item.val();
        const $container = $('#tickets-container');
        const currentStatus = $container.attr('data-current-status');

        getTicketsDataKanban(currentStatus, null, priority);
    });


    $('#addObservationModal').on('hidden.bs.modal', function () {
        $('#addObservationForm').trigger('reset');
        $('#modal_ticket_id').val('');
        observationDescription.text('');
        $('#modal_ob_priority_id').val('');
        $('#modal_ob_status_id').val('');
        $('#modal_ob_user_id').val('');
        observationDescription.removeClass('is-invalid');
        $('.error-input-observation').text('');
    });

    // Se ejecuta automáticamente cada vez que el modal se termina de cerrar
    $('#assingUserModal').on('hidden.bs.modal', function () {
        const $select = $('.select2-assignees');

        // Destruir instancia de Select2 y vaciar opciones HTML
        if ($select.data('select2')) {
            $select.select2('destroy');
        }
        $select.empty();

        // Limpiar campos de texto/inputs ocultos dentro del modal
        $(this).find('input[type="text"], input[type="hidden"]').val('');
    });

    $(document).on('input', '#observationDescription', function () {
        const value = $(this).val();

        if (!value || value === '' || value === undefined) {
            $('.save-modal-observation').prop('disabled', true);
            observationDescription.addClass('is-invalid');
            $('.error-input-observation').text('Debes agregar una observación para continuar.');
        } else {
            $('.save-modal-observation').prop('disabled', false);
            observationDescription.removeClass('is-invalid');
            $('.error-input-observation').text('');
        }

    });

    $('#addObservationForm').on('submit', function (e) {
        e.preventDefault();

        const $btn = $('.save-modal-observation');
        const ticketId = $('#modal_ticket_id').val();
        const description = observationDescription.val();
        const priorityId = $('#modal_ob_priority_id').val();
        const statusId = $('#modal_ob_status_id').val();
        const userId = $('#modal_ob_user_id').val();

        $btn.prop('disabled', true);

        axios.post('/save_observation', {
            ticket_id: ticketId,
            observation_d: description,
            ticket_priority_id: priorityId,
            status_id: statusId,
            user_id: userId
        })
        .then(function (response) {
            modalObservation.modal('hide');

            setTimeout(() => {
                Swal.fire({
                    title: "Observación guardada correctamente",
                    icon: "success",
                    showConfirmButton: false,
                    timer: 1500, 
                    draggable: true
                }).then(() => {
                    
                    getTicketsDataKanban(statusId);
                });
            }, 300);
        })
        .catch(function (error) {
            ui.showToast('error', 'Error al guardar la observación');
            console.log(error)
        })
        .finally(function() {
            $btn.prop('disabled', false);
        });
    });
    

    if($('#flatpickr-range-tickets').length > 0 ){
        
        dateRangePicker = flatpickr("#flatpickr-range-tickets", {
            mode: "range",
            dateFormat: "d-m-Y",
            locale: "es", 
            onChange: function(selectedDates, dateStr, instance) {
                
                if (selectedDates.length === 2) {
                    const $container = $('#tickets-container');
                    const currentStatus = $container.attr('data-current-status') || null;
                    const priority = $('[data-action=filter-by-priority]').val() || 0;
                    
                    getTicketsDataKanban(currentStatus, null, priority);
                }
            },
            onClose: function(selectedDates, dateStr, instance) {
               
            }
        });
    }

    async function fetchSupportUsers(assignedUserId = null) {
        try {
            const response = await axios.get('/users/get_by_department', {
                params: {
                    department_id: 2
                }
            });

            supportUsersInMemory = response.data.data || [];
            
        
            // Una vez recuperados los datos, poblamos e inicializamos Select2
            initAssigneeSelect2(supportUsersInMemory, assignedUserId);

        } catch (error) {
            console.error('Error al cargar los usuarios de soporte:', error);
            if (typeof ui !== 'undefined' && ui.showToast) {
                ui.showToast('error', 'No se pudieron cargar los encargados de soporte');
            }
        }
    }

   
    function initAssigneeSelect2(users = [], currentUserId = null) {
        const $select = $('.select2-assignees');

        if ($select.hasClass("select2-hidden-accessible")) {
            $select.select2('destroy');
        }

        $select.empty();

        // Convertir ID a String limpiando nulos para la comparación
        const selectedId = currentUserId !== null && currentUserId !== undefined && currentUserId !== '' 
            ? String(currentUserId) 
            : null;

        // 1. Opción por defecto ("Sin usuario asignado")
        const isNoneSelected = !selectedId;
        $select.append(new Option('Sin usuario asignado', '', isNoneSelected, isNoneSelected));

        // 2. Insertar usuarios
        users.forEach(user => {
            const fullName = `${user.first_name || ''} ${user.last_name || ''}`.trim();
        
            // Comparación estricta devolviendo BOOLEANO (true / false)
            const isSelected = String(user.id) === selectedId;

            // new Option(text, value, defaultSelected, selected)
            const option = new Option(fullName, user.id, isSelected, isSelected);

            $(option).attr('data-email', user.email || '');
            $(option).attr('data-initials', user.initials || 'SU');
            $(option).attr('data-name', fullName);

            $select.append(option);
        });

        // 3. Plantillas de renderizado
        function formatOption(state) {
            if (!state.id) {
                return $(`
                    <div class="d-flex align-items-center gap-2 py-1">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                            <i style="color: #6c757d !important;" class="ti ti-user text-muted fs-5"></i>
                        </div>
                        <div>
                            <div class="fw-bold text-dark lh-1">Sin usuario asignado</div>
                            <small class="text-muted" style="font-size: 11px;">Asignar</small>
                        </div>
                    </div>
                `);
            }

            const $el = $(state.element);
            const initials = $el.data('initials') || 'SU';
            const name = $el.data('name') || state.text;
            const email = $el.data('email') || '';

            return $(`
                <div class="d-flex align-items-center gap-2 py-1">
                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width: 32px; height: 32px; font-size: 12px; background-color: #ff9f43 !important;">
                        ${initials}
                    </div>
                    <div class="overflow-hidden">
                        <div class="fw-bold text-dark lh-1 text-truncate">${name}</div>
                        <small class="text-muted text-truncate d-block" style="font-size: 11px;">${email}</small>
                    </div>
                </div>
            `);
        }

        function formatSelection(state) {
            if (!state.id) {
                return $(`
                    <div class="d-flex align-items-center gap-2">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center flex-shrink-0" style="width: 26px; height: 26px;">
                            <i style="color: #6c757d !important;" class="ti ti-user text-muted fs-6"></i>
                        </div>
                        <span class="fw-bold text-dark fs-14">Sin usuario asignado</span>
                    </div>
                `);
            }

            const $el = $(state.element);
            const initials = $el.data('initials') || 'SU';
            const name = $el.data('name') || state.text;

            return $(`
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle text-white d-flex align-items-center justify-content-center fw-bold flex-shrink-0" style="width: 28px; height: 28px; font-size: 11px; background-color: #ff9f43;">
                        ${initials}
                    </div>
                    <span class="fw-bold text-dark fs-14">${name}</span>
                </div>
            `);
        }

        // 4. Inicializar Select2
        $select.select2({
            dropdownParent: $('#assingUserModal'),
            width: '100%',
            templateResult: formatOption,
            templateSelection: formatSelection,
            escapeMarkup: function(m) { return m; }
        });

        // 5. Asignar el valor explícitamente en el elemento HTML
        if (selectedId) {
            $select.val(selectedId).trigger('change.select2');
        } else {
            $select.val('').trigger('change.select2');
        }
    }


    function getTicketsDataKanban(
                                  status = null, 
                                  bgColor = null,
                                  priority = 0
    ) {

        const $container = $('#tickets-container');
        let startDate = null;
        let endDate = null;

        ui.showToast('info', 'Consultando tickets...');
        $container.addClass('item-disabled');

        if (dateRangePicker && dateRangePicker.selectedDates.length === 2) {
            startDate = dateRangePicker.formatDate(dateRangePicker.selectedDates[0], "Y-m-d");
            endDate = dateRangePicker.formatDate(dateRangePicker.selectedDates[1], "Y-m-d");
        }

        axios.get(
            '/get_my_tickets?ticket_status='+status+'&priority='+priority+'&start_date='+startDate+'&end_date='+endDate, {
        })
        .then(function (response) {
    
            const templateHtml = $('#ticket-card-template').html();
            const tickets = response.data.data || [];
            const colorsDefault = ["#fff3cd","#ff66c436", "#33ff572b", "#eee"];
            const colorsPriorityDefault = ["#ffe2e2", "#fff3dd", "#fffdca"];
            const textColorPriorityDefault = ["#ff5757","#fa995c","#eab308"];

            
            const priorityConfig = {
                'baja': {
                    text: '#eab308',
                    bg: '#eab3081a'
                },
                'media': {
                    text: '#fa995c',
                    bg: '#fa995c1a'
                },
                'alta': {
                    text: '#ff5757',
                    bg: '#ff57571a'
                },
                'muy alta': {
                    text: '#aa1515',
                    bg: '#aa15151a'
                }
            };

            $container.empty();

            if (bgColor) {
                $container.css('background-color', bgColor);
            }

            if (tickets.length === 0) {
                $container.html('<div class="col-12 text-center text-muted py-4">No se encontraron tickets</div>');
                return;
            }

            tickets.forEach((ticket, index) => {

                const currentColor = colorsDefault[index % colorsDefault.length];
                const currentColorPriority = colorsPriorityDefault[index % colorsPriorityDefault.length];
                const textCurrentColorPriority = textColorPriorityDefault[index % textColorPriorityDefault.length];

                const priorityKey = (ticket?.priorityName || '').toLowerCase().trim();
                const priorityStyles = priorityConfig[priorityKey] || {
                    text: '#6c757d',
                    bg: '#6c757d1a'
                };

                let assigned_name = ticket?.assignedUserName ?? '';

                let card = templateHtml
                    .replace(/{id}/g, ticket?.id || 0)
                    .replace(/{uid}/g, ticket?.uid || '')
                    .replace(/{title}/g, ticket?.title || 'Sin título')
                    .replace(/{status_id}/g, ticket?.statusId || 0)
                    .replace(/{priority_id}/g, ticket?.priorityId || 0)
                    .replace(/{user_id}/g, ticket?.userId || 0)
                    .replace(/{description}/g, ticket?.description || 'Sin descripción')
                    .replace(/{observation}/g, ticket?.observation || '')
                    .replace(/{priority_name}/g, ticket?.priorityName || 'N/A')
                    .replace(/{service_name}/g, ticket?.serviceName || 'General')
                    .replace(/{created_at}/g, ticket?.createdAt || '')
                    .replace(/{assigned_name}/g, assigned_name || 'Dato no disponible')
                    .replace(/{current_color}/g, currentColor || '#eee')
                    .replace(/{current_color_priority}/g, priorityStyles.bg || '#eee')
                    .replace(/{userAssingId}/g, ticket?.userAssingId || '')
                    .replace(/{txt_current_color_priority}/g, priorityStyles.text || '#eee');

                $container.append(card);
            });
           
        })
        .catch(function (error) {
            ui.showToast('error', 'Ocurrió un error durante la recuperación de los tickets, prueba más tarde.');
            console.log(error)
        })
        .finally(function () {
            $container.removeClass('item-disabled');
        });
    }


    getTicketsDataKanban(1);

});