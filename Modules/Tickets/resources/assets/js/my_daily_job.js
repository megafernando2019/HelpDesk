import axios from 'axios';
import { ui } from '@/helpers/helper.js';
import Swal from 'sweetalert2';

'use strict';

$(document).ready(function () {

    $('body').tooltip({
        selector: '[data-bs-toggle="tooltip"]',
        trigger: 'hover'
    });

    let dateRangePicker = null;
    const modalObservation = $('#addObservationModal');
    const observationDescription = $('#observationDescription');
    const modalAssingUser = $('#assingUserModal');
    const $selectUserAssing = $('.select2-assignees');
    let currentTeamId = $('.metadata-page-asing').data('teamId');
    let countTicketsWaiting = 0;
    let countTicketsToAssing = 0;
    let countticketsProgress = 0;
    let departmentUsers = [];

    /**
     * data actions
     */

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

        getTicketsDataKanban(0, priority);
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
    
   

    if ($('#flatpickr-range-tickets-job-daily').length > 0 ){
        
        console.log($('#flatpickr-range-tickets-job-daily'))
        dateRangePicker = flatpickr("#flatpickr-range-tickets-job-daily", {
            mode: "range",
            dateFormat: "d-m-Y",
            locale: "es", 
            onChange: function(selectedDates, dateStr, instance) {
                
                if (selectedDates.length === 2) {
                    const $container = $('#tickets-container');
                    const currentStatus = $container.attr('data-current-status') || null;
                    const priority = $('[data-action=filter-by-priority]').val() || 0;
                    
                    getTicketsDataKanban(0, priority);
                }
            },
            onClose: function(selectedDates, dateStr, instance) {
               
            }
        });
    }

    function loadingKanban(isLoading = true) {
        const $containers = $('.container-load-tickets');

        if (isLoading) {
            $containers.css({
                'opacity': '0.5',
                'pointer-events': 'none'
            });
        } else {
            $containers.css({
                'opacity': '1',
                'pointer-events': 'auto'
            });
        }
    }

    function getTicketsDataKanban(statusAction = 0,
                                  priority=null) 
    {

        const $containerToAssing = $('#tickets-container-to-assing');
        const $containerProgress = $('#tickets-container-progress');
        const $containerWaiting=  $('#tickets-container-waiting');
        let startDate = null;
        let endDate = null;
        let statuses = [1,2,3];

        loadingKanban();

        if (statusAction === 0) {
             ui.showToast('info', 'Consultando tickets...');
        }
        //$containerSucess.addClass('item-disabled');

        if (dateRangePicker && dateRangePicker.selectedDates.length === 2) {
            startDate = dateRangePicker.formatDate(dateRangePicker.selectedDates[0], "Y-m-d");
            endDate = dateRangePicker.formatDate(dateRangePicker.selectedDates[1], "Y-m-d");
        }

        axios.get(
            '/tickets/get_any_statuses?ticket_status='+statuses+'&priority='+priority+'&start_date='+startDate+'&end_date='+endDate, {
        })
        .then(function (response) {
    
            const tickets = response.data.data || [];
            const colorsDefault = ["#fff3cd","#ff66c436", "#33ff572b", "#eee"];
            const bgColors = [
                "bg-primary",
                "bg-secondary",
                "bg-success",
                "bg-warning",
                "bg-danger",
                "bg-info"
            ];

            $containerToAssing.empty();

            $containerWaiting.empty();

            $containerProgress.empty();


            const ticketsToAssing = tickets.filter(ticket => {
                
                return ticket.status_id === 1;
            });

            const ticketsWaiting = tickets.filter(ticket => {
                
                return ticket.status_id === 3;
            });

            const ticketsProgress = tickets.filter(ticket => {
                
                return ticket.status_id === 2;
            });

             countTicketsToAssing = ticketsToAssing.length;
             countTicketsWaiting = ticketsWaiting.length;
             countticketsProgress = ticketsProgress.length;

            if (ticketsToAssing.length === 0) {
                $containerToAssing.html('<div class="col-12 text-center text-muted py-4">No se encontraron tickets</div>');
                
            } else {

                 ticketsToAssing.forEach((ticket, index) => {

                    const currentColor = colorsDefault[index % colorsDefault.length];
                    const randomColor = bgColors[ticket.id % bgColors.length];

                    let assigned_name = (ticket?.assigned_first_name ?? '')+ ' ' +(ticket?.assigned_last_name ?? '');
                    let item = `
                    <div class="col-md-12 mb-3">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background-color: #fff;">
                            <div class="card-body p-3 d-flex flex-column justify-content-between">
                
                                <div>
                                    <!-- Encabezado: Servicio y Prioridad -->
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge text-dark fw-normal px-2 py-1" style="text-wrap: auto;border-radius: 6px; font-size: 11px; background-color: ${currentColor || ''};">
                                            ${ticket?.service_name}
                                        </span>
                                        <span class="badge fw-normal px-2 py-1 d-flex align-items-center gap-1" style="border-radius: 12px; font-size: 11px; color: ${ticket?.priority?.text || ''} !important; background-color: ${ticket?.priority?.bg || ''};">
                                            <i class="ti ti-pin fs-12"></i> Prioridad ${ticket?.priority_name}
                                        </span>
                                    </div>

                                     <div class="d-flex gap-2">
                                        <div class="content-initials">
                                            <div class="rounded-circle ${randomColor} text-white d-flex align-items-center justify-content-center flex-shrink-0 fw-bold"
                                                 style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                ${ticket?.initials_user_create ?? 'U'}
                                            </div>
                                        </div>
                                        <div class="d-flex" style="flex-direction: column;">
                                            <!-- Título -->
                                            <h6 class="text-mega fw-bold mb-0 text-truncate" style="text-wrap: auto;">
                                                ${ticket?.uid} - ${ticket?.title}
                                            </h6>

                                            <!-- Fecha -->
                                            <small class="text-muted d-block mb-2" style="font-size: 11px;">
                                                ${ticket?.user_first_name_create || ''} ${ticket?.user_last_name_create || ''}
                                            </small>
                                        </div>
                                    </div>

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
                                            <a href="/tickets/${ticket?.uid ?? ''}" 
                                            data-action="ticket-show" 
                                            data-id="${ticket?.id ?? 0}" 
                                            class="text-secondary"
                                            data-bs-toggle="tooltip"
                                            title="Ver">
                                                <i class="ti ti-eye fs-18"></i>
                                            </a>
                                            <a 
                                                    href="javascript:void(0);" 
                                                    data-id="${ticket?.id ?? 0}" 
                                                    data-status-id="2"  
                                                    data-user-id="${ticket?.user_id ?? 0}"
                                                    data-uid="${ticket?.uid ?? ''}"
                                                    class="text-secondary ticket-status-process" 
                                                    data-bs-toggle="tooltip"
                                                    title="En proceso">
                                                    <i class="ti ti-progress-check fs-18"></i>
                                            </a>
                                            <a 
                                                    href="javascript:void(0);" 
                                                    data-id="${ticket?.id ?? 0}" 
                                                    data-status-id="6"  
                                                    data-user-id="${ticket?.user_id ?? 0}" 
                                                    data-uid="${ticket?.uid ?? ''}"
                                                    class="text-secondary ticket-status-cancel" 
                                                    data-bs-toggle="tooltip"
                                                    title="Cancelar">
                                                    <i class="ti ti-cancel fs-18"></i>
                                            </a>
                                            <a 
                                                    href="javascript:void(0);" 
                                                    data-id="${ticket?.id ?? 0}" 
                                                    data-status-id="${ticket?.status_id ?? 0}"  
                                                    data-priority-id="${ticket?.ticket_priority_id ?? 0}"
                                                    data-user-id="${ticket?.user_id ?? 0}" 
                                                    data-observation="${ticket?.observation ?? ''}"
                                                    class="text-secondary ticket-add-observation" 
                                                    data-bs-toggle="tooltip"
                                                    title="Agregar observación">
                                                <i class="ti ti-edit-circle fs-18"></i>
                                            </a>
                                            <a 
                                                href="javascript:void(0);"
                                                data-id="${ticket?.id ?? 0}"
                                                data-user-assing-id="${ticket?.assigned_id}"
                                                class="btn-assing-user"
                                                data-bs-toggle="tooltip"
                                                title="
                                                    ${ticket?.assigned_id 
                                                        ? 'Reasignar'
                                                        : 'Asignar'
                                                    }"
                                                >
                                                ${ticket?.assigned_id 
                                                    ? '<i class="ti ti-replace-user"></i>'
                                                    : ' <i class="ti ti-user-check fs-18"></i>'
                                                }
                                            </a>
                                        </div>
                                    </div>

                                    <div class="border-start ps-3 text-start">
                                        <small class="text-muted d-block fw-semibold mb-1" style="font-size: 10px;">Encargado</small>
                                        <span class="fw-medium text-dark" style="font-size: 11px;">
                                            ${assigned_name}
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    `;



                    $containerToAssing.append(item);
                });
            }

            if (ticketsProgress.length === 0) {
                $containerProgress.html('<div class="col-12 text-center text-muted py-4">No se encontraron tickets</div>');
                
            } else {
                
                 ticketsProgress.forEach((ticket, index) => {

                    const currentColor = colorsDefault[index % colorsDefault.length];
                    const randomColor = bgColors[ticket.id % bgColors.length];
                
                    let assigned_name = (ticket?.assigned_first_name ?? '')+ ' ' +(ticket?.assigned_last_name ?? '');
                    let item = `
                    <div class="col-md-12 mb-3">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background-color: #fff;">
                            <div class="card-body p-3 d-flex flex-column justify-content-between">
                
                                <div>
                                    <!-- Encabezado: Servicio y Prioridad -->
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge text-dark fw-normal px-2 py-1" style="text-wrap: auto;border-radius: 6px; font-size: 11px; background-color: ${currentColor || ''};">
                                            ${ticket?.service_name}
                                        </span>
                                        <span class="badge fw-normal px-2 py-1 d-flex align-items-center gap-1" style="border-radius: 12px; font-size: 11px; color: ${ticket?.priority?.text || ''} !important; background-color: ${ticket?.priority?.bg || ''};">
                                            <i class="ti ti-pin fs-12"></i> Prioridad ${ticket?.priority_name}
                                        </span>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <div class="content-initials">
                                            <div class="rounded-circle ${randomColor} text-white d-flex align-items-center justify-content-center flex-shrink-0 fw-bold"
                                                 style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                ${ticket?.initials_user_create ?? 'U'}
                                            </div>
                                        </div>
                                        <div class="d-flex" style="flex-direction: column;">
                                            <!-- Título -->
                                            <h6 class="text-mega fw-bold mb-0 text-truncate" style="text-wrap: auto;">
                                                ${ticket?.uid} - ${ticket?.title}
                                            </h6>

                                            <!-- Fecha -->
                                            <small class="text-muted d-block mb-2" style="font-size: 11px;">
                                                ${ticket?.user_first_name_create || ''} ${ticket?.user_last_name_create || ''}
                                            </small>
                                        </div>
                                    </div>

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
                                            <a href="/tickets/${ticket?.uid ?? ''}" 
                                            data-action="ticket-show" 
                                            data-id="${ticket?.id ?? 0}" 
                                            class="text-secondary" 
                                            data-bs-toggle="tooltip"
                                            title="Ver">
                                                <i class="ti ti-eye fs-18"></i>
                                            </a>
                                            <a 
                                                    href="javascript:void(0);" 
                                                    data-id="${ticket?.id ?? 0}" 
                                                    data-status-id="3"  
                                                    data-user-id="${ticket?.user_id ?? 0}"
                                                    data-uid="${ticket?.uid ?? ''}"
                                                    class="text-secondary ticket-status-waiting" 
                                                    data-bs-toggle="tooltip"
                                                    title="En espera">
                                                    <i class="ti ti-clock fs-18"></i>
                                            </a>
                                            <a 
                                                    href="javascript:void(0);" 
                                                    data-id="${ticket?.id ?? 0}" 
                                                    data-status-id="4"  
                                                    data-user-id="${ticket?.user_id ?? 0}"
                                                    data-uid="${ticket?.uid ?? ''}"
                                                    class="text-secondary ticket-status-completed" 
                                                    data-bs-toggle="tooltip"
                                                    title="Solucionado">
                                                    <i class="ti ti-circle-check fs-18"></i>
                                            </a>
                                            <a 
                                                    href="javascript:void(0);" 
                                                    data-id="${ticket?.id ?? 0}" 
                                                    data-status-id="6"  
                                                    data-user-id="${ticket?.user_id ?? 0}" 
                                                    data-uid="${ticket?.uid ?? ''}"
                                                    class="text-secondary ticket-status-cancel" 
                                                    data-bs-toggle="tooltip"
                                                    title="Cancelar">
                                                    <i class="ti ti-cancel fs-18"></i>
                                            </a>
                                            <a 
                                                    href="javascript:void(0);" 
                                                    data-id="${ticket?.id ?? 0}" 
                                                    data-status-id="${ticket?.status_id ?? 0}"  
                                                    data-priority-id="${ticket?.ticket_priority_id ?? 0}"
                                                    data-user-id="${ticket?.user_id ?? 0}" 
                                                    data-observation="${ticket?.observation ?? ''}"
                                                    class="text-secondary ticket-add-observation"
                                                    data-bs-toggle="tooltip" 
                                                    title="Agregar observación">
                                                <i class="ti ti-edit-circle fs-18"></i>
                                            </a>
                                        </div>
                                    </div>

                                    <div class="border-start ps-3 text-start">
                                        <small class="text-muted d-block fw-semibold mb-1" style="font-size: 10px;">Encargado</small>
                                        <span class="fw-medium text-dark" style="font-size: 11px;">
                                            ${assigned_name}
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    `;



                    $containerProgress.append(item);
                });
            }

            if (ticketsWaiting.length === 0) {
                $containerWaiting.html('<div class="col-12 text-center text-muted py-4">No se encontraron tickets</div>');

            } else {

                ticketsWaiting.forEach((ticket, index) => {

                    const currentColor = colorsDefault[index % colorsDefault.length];
                    let assigned_name = (ticket?.assigned_first_name ?? '')+ ' ' +(ticket?.assigned_last_name ?? '');
                    const randomColor = bgColors[ticket.id % bgColors.length];
                
                    let item = `
                    <div class="col-md-12 mb-3">
                        <div class="card border-0 shadow-sm h-100" style="border-radius: 12px; background-color: #fff;">
                            <div class="card-body p-3 d-flex flex-column justify-content-between">
                
                                <div>
                                    <!-- Encabezado: Servicio y Prioridad -->
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="badge text-dark fw-normal px-2 py-1" style="text-wrap: auto;border-radius: 6px; font-size: 11px; background-color: ${currentColor || ''};">
                                            ${ticket?.service_name}
                                        </span>
                                        <span class="badge fw-normal px-2 py-1 d-flex align-items-center gap-1" style="border-radius: 12px; font-size: 11px; color: ${ticket?.priority?.text || ''}  !important; background-color: ${ticket?.priority?.bg || ''} ;">
                                            <i class="ti ti-pin fs-12"></i> Prioridad ${ticket?.priority_name}
                                        </span>
                                    </div>

                                    <div class="d-flex gap-2">
                                        <div class="content-initials">
                                            <div class="rounded-circle ${randomColor} text-white d-flex align-items-center justify-content-center flex-shrink-0 fw-bold"
                                                 style="width: 32px; height: 32px; font-size: 0.8rem;">
                                                ${ticket?.initials_user_create ?? 'U'}
                                            </div>
                                        </div>
                                        <div class="d-flex" style="flex-direction: column;">
                                            <!-- Título -->
                                            <h6 class="text-mega fw-bold mb-0 text-truncate" style="text-wrap: auto;">
                                                ${ticket?.uid} - ${ticket?.title}
                                            </h6>

                                            <!-- Fecha -->
                                            <small class="text-muted d-block mb-2" style="font-size: 11px;">
                                                ${ticket?.user_first_name_create || ''} ${ticket?.user_last_name_create || ''}
                                            </small>
                                        </div>
                                    </div>

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
                                            <a href="/tickets/${ticket?.uid ?? ''}" 
                                            data-action="ticket-show" 
                                            data-id="${ticket?.id ?? 0}"
                                            class="text-secondary" 
                                            title="Ver" 
                                            data-bs-toggle="tooltip"
                                            >
                                                <i class="ti ti-eye fs-18"></i>
                                            </a>
                                            <a 
                                                    href="javascript:void(0);" 
                                                    data-id="${ticket?.id ?? 0}" 
                                                    data-status-id="${ticket?.status_id ?? 0}"  
                                                    data-priority-id="${ticket?.ticket_priority_id ?? 0}"
                                                    data-user-id="${ticket?.user_id ?? 0}" 
                                                    data-observation="${ticket?.observation ?? ''}"
                                                    class="text-secondary ticket-add-observation" 
                                                    data-bs-toggle="tooltip"
                                                    title="Agregar observación">
                                                <i class="ti ti-edit-circle fs-18"></i>
                                            </a>
                                            <a 
                                                    href="javascript:void(0);" 
                                                    data-id="${ticket?.id ?? 0}" 
                                                    data-status-id="6"  
                                                    data-user-id="${ticket?.user_id ?? 0}" 
                                                     data-uid="${ticket?.uid ?? ''}"
                                                    class="text-secondary ticket-status-cancel" 
                                                    data-bs-toggle="tooltip"
                                                    title="Cancelar">
                                                    <i class="ti ti-cancel fs-18"></i>
                                            </a>
                                            <a 
                                                href="javascript:void(0);"
                                                data-id="${ticket?.id ?? 0}"
                                                data-user-assing-id="${ticket?.assigned_id}"
                                                class="btn-assing-user"
                                                data-bs-toggle="tooltip"
                                                title="
                                                    ${ticket?.assigned_id 
                                                        ? 'Reasignar'
                                                        : 'Asignar'
                                                    }"
                                                >

                                                ${ticket?.assigned_id 
                                                    ? '<i class="ti ti-replace-user fs-18"></i>'
                                                    : ' <i class="ti ti-user-check fs-18"></i>'
                                                }
                                            </a>
                                        
                                        </div>
                                    </div>

                                    <div class="border-start ps-3 text-start">
                                        <small class="text-muted d-block fw-semibold mb-1" style="font-size: 10px;">Encargado</small>
                                        <span class="fw-medium text-dark" style="font-size: 11px;">
                                            ${assigned_name}
                                        </span>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    `;



                    $containerWaiting.append(item);
                });
            }
           
        })
        .catch(function (error) {
            ui.showToast('error', 'Ocurrió un error durante la recuperación de los tickets, prueba más tarde.');
            console.log(error)
        })
        .finally(function () {
          
            console.log(countTicketsToAssing)
            $('.count-to-assing').text(countTicketsToAssing);
            $('.count-progress').text(countticketsProgress);
            $('.count-waiting').text(countTicketsWaiting);

            $containerToAssing.removeClass('item-disabled');
            $containerProgress.removeClass('item-disabled');
            $containerWaiting.removeClass('item-disabled');

            loadingKanban(false);
        });
    }


    $(document).on('click', '.ticket-status-process, .ticket-status-cancel, .ticket-status-completed, .ticket-status-waiting', function (e) {
        e.preventDefault();

        const $btn = $(this);
        const ticketId = $btn.data('id');
        const statusId = parseInt($btn.data('statusId'));
        const ticketUid = $btn.data('uid');

        // Confirmación opcional antes de realizar la acción
        let actionText = '';

        console.log(statusId)

        switch (statusId) {
            case 1:
                actionText = "poner en por asignar";
                break;
            case 2:
                actionText = "poner en proceso";
                break;
            case 3:
                actionText = "poner en espera";
                break;
            case 4:
                actionText = "solucionar";
                break;
            case 5:
                actionText = "cerrar";
                break;
            case 6:
                actionText = "cancelar";
                
                break;
        
            default:
                break;
        }

        Swal.fire({
          title: `¿Estás seguro de que deseas ${actionText} este ticket?`,
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: "#0049fc",
          cancelButtonColor: "#d33",
          cancelButtonText: "Regresar",
          confirmButtonText: "Confirmar"
        }).then((result) => {
          if (result.isConfirmed) {
            $btn.addClass('disabled');

            axios.post('/updated_status', {
                ticket_id: ticketId,
                ticket_status: statusId,
                current_uid: ticketUid
            })
            .then(function (response) {
                getTicketsDataKanban(1);

                ui.showToast('success', 'Estatus actualizado correctamente.');
            })
            .catch(function (error) {
                console.error(error);
                ui.showToast('error', 'Ocurrió un error al actualizar el estatus del ticket.');
            })
            .finally(function () {
                $btn.removeClass('disabled');
            });

          }
        });
    });



    async function loadTeamsUsers(userAssing = null) {
        $selectUserAssing.prop('disabled', true);
        $selectUserAssing.empty();
        $selectUserAssing.html('<option>Cargando información...</option>');

        axios.get('/users/get_by_team', {
            params: { team_id: currentTeamId } 
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


            $selectUserAssing.empty();
            $selectUserAssing.prop('disabled', false);

            $selectUserAssing.select2({
                dropdownParent: modalAssingUser,
                placeholder: 'Buscar y seleccionar un usuario responsable...',
                allowClear: true,
                data: departmentUsers, 
                matcher: customUserMatcher,
                templateResult: formatUserOption,
                templateSelection: formatUserSelection
            });

            const selectedVal = (userAssing && userAssing != 0 && userAssing !== 'null') ? userAssing : null;

            $selectUserAssing.val(selectedVal).trigger('change');
        })
        .catch(error => {
            console.error('Error al cargar los usuarios del departamento:', error);
            ui.showToast('error', 'Error al cargar los usuarios del departamento:');
        });
    }


    $(document).on('click', '.btn-assing-user', function () {
       
        const ticketId = $(this).data('id');
        const statusId = $(this).data('statusId');
        const userAssing = $(this).data('userAssingId');

        $('.current-user-assing').val(userAssing);
        $('.ticket-id-modal-assign-user').val(ticketId);
        $('.status-id-modal-assing-user').val(statusId);

        loadTeamsUsers(userAssing);

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
            </div>
        `);
    }

    function formatUserSelection(user) {
        return user.text || user.placeholder;
    }

        
    $('#addAssignUserForm').on('submit', function (e) {
        e.preventDefault();

        const $btn = $('.save-modal-user-assign');
        const ticketId = $('.ticket-id-modal-assign-user').val();
        const userId = $('.select2-assignees').val();

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
                    
                    getTicketsDataKanban();
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


    getTicketsDataKanban();

});