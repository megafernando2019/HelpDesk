import axios from 'axios';
import { ui } from '@/helpers/helper.js';

$(document).ready(function () {

    let tagsInMemory = [];
    const bgColors = ['#f59e0b', '#3b82f6', '#10b981', '#ef4444', '#8b5cf6', '#ec4899', '#06b6d4'];
    const inputObservation = $('.observation_d');
    
    function initTagsSelect2(dataArray) {
        const $select = $('#tags-select');

        if ($select.hasClass('select2-hidden-accessible')) {
            $select.select2('destroy').empty();
        }

        $select.select2({
            data: dataArray,
            placeholder: $select.data('placeholder') || 'Selecciona etiquetas',
            allowClear: true,
            tags: true, 
            tokenSeparators: [',', ' '],
            width: '100%'
        });

        // Evento para limpiar estilo de error
        $select.on('change', function() {
            $(this).next('.select2-container').removeClass('is-invalid');
        });
    }

    function getLogsByTicket(cache = false) {

        const ticketId = $('.content-show').data('ticket-id');
        const $container = $('.ticket-log-chanel-endpoint');
        const logs = null;

        if (cache) {
            const logs = $container.data('logs');
        }

        $container.empty();

        $container.html('<p class="text-muted mb-0">Cargando información...</p>');

        axios.post('/get_ticket_logs_by_id', {
                param_ticket_id: ticketId,
                logs: logs
        }, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(response => {

            const logs = response?.data; 

            $container.empty();

            if (!logs || logs.length === 0) {
                $container.html('<p class="text-muted mb-0">Aún no hay información por mostrar</p>');
                return;
            }

            let html = '';
            
            Object.entries(logs).forEach(([key, arr]) => {
                if (arr.length > 0) {
                    arr.forEach(item => {
                        html += `
                            <div class="d-flex align-items-start timeline-item mb-1">
                                <div class="rounded-circle d-flex align-items-center justify-content-center p-2 me-3 ${item.bgColor}" style="width: 38px; height: 38px; flex-shrink: 0;">
                                    <i class="${item.icon}"></i>
                                </div>
                                <div>
                                    <p class="mb-0 text-dark fw-semibold">${item.message}</p>
                                    <small class="text-muted">el ${item.formatDate}</small>
                                </div>
                            </div>
                        `;
                    })
                }
                
            });

            $container.html(html);
        })
        .catch(error => {
            $container.empty();
            console.error('Error al obtener los logs de este tciket:', error);
            $container.html('<p class="text-danger mb-0">Error al cargar el historial</p>');
        })
        .finally(() => {
            
        });
    }

    getLogsByTicket(true);

    initTagsSelect2();

    /**
     * Events
     */
    $('.btn-status-observation').on('click', function () {
        
        $('.error-invalid-observation').text('');
        inputObservation.removeClass('is-invalid');

        $('.observation_d').addClass('focus-input');

        $('html, body').animate({
            scrollTop: $('.observation_d').offset().top - 100
        }, 500); 
    });


     $('.observation_d').on('input', function () {

        const value = $(this).val();

        $(this).removeClass('focus-input');
        $('.error-invalid-observation').text('');
        inputObservation.removeClass('is-invalid');

        if(!value)
        {
            inputObservation.addClass('is-invalid');
            $('.error-invalid-observation').text('Debes agregar una observación');
        }
        
    });


    $('.btn-status-action').on('click', function () {
        const $btn = $(this);
        const ticketId = $('.content-show').data('ticket-id');
        const nameStatus = $btn.data('name');
        const value = $btn.data('status');
       
        $btn.prop('disabled', true);

        axios.post('/updated_status', {
            ticket_id: ticketId,
            ticket_status: value
        }, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(response => {
            ui.showToast('success', `Se ha actualizado a estatus (${nameStatus}).`);
            window.location.href = '/tickets/'+ticketId
        })
        .catch(error => {
            console.error(error);
            ui.showToast('error', error.response?.data?.message || 'Ocurrió un error al actualizar el estatus.');
        })
        .finally(() => {
            $btn.prop('disabled', false);
        });
    });


    $('.action-save-observation').on('submit', function (e) {
        e.preventDefault(); 

        

        const formData = new FormData(this);

        const $btn = $('.action-save-observation button[type="submit"]').prop('disabled', true);

       const value =inputObservation.val();

       inputObservation.removeClass('is-invalid');
       $('.error-invalid-observation').text('');

        if (!value || value === '') {

           inputObservation.addClass('is-invalid');
           $('.error-invalid-observation').text('Debes agregar una observación para continuar');
           return;
        }

        axios.post('/save_observation', formData, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(response => {
            ui.showToast('success','Observación guardada correctamente');

           inputObservation.val('');
            $('.message-obeservaton').text(response?.data?.description_observation_record ?? '');
            $('.date-format-response').text(response?.data?.date ?? '');
            $('.user-observation-response').text(response?.data?.user ?? '');

            //Actualizar logs
            getLogsByTicket();
        })
        .catch(error => {
            console.error('Error al guardar:', error.response ? error.response.data : error);
            ui.showToast('error','Ocurrió un error al procesar la solicitud.');
        })
        .finally(() => {
            
            $btn.prop('disabled', false);
        });
        
    });
    
    $('.btn-assign-users').on('click', function (e) {
        e.preventDefault();

        const $btn = $(this);
        const ticketId = $('.content-show').data('ticket-id');
        const selected = $('.select2-assignees').val() || 0;
        const selectedData = $('.select2-assignees').select2('data');
        const selectedName = selectedData.length ? selectedData[0].text : '';
        let rawData = $btn.data('existUserAssing');
        let flagExistAssigned = (typeof rawData === 'string') ? JSON.parse(rawData) : rawData;

        $btn.prop('disabled', true);

        axios.post('/assing_ticket_user', {
            ticket_id: ticketId,
            assignees: [selected],
            selectedName: selectedName,
            flag_exist_assigned: flagExistAssigned
        }, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(response => {
            ui.showToast('success', response?.data?.message || 'Asignación actualizada correctamente');
            window.location.href = '/tickets/'+ticketId
        })
        .catch(error => {
            console.error('Error al asignar usuarios:', error);
            ui.showToast('error', error.response?.data?.message || 'Ocurrió un error al asignar.');
        })
        .finally(() => {
            $btn.prop('disabled', false);
        });
    });


    $('.select2-assignees').on('change', function () {
        const value = parseInt($(this).val()) || 0;
        const $btn = $('.btn-assign-users');

        if (value !== 0) {
            $btn.prop('disabled', false).removeClass('btn-grey').addClass('btn-mega');
        } else {
            $btn.prop('disabled', true).removeClass('btn-mega').addClass('btn-grey');
        }
    });


    function getColorFromString(str) {
        let hash = 0;
        for (let i = 0; i < str.length; i++) {
            hash = str.charCodeAt(i) + ((hash << 5) - hash);
        }
        const index = Math.abs(hash) % bgColors.length;
        return bgColors[index];
    }

    function formatUserOption(state) {
        if (!state.id) return state.text;

        const email = $(state.element).data('email') || '';
        const initials = $(state.element).data('initials') || 'NA';
        const bgColor = getColorFromString(state.id + state.text);

        const $card = $(`
            <div class="select2-user-card">
                <div class="avatar-circle" style="background-color: ${bgColor};">
                    ${initials}
                </div>
                <div class="user-info">
                    <p class="user-name">${state.text}</p>
                    <p class="user-email">${email}</p>
                </div>
            </div>
        `);

        return $card;
    }

    function formatUserSelection(state) {
        if (!state.id || state.id === 'Seleccionar encargados de soporte...') return state.text;

        // Obtener el elemento DOM de forma segura (soporta carga inicial y selección activa)
        const $option = state.element 
            ? $(state.element) 
            : $('.select2-assignees').find(`option[value="${state.id}"]`);

        const email = $option.data('email') || '';
        const initials = $option.data('initials') || 'NA';
        const name = $option.data('name') || state.text;
        const bgColor = getColorFromString(state.id + state.text);

        return $(`
            <div class="d-flex align-items-center gap-2" style="height: 100%;">
                <div class="avatar-circle" style="
                    background-color: ${bgColor};
                    width: 28px;
                    height: 28px;
                    border-radius: 50%;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    color: #ffffff;
                    font-weight: 700;
                    font-size: 11px;
                    flex-shrink: 0;
                ">
                    ${initials}
                </div>
                <div style="line-height: 1.1;">
                    <span class="d-block font-weight-bold" style="font-size: 13px; color: #333;">${name}</span>
                    <small class="text-muted" style="font-size: 10px; display: block;">${email}</small>
                </div>
            </div>
        `);
    }


    $('.select2-assignees').select2({
        placeholder: "Seleccionar encargados de soporte...",
        templateResult: formatUserOption,
        templateSelection: formatUserSelection
    });

});

