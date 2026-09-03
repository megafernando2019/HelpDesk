import axios from 'axios';
import { ui } from '@/helpers/helper.js';

'use strict';

$(document).ready(function () {

    let dateRangePicker = null;

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

    $('body').on('change', '[data-action=filter-by-priority]', function (e) {
        const $item = $(e.currentTarget);
        const priority = $item.val();
        const $container = $('#tickets-container');
        const currentStatus = $container.attr('data-current-status');

        getTicketsDataKanban(currentStatus, null, priority);
    });
    
    // Inicializar el filtro Kanban con Flatpickr en modo Rango
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
            // params: {
            //     start_date: fechaInicio,
            // }
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
                    .replace(/{description}/g, ticket?.description || 'Sin descripción')
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