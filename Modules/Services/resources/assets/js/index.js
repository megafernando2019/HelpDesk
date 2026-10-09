import axios from "axios";
import Swal from "sweetalert2";

$(document).ready(function () {

    const addServiceModal = $('#addServiceModal');
    const updateServiceModal = $('#editServiceModal');
    const kabanPartial = $('#kanban-partial');
    const tablePartial = $('#table-partial');

    $('.category_id').select2({
        placeholder: 'Seleccionar categoría...',
        dropdownParent: addServiceModal,
        allowClear: true,
    });

    $('.edit_category_id').select2({
        placeholder: 'Seleccionar categoría...',
        dropdownParent: updateServiceModal,
        allowClear: true,
    })

    $('#addServiceForm').on('submit', function (e) {
        e.preventDefault();

        const $submitBtn = $(this).find('button[type="submit"]');
        $submitBtn.prop('disabled', true);

        const hasTemplate = $('#applyTemplateCheck').is(':checked');
        
        const payload = {
            name: $('#service_name').val().trim(),
            description: $('#service_description').val().trim(),
            category_id: $('select[name="categoria_id"]').val(),
            template: hasTemplate ? $('#template').val().trim() : null,
            color: $('input[name="color"]:checked').val()
        };

        axios.post("/services", payload, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(function (response) {
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'Se ha creado el servicio correctamente.',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                window.location.reload();
            });
        })
        .catch(function (error) {
            console.error('Error al guardar el servicio:', error);
            
            if (error.response && error.response.status === 422) {
                // Manejo de errores de validación de Laravel
                const errors = error.response.data.errors;
                let errorMessage = Object.values(errors).flat().join('<br>');

                Swal.fire({
                    icon: 'error',
                    title: 'Error de validación',
                    html: errorMessage
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Ocurrió un error',
                    text: error.response?.data?.message || 'No se pudo guardar el servicio.'
                });
            }
        })
        .then(function () {
            // Rehabilitar el botón al finalizar
            $submitBtn.prop('disabled', false);
        });
    });

    $('#applyTemplateCheck').on('change', function () {
        if ($(this).is(':checked')) {
            $('#templateContainer').removeClass('d-none');
        } else {
            $('#templateContainer').addClass('d-none');
            $('#template').val('');
        }
    });

    $(document).on('click', '.display-kaban', function () {
        const btn = $(this);

        $('.display-table').removeClass('active');
        $('.display-kaban').addClass('active');
        $('.display-table').removeClass('btn-info');
        $('.display-table').addClass('btn-outline-info');

        tablePartial.addClass('d-none');
        kabanPartial.removeClass('d-none');
        btn.addClass('btn-info');
    });
 
    $(document).on('click', '.display-table', function () {
        const btn = $(this);

        $('.display-kaban').removeClass('active');
        $('.display-table').addClass('active');
        $('.display-kaban').removeClass('btn-info'); 
        $('.display-kaban').addClass('btn-outline-info');

        kabanPartial.addClass('d-none');
        tablePartial.removeClass('d-none');
        btn.addClass('btn-info');
    });

    $(document).on('click', '.color-option', function () {

        $('.color-option').removeClass('select-color');

        $(this).addClass('select-color');
    });

    $('#modal-add-service, #modal-add-service-table-action').click(function () { 
         addServiceModal.modal('show');
    });


    // Si venimos de guardar un cambio, abrimos el modal automáticamente tras recargar
    if (sessionStorage.getItem('openEditModalId')) {
        const targetId = sessionStorage.getItem('openEditModalId');
        sessionStorage.removeItem('openEditModalId'); // Limpiar storage
        
        // Buscar el botón correspondiente y simular click para abrir y poblar
        const $btn =$(`.edit-action-service[data-id="${targetId}"]`);
        if ($btn.length) {$btn.trigger('click');
        }
    }

    // Escuchar Click para Abrir Modal y Pintar Datos
    $(document).on('click', '.edit-action-service', function () {
        const id = $(this).data('id');
        const name = $(this).data('name');
        const description = $(this).data('description');
        const categoryId = $(this).data('category-id');
        const template = $(this).data('template');
        const color = $(this).data('color');
        const status = $(this).data('status');
        const details = $(this).data('details');

        // Setear campos
        $('#edit_service_id').val(id);
        $('#edit_service_name').val(name);
        $('#edit_service_description').val(description);
        $('#edit_category_id').val(categoryId).trigger('change');
        $('#edit_serviceDetailsText').text(details);
        $('#editServiceModal .color-option').removeClass('select-color');
        $('#editServiceModal input[name="edit_color"]').prop('checked', false);

        // Control de plantilla
        if (template && template.trim() !== '') {
            $('#edit_applyTemplateCheck').prop('checked', true);
            $('#edit_templateContainer').removeClass('d-none');
            $('#edit_template').val(template);
        } else {
            $('#edit_applyTemplateCheck').prop('checked', false);
            $('#edit_templateContainer').addClass('d-none');
            $('#edit_template').val('');
        }

        // Color Radio Select
         const targetColorInput = $('#editServiceModal input[name="edit_color"][value="' + color + '"]');

         //Si encontro el un input con ese color
        if(targetColorInput.length > 0) {
            targetColorInput.prop('checked', true);
            targetColorInput.closest('.color-option').addClass('select-color');
           
        } else {
            // Si el color no coincide con ninguno, marcamos el primero por defecto
            $('#editServiceModal input[name="edit_color"]').first().prop('checked', true);
            $('#editServiceModal .color-option').first().addClass('select-color');
           
        }

        // Switch Estado
        const isChecked = status === 1;
        const isNotChecked = status === 2;

        if (isChecked) {
             $('#edit_serviceStatus').prop('checked', isChecked);
             $('#edit_serviceStatusLabel').text('Activado');
        } else if (isNotChecked) {
             $('#edit_serviceStatus').prop('checked', false);
             $('#edit_serviceStatusLabel').text('Desactivado');
        }

        // Abrir Modal
        $('#editServiceModal').modal('show');
    });

    // Evento change en el switch de estado
    $('#edit_serviceStatus').on('change', function () {
        $('#edit_serviceStatusLabel').text($(this).is(':checked') ? 'Activado' : 'Desactivado');
    });

    // Evento change en el checkbox de plantilla
    $('#edit_applyTemplateCheck').on('change', function () {
        if ($(this).is(':checked')) {$('#edit_templateContainer').removeClass('d-none');
        } else {
            $('#edit_templateContainer').addClass('d-none');
            $('#edit_template').val('');
        }
    });

    // Envío por Axios
    $('#editServiceForm').on('submit', function (e) {
        e.preventDefault();

        const $submitBtn = $(this).find('button[type="submit"]');
        $submitBtn.prop('disabled', true);

        const serviceId = $('#edit_service_id').val();
        const hasTemplate = $('#edit_applyTemplateCheck').is(':checked');

        const payload = {
            id: serviceId,
            name: $('#edit_service_name').val().trim(),
            description: $('#edit_service_description').val().trim(),
            category_id: $('#edit_category_id').val(),
            template: hasTemplate ? $('#edit_template').val().trim() : null,
            color: $('input[name="edit_color"]:checked').val(),
            status_id: $('#edit_serviceStatus').is(':checked') ? 1 : 0
        };

        axios.put(`/services/${serviceId}`, payload, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json',
                'Accept': 'application/json'
            }
        })
        .then(function (response) {
            // Guardamos el ID en sessionStorage para reabrir el modal tras reload
            sessionStorage.setItem('openEditModalId', serviceId);
           
             Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: 'Se ha actualizado el servicio correctamente.',
                confirmButtonText: 'Aceptar'
            }).then((result) => {
                window.location.reload();
            });
        })
        .catch(function (error) {
            $submitBtn.prop('disabled', false);
            console.error('Error al actualizar servicio:', error);
            
            if (error.response && error.response.status === 422) {
                let errorMessage = Object.values(error.response.data.errors).flat().join('<br>');
                Swal.fire({ icon: 'error', title: 'Error de validación', html: errorMessage });
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: 'No se pudo actualizar el servicio.' });
            }

        }).then(function() {
             
        });
    });





    $(document).on('change', '#categoryStatus', function () {
        if ($(this).is(':checked')) {
            $('#categoryStatusLabel').text('Activado');
        } else {
            $('#categoryStatusLabel').text('Desactivado');
        }
    });

});