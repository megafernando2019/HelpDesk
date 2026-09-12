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
        const ticketId = $(this).data('id');
        const statusId = $(this).data('statusId');

        $('.current-user-assing').val(userAssing);
        $('.ticket-id-modal-assign-user').val(ticketId);
        $('.status-id-modal-assing-user').val(statusId);

        fetchSupportUsers(parseInt(userAssing));

        if (userAssing === 0 || !userAssing || userAssing === undefined) {
            $('.save-modal-user-assign').html(`<i class="ti ti-user-check fs-16"></i>
            Asignar encargado`);
        } else {
            //Ya hay alguien asignado
            $('.save-modal-user-assign').html(`<i class="ti ti-user-check fs-16"></i>
            Reasignar encargado`);
        }

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
        $('#modal_ticket_id').val('');
        // observationDescription.text('');
        $('#modal_ob_priority_id').val('');
        $('#modal_ob_status_id').val('');
        $('#modal_ob_user_id').val('');
        observationDescription.removeClass('is-invalid');
        $('.error-input-observation').text('');
    });

    $('#assingUserModal').on('hidden.bs.modal', function () {
        const $select = $('.select2-assignees');

        if ($select.data('select2')) {
            $select.select2('destroy');
        }

        $select.empty();

        $(this).find('input[type="text"], input[type="hidden"]').val('');
    });


    $(document).on('input', '#observationDescription', function () {
        const value = $(this).val();

        if (!value || value === '' || value === undefined) {
            
            observationDescription.addClass('is-invalid');
            $('.error-input-observation').text('Debes agregar una observación para continuar.');
        } else {
            
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

         observationDescription.removeClass('is-invalid');
         $('.error-input-observation').text('');

        if (!description || description === '') {

           observationDescription.addClass('is-invalid');
           $('.error-input-observation').text('Debes agregar una observación para continuar');
           return;
        }

        const originalBtnText = $btn.html();

        $btn.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
            Guardando observación...
        `);

        axios.post('/save_observation', {
            ticket_id: ticketId,
            observation_d: description,
            ticket_priority_id: priorityId,
            status_id: statusId,
            user_id: userId
        })
        .then(function (response) {
            observationDescription.text('');
            observationDescription.val('');
            modalObservation.modal('hide');
            observationDescription.removeClass('is-invalid');
            $('.error-input-observation').text('');

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
            $btn.prop('disabled', false).html(originalBtnText);
        });
    });
    
    $('#addAssignUserForm').on('submit', function (e) {
        e.preventDefault();

        const $btn = $('.save-modal-user-assign');
        const ticketId = $('.ticket-id-modal-assign-user').val();
        // alert(ticketId);
        const userId = $('.select2-assignees').val();
        const statusId = $('.status-id-modal-assing-user').val();

        if (!userId || userId === 'Cargando usuarios...') {
            ui.showToast('error', 'Debes seleccionar un usuario almenos para continuar');
            return;
        }

        $btn.prop('disabled', true);

        axios.post('/assing_ticket_user', {
            ticket_id: ticketId,
            assignees: [userId]
        })
        .then(function (response) {
            modalAssingUser.modal('hide');

            setTimeout(() => {
                Swal.fire({
                    title: "Usuario asignado correctamente",
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
            ui.showToast('error', 'Error al asignar al usuario');
            console.log(error)
        })
        .finally(function() {
            $btn.prop('disabled', false);
        });
    });



    // if($('#flatpickr-range-tickets').length > 0 ){
        
    //     dateRangePicker = flatpickr("#flatpickr-range-tickets", {
    //         mode: "range",
    //         dateFormat: "d-m-Y",
    //         locale: "es", 
    //         onChange: function(selectedDates, dateStr, instance) {
                
    //             if (selectedDates.length === 2) {
    //                 const $container = $('#tickets-container');
    //                 const currentStatus = $container.attr('data-current-status') || null;
    //                 const priority = $('[data-action=filter-by-priority]').val() || 0;
                    
    //                 getTicketsDataKanban(currentStatus, null, priority);
    //             }
    //         },
    //         onClose: function(selectedDates, dateStr, instance) {
               
    //         }
    //     });
    // }

    async function fetchSupportUsers(assignedUserId = null) {

        const $select = $('.select2-assignees');
        const optionDefault = '<option>Cargando usuarios...</option>';

        $select.append(optionDefault);

        try {
            const response = await axios.get('/users/get_by_department', {
                params: {
                    department_id: 2
                }
            });

            supportUsersInMemory = response.data.data || [];
            
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

        const isNoneSelected = !selectedId;
        $select.append(new Option('Sin usuario asignado', '', isNoneSelected, isNoneSelected));

        users.forEach(user => {
            const fullName = `${user.first_name || ''} ${user.last_name || ''}`.trim();
            const isSelected = String(user.id) === selectedId;

            const option = new Option(fullName, user.id, isSelected, isSelected);

            $(option).attr('data-email', user.email || '');
            $(option).attr('data-initials', user.initials || 'SU');
            $(option).attr('data-name', fullName);

            $select.append(option);
        });

        function formatOption(state) {
            if (!state.id) {
                return $(`
                    <div class="d-flex align-items-center gap-2 py-1">
                        <div class="rounded-circle bg-light d-flex align-items-center justify-content-center flex-shrink-0" style="width: 32px; height: 32px;">
                            <i style="color: rgb(248, 249, 250) !important;" class="ti ti-user text-muted fs-5"></i>
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
                            <i style="color: rgb(248, 249, 250) !important;" class="ti ti-user text-muted fs-6"></i>
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

        $select.select2({
            dropdownParent: $('#assingUserModal'),
            width: '100%',
            templateResult: formatOption,
            templateSelection: formatSelection,
            escapeMarkup: function(m) { return m; }
        });

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

        const $containerSucess = $('#tickets-container-success');
        const $containerClosed = $('#tickets-container-close');
        const $containerCancel=  $('#tickets-container-cancel');
        let startDate = null;
        let endDate = null;
        let statuses = [4,5,6];

        ui.showToast('info', 'Consultando tickets...');
        $containerSucess.addClass('item-disabled');

        if (dateRangePicker && dateRangePicker.selectedDates.length === 2) {
            startDate = dateRangePicker.formatDate(dateRangePicker.selectedDates[0], "Y-m-d");
            endDate = dateRangePicker.formatDate(dateRangePicker.selectedDates[1], "Y-m-d");
        }

        axios.get(
            '/tickets/get_any_statuses?ticket_status='+statuses+'&priority='+priority+'&start_date='+startDate+'&end_date='+endDate, {
        })
        .then(function (response) {
    
            const templateHtmlComplete = $('#ticket-card-template-success').html();
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

            $containerSucess.empty();

            $containerCancel.empty();

            $containerClosed.empty();

          

            if (tickets.length === 0) {
                $containerSucess.html('<div class="col-12 text-center text-muted py-4">No se encontraron tickets</div>');
                return;
            }


            const ticketsCompleted = tickets.filter(ticket => {
                
                return ticket.status_id === 4;
            });

             const ticketsClose = tickets.filter(ticket => {
                
                return ticket.status_id === 5;
            });

             const ticketsCancel = tickets.filter(ticket => {
                
                return ticket.status_id === 6;
            });

            ticketsCompleted.forEach((ticket, index) => {

                const currentColor = colorsDefault[index % colorsDefault.length];
                const currentColorPriority = colorsPriorityDefault[index % colorsPriorityDefault.length];
                const textCurrentColorPriority = textColorPriorityDefault[index % textColorPriorityDefault.length];

                const priorityKey = (ticket?.priorityName || '').toLowerCase().trim();
                const priorityStyles = priorityConfig[priorityKey] || {
                    text: '#6c757d',
                    bg: '#6c757d1a'
                };

                let assigned_name = ticket?.assignedUserName ?? '';
                let item = `
                <div class="col-md-12 mb-3">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background-color: #fff;">
                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                
                            <div>
                                <!-- Encabezado: Servicio y Prioridad -->
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge text-dark fw-normal px-2 py-1" style="text-wrap: auto;border-radius: 6px; font-size: 11px; background-color: ${ticket?.current_color || ''};">
                                        ${ticket?.service_name}
                                    </span>
                                    <span class="badge fw-normal px-2 py-1 d-flex align-items-center gap-1" style="border-radius: 12px; font-size: 11px; color: ${ticket?.txt_current_color_priority || ''} !important; background-color: ${ticket?.current_color_priority || ''};">
                                        <i class="ti ti-pin fs-12"></i> Prioridad ${ticket?.priority_name}
                                    </span>
                                </div>

                                <!-- Título -->
                                <h6 class="text-mega fw-bold mb-0 text-truncate">
                                    ${ticket?.uid} - ${ticket?.title}
                                </h6>

                                <!-- Fecha -->
                                <small class="text-muted d-block mb-2" style="font-size: 11px;">
                                    Creado el ${ticket?.created_at || ''}
                                </small>

                                <!-- Descripción -->
                                <p class="text-secondary mb-3 small" style="font-size: 11px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    "${ticket?.description || ''}"
                                </p>
                            </div>

                            <!-- Footer: Acciones y Encargado -->
                            <div class="pt-2 d-flex border-top justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted d-block fw-semibold mb-1" style="font-size: 10px;">Acciones</small>
                                    <div class="d-flex gap-2">
                                        <a href="tickets/${ticket?.uid ?? ''}" data-action="ticket-show" data-id="${ticket?.id ?? 0}" class="text-secondary" title="Ver">
                                            <i class="ti ti-eye fs-18"></i>
                                        </a>
                                        <a 
                                                href="javascript:void(0);" 
                                                data-id="${ticket?.id ?? 0}" 
                                                data-status-id="${ticket?.status_id ?? 0}"  
                                                data-priority-id="${ticket?.priority_id ?? 0}"
                                                data-user-id="${ticket?.user_id ?? 0}" 
                                                data-observation="${ticket?.observation ?? 0}"
                                                class="text-secondary ticket-add-observation" 
                                                title="Editar">
                                            <i class="ti ti-edit-circle fs-18"></i>
                                        </a>
                                        <a 
                                            href="javascript:void(0);"
                                            data-id="${ticket?.id ?? 0}"
                                            data-user-assing-id="${ticket?.userAssingId ?? 0}"
                                            data-status-id="${ticket?.status_id ?? 0}" 
                                            class="btn-assing-user"
                                            >
                                            <i class="ti ti-user-check fs-18"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="border-start ps-3 text-start">
                                    <small class="text-muted d-block fw-semibold mb-1" style="font-size: 10px;">Encargado</small>
                                    <span class="fw-medium text-dark" style="font-size: 11px;">
                                        ${ticket?.assigned_name ?? ''}
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                `;



                $containerSucess.append(item);
            });

            ticketsCancel.forEach((ticket, index) => {

                const currentColor = colorsDefault[index % colorsDefault.length];
                const currentColorPriority = colorsPriorityDefault[index % colorsPriorityDefault.length];
                const textCurrentColorPriority = textColorPriorityDefault[index % textColorPriorityDefault.length];

                const priorityKey = (ticket?.priorityName || '').toLowerCase().trim();
                const priorityStyles = priorityConfig[priorityKey] || {
                    text: '#6c757d',
                    bg: '#6c757d1a'
                };

                let assigned_name = ticket?.assignedUserName ?? '';
                let item = `
                <div class="col-md-12 mb-3">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background-color: #fff;">
                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                
                            <div>
                                <!-- Encabezado: Servicio y Prioridad -->
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge text-dark fw-normal px-2 py-1" style="text-wrap: auto;border-radius: 6px; font-size: 11px; background-color: ${ticket?.current_color || ''};">
                                        ${ticket?.service_name}
                                    </span>
                                    <span class="badge fw-normal px-2 py-1 d-flex align-items-center gap-1" style="border-radius: 12px; font-size: 11px; color: ${ticket?.txt_current_color_priority || ''} !important; background-color: ${ticket?.current_color_priority || ''};">
                                        <i class="ti ti-pin fs-12"></i> Prioridad ${ticket?.priority_name}
                                    </span>
                                </div>

                                <!-- Título -->
                                <h6 class="text-mega fw-bold mb-0 text-truncate">
                                    ${ticket?.uid} - ${ticket?.title}
                                </h6>

                                <!-- Fecha -->
                                <small class="text-muted d-block mb-2" style="font-size: 11px;">
                                    Creado el ${ticket?.created_at || ''}
                                </small>

                                <!-- Descripción -->
                                <p class="text-secondary mb-3 small" style="font-size: 11px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    "${ticket?.description || ''}"
                                </p>
                            </div>

                            <!-- Footer: Acciones y Encargado -->
                            <div class="pt-2 d-flex border-top justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted d-block fw-semibold mb-1" style="font-size: 10px;">Acciones</small>
                                    <div class="d-flex gap-2">
                                        <a href="tickets/${ticket?.uid ?? ''}" data-action="ticket-show" data-id="${ticket?.id ?? 0}" class="text-secondary" title="Ver">
                                            <i class="ti ti-eye fs-18"></i>
                                        </a>
                                        <a 
                                                href="javascript:void(0);" 
                                                data-id="${ticket?.id ?? 0}" 
                                                data-status-id="${ticket?.status_id ?? 0}"  
                                                data-priority-id="${ticket?.priority_id ?? 0}"
                                                data-user-id="${ticket?.user_id ?? 0}" 
                                                data-observation="${ticket?.observation ?? 0}"
                                                class="text-secondary ticket-add-observation" 
                                                title="Editar">
                                            <i class="ti ti-edit-circle fs-18"></i>
                                        </a>
                                        <a 
                                            href="javascript:void(0);"
                                            data-id="${ticket?.id ?? 0}"
                                            data-user-assing-id="${ticket?.userAssingId ?? 0}"
                                            data-status-id="${ticket?.status_id ?? 0}" 
                                            class="btn-assing-user"
                                            >
                                            <i class="ti ti-user-check fs-18"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="border-start ps-3 text-start">
                                    <small class="text-muted d-block fw-semibold mb-1" style="font-size: 10px;">Encargado</small>
                                    <span class="fw-medium text-dark" style="font-size: 11px;">
                                        ${ticket?.assigned_name ?? ''}
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                `;



                $containerCancel.append(item);
            });

            ticketsClose.forEach((ticket, index) => {

                const currentColor = colorsDefault[index % colorsDefault.length];
                const currentColorPriority = colorsPriorityDefault[index % colorsPriorityDefault.length];
                const textCurrentColorPriority = textColorPriorityDefault[index % textColorPriorityDefault.length];

                const priorityKey = (ticket?.priorityName || '').toLowerCase().trim();
                const priorityStyles = priorityConfig[priorityKey] || {
                    text: '#6c757d',
                    bg: '#6c757d1a'
                };

                let assigned_name = ticket?.assignedUserName ?? '';
                let item = `
                <div class="col-md-12 mb-3">
                    <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background-color: #fff;">
                        <div class="card-body p-3 d-flex flex-column justify-content-between">
                
                            <div>
                                <!-- Encabezado: Servicio y Prioridad -->
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="badge text-dark fw-normal px-2 py-1" style="text-wrap: auto;border-radius: 6px; font-size: 11px; background-color: ${ticket?.current_color || ''};">
                                        ${ticket?.service_name}
                                    </span>
                                    <span class="badge fw-normal px-2 py-1 d-flex align-items-center gap-1" style="border-radius: 12px; font-size: 11px; color: ${ticket?.txt_current_color_priority || ''} !important; background-color: ${ticket?.current_color_priority || ''};">
                                        <i class="ti ti-pin fs-12"></i> Prioridad ${ticket?.priority_name}
                                    </span>
                                </div>

                                <!-- Título -->
                                <h6 class="text-mega fw-bold mb-0 text-truncate">
                                    ${ticket?.uid} - ${ticket?.title}
                                </h6>

                                <!-- Fecha -->
                                <small class="text-muted d-block mb-2" style="font-size: 11px;">
                                    Creado el ${ticket?.created_at || ''}
                                </small>

                                <!-- Descripción -->
                                <p class="text-secondary mb-3 small" style="font-size: 11px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                    "${ticket?.description || ''}"
                                </p>
                            </div>

                            <!-- Footer: Acciones y Encargado -->
                            <div class="pt-2 d-flex border-top justify-content-between align-items-center">
                                <div>
                                    <small class="text-muted d-block fw-semibold mb-1" style="font-size: 10px;">Acciones</small>
                                    <div class="d-flex gap-2">
                                        <a href="tickets/${ticket?.uid ?? ''}" data-action="ticket-show" data-id="${ticket?.id ?? 0}" class="text-secondary" title="Ver">
                                            <i class="ti ti-eye fs-18"></i>
                                        </a>
                                        <a 
                                                href="javascript:void(0);" 
                                                data-id="${ticket?.id ?? 0}" 
                                                data-status-id="${ticket?.status_id ?? 0}"  
                                                data-priority-id="${ticket?.priority_id ?? 0}"
                                                data-user-id="${ticket?.user_id ?? 0}" 
                                                data-observation="${ticket?.observation ?? 0}"
                                                class="text-secondary ticket-add-observation" 
                                                title="Editar">
                                            <i class="ti ti-edit-circle fs-18"></i>
                                        </a>
                                        <a 
                                            href="javascript:void(0);"
                                            data-id="${ticket?.id ?? 0}"
                                            data-user-assing-id="${ticket?.userAssingId ?? 0}"
                                            data-status-id="${ticket?.status_id ?? 0}" 
                                            class="btn-assing-user"
                                            >
                                            <i class="ti ti-user-check fs-18"></i>
                                        </a>
                                    </div>
                                </div>

                                <div class="border-start ps-3 text-start">
                                    <small class="text-muted d-block fw-semibold mb-1" style="font-size: 10px;">Encargado</small>
                                    <span class="fw-medium text-dark" style="font-size: 11px;">
                                        ${ticket?.assigned_name ?? ''}
                                    </span>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                `;



                $containerClosed.append(item);
            });
           
        })
        .catch(function (error) {
            ui.showToast('error', 'Ocurrió un error durante la recuperación de los tickets, prueba más tarde.');
            console.log(error)
        })
        .finally(function () {
            $containerClosed.removeClass('item-disabled');
            $containerSucess.removeClass('item-disabled');
            $containerCancel.removeClass('item-disabled');
        });
    }


    getTicketsDataKanban(1);

});