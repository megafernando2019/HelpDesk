import axios from 'axios';
import { ui } from '@/helpers/helper.js';

$(document).ready(function () {

    let tagsInMemory = [];
    const bgColors = ['#f59e0b', '#3b82f6', '#10b981', '#ef4444', '#8b5cf6', '#ec4899', '#06b6d4'];
    
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

    initTagsSelect2();

    /**
     * Events
     */
    $('.action-save-observation').on('submit', function (e) {
        e.preventDefault(); 

        const formData = new FormData(this);

        const $btn = $('.action-save-observation button[type="submit"]').prop('disabled', true);

        axios.post('/save_observation', formData, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(response => {
            ui.showToast('success','Observación y etiquetas guardadas correctamente');

            console.log(response?.data?.description_observation_record)
            $('.observation_d').text(response?.data?.description_observation_record ?? '');
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
        const selectedUsers = $('.select2-assignees').val() || [];

        $btn.prop('disabled', true);

        axios.post('/assing_ticket_user', {
            ticket_id: ticketId,
            assignees: selectedUsers
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
        const selectedValues = $(this).val() || [];
        const $btn = $('.btn-assign-users');

        if (selectedValues.length > 0) {
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
        if (!state.id) return state.text;

        const email = $(state.element).data('email') || '';
        const initials = $(state.element).data('initials') || 'NA';
        const name = $(state.element).data('name') || '';
        const bgColor = getColorFromString(state.id + state.text);

        return $(`
            <div class="d-flex align-items-center gap-2">
                <div class="avatar-circle" style="background-color: ${bgColor}; width: 28px; height: 28px; font-size: 11px;">
                    ${initials}
                </div>
                <div>
                    <span style="font-weight: 600; font-size: 13px; color: #333;">${state.text}</span>
                    <b class="d-block text-muted" style="font-size: 10px;">${name}</b>
                    <small class="d-block text-muted" style="font-size: 10px;">${email}</small>
                </div>
            </div>
        `);
    }

    $('.select2-assignees').select2({
        placeholder: "Seleccionar encargados de soporte...",
        allowClear: true,
        templateResult: formatUserOption,
        templateSelection: formatUserSelection
    });

});

