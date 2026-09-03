import axios from 'axios';
import { ui } from '@/helpers/helper.js';
import Swal from 'sweetalert2';

'use strict';

$(document).ready(function () {

    let dateRangePicker = null;
    const modalObservation = $('#addObservationModal');
    const observationDescription = $('#observationDescription');

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

            // Iterar y mapear los tickets a HTML
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