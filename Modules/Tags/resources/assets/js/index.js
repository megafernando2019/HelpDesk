import axios from "axios";
import Swal from "sweetalert2";

$(document).ready(function () {

    const addTagModal = $('#addTagModal');
    const updateTagModal = $('#updateTagModal');
    const showCatModal = $('#showTagModal');
    const kabanPartial = $('#kanban-partial');
    const tablePartial = $('#table-partial');

    $(document).on('click', '.btn-show-tag', function () {
        showCatModal.modal('show');

        const categoryId   = $(this).data('id');
        const categoryName  = $(this).data('name');
        const description  = $(this).data('description');
        const listService = $(this).data('listService');
        const createdAt = $(this).data('createdAt');
        let html = '';

        $('.show-name').text('');
        $('.show-description').text('');
        $('.show-created').text('');

        $('.show-name').text(categoryName);
        $('.show-description').text(description);

        $('.show-created').text(createdAt);
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

    $('#modal-add-tag, #modal-add-tag-table-action').click(function () { 
         addTagModal.modal('show');
    });

    $('#addTagForm').on('submit', function (e) {
        e.preventDefault();

        const $form =$(this);

        const formData = {
            name: $('#tag_name').val(),
            description: $('#tag_description').val(),
            color: $('input[name="color"]:checked').val()
        };

        if (formData.name === '' || formData.name === null) {
            Swal.fire({
                icon: 'warning',
                title: 'Campo requerido',
                text: 'Por favor, ingresa el nombre de la etiqueta.',
                confirmButtonText: 'Aceptar'
            });
            return; 
        }

        if (formData.description === '' || formData.description === null) {
            Swal.fire({
                icon: 'warning',
                title: 'Campo requerido',
                text: 'Por favor, ingresa una descripción para la etiqueta.',
                confirmButtonText: 'Aceptar'
            });
            return; 
        }

        const $submitBtn =$form.find('button[type="submit"]');
        const originalBtnText = $submitBtn.html();


        $submitBtn.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
            Guardando...
        `);

        axios.post('/tags', formData, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
            .then(response => {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.data.message || 'Etiqueta guardada correctamente',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });
            })
            .catch(error => {
                console.error('Error al guardar:', error.response?.data || error);

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response?.data?.message || 'Ocurrió un error al guardar la etiqueta.',
                    confirmButtonText: 'Aceptar'
                });

                // Restaurar botón
                $submitBtn.prop('disabled', false).html(originalBtnText);
            });
    });

    $(document).on('click', '.edit-action-tag', function() {
        const categoryId   = $(this).data('id');
        const categoryName  = $(this).data('name');
        const description  = $(this).data('description');
        const colorValue   = $(this).data('color');
        let logs = $(this).data('logs') || [];

        // Limpiar estados de color anteriores en el modal de edición
        $('#updateTagModal .color-option').removeClass('select-color');
        $('#updateTagModal input[name="color"]').prop('checked', false);

        // Inyectar los valores en los campos correspondientes dentro del modal de actualización
        $('#updateTagModal').data('tag-id', categoryId);
        $('#updateTagModal #tag_name').val(categoryName);  
        $('#updateTagModal #tag_description').val(description);

        // Buscar el círculo de color que coincida con el valor de la base de datos e iluminarlo
        const targetColorInput = $('#updateTagModal input[name="color"][value="' + colorValue + '"]');

        if(targetColorInput.length) {
            targetColorInput.prop('checked', true);
            targetColorInput.closest('.color-option').addClass('select-color');
        } else {
            // Si el color no coincide con ninguno, marcamos el primero por defecto
            $('#updateTagModal input[name="color"]').first().prop('checked', true);
            $('#updateTagModal .color-option').first().addClass('select-color');
        }

        let status = $(this).data('status');

        // Asignar el estado al Checkbox/Switch
        let isChecked = status == 1 || status === true;
        $('#tagStatus').prop('checked', isChecked);
        $('#tagStatusLabel').text(isChecked ? 'Activado' : 'Desactivado');

        console.log(logs)
        if (logs.length > 0) {
            
            let logsHtml = logs.map(log => `
                <div class="mb-1 text-wrap">
                    <strong class="text-muted">${log.message}</strong>
                </div>
            `).join('');

            $('#tagDetailsText').html(logsHtml);
        } else {
            $('#tagDetailsText').html('<span class="text-muted">Sin historial de cambios</span>');
        }

        // Mostrar el modal
        updateTagModal.modal('show');
    });

    $(document).on('change', '#tagStatus', function () {
        if ($(this).is(':checked')) {
            $('#tagStatusLabel').text('Activado');
        } else {
            $('#tagStatusLabel').text('Desactivado');
        }
    });

    $('#updateTagForm').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const categoryId = $('#updateTagModal').data('tag-id'); 

        // Validamos y extraemos la información estructural de los campos
        const formData = {
            name: $('#updateTagModal #tag_name').val().trim(),
            description: $('#updateTagModal #tag_description').val().trim(),
            color: $('#updateTagModal input[name="color"]:checked').val(),
            status: $('#updateTagModal #tagStatus').is(':checked') ? 1 : 0 
        };

        // Validaciones en Frontend
        if (!formData.name || formData.name === '') {
            Swal.fire({ icon: 'warning', title: 'Campo requerido', text: 'Por favor, ingresa el nombre de la etiqueta.', confirmButtonText: 'Aceptar' });
            return; 
        }

        if (!formData.description || formData.description === '') {
            Swal.fire({ icon: 'warning', title: 'Campo requerido', text: 'Por favor, ingresa una descripción para la etiqueta.', confirmButtonText: 'Aceptar' });
            return; 
        }

        const submitBtn = form.find('button[type="submit"]');
        const originalBtnText = submitBtn.html();

        // Deshabilitar botón de guardado e inyectar el Spinner
        submitBtn.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
            Actualizando...
        `);

        // Petición HTTP mediante Axios utilizando el método PUT
        axios.put(`/tags/${categoryId}`, formData, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            Swal.fire({
                icon: 'success',
                title: '¡Actualizado!',
                text: response.data.message || 'Etiqueta actualizada correctamente',
                timer: 1500,
                showConfirmButton: false
            }).then(() => {
                window.location.reload();
            });
        })
        .catch(error => {
            console.error('Error al actualizar:', error.response?.data || error);

            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.response?.data?.message || 'Ocurrió un error al actualizar la etiqueta.',
                confirmButtonText: 'Aceptar'
            });

            // Si falla el flujo, reactivamos el botón
            submitBtn.prop('disabled', false).html(originalBtnText);
        });
    });

});