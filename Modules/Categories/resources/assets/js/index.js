import axios from "axios";
import Swal from "sweetalert2";

$(document).ready(function () {

    const addCategoriaModal = $('#addCategoriaModal');
    const updateCategoriaModal = $('#updateCategoriaModal');
    const showCatModal = $('#showCatModal');
    const kabanPartial = $('#kanban-partial');
    const tablePartial = $('#table-partial');

    $(document).on('click', '.btn-show-cat', function () {
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
        $('.wrap-container').empty();

        $('.show-name').text(categoryName);
        $('.show-description').text(description);


        if (listService.length > 0) {
            listService.forEach(element => {
                 html += `<span class="badge bg-ocean rounded">${element?.name ?? 'Dato no disponible'}</span>`;
                 
            });

             $('.wrap-container').append(`${html}`);
        } else {
             $('.wrap-container').html(`<span class="badge bg-ocean rounded">Esta categoría aun no cuenta con servicios asociados.</span>`);
        }
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

    $('#modal-add-category, #modal-add-category-table-action').click(function () { 
         addCategoriaModal.modal('show');
    });

    $('#addCategoriaForm').on('submit', function (e) {
        e.preventDefault();

        const $form =$(this);

        const formData = {
            name: $('#category_name').val(),
            description: $('#category_description').val(),
            color: $('input[name="color"]:checked').val()
        };

        if (formData.name === '' || formData.name === null) {
            Swal.fire({
                icon: 'warning',
                title: 'Campo requerido',
                text: 'Por favor, ingresa el nombre de la categoría.',
                confirmButtonText: 'Aceptar'
            });
            return; 
        }

        if (formData.description === '' || formData.description === null) {
            Swal.fire({
                icon: 'warning',
                title: 'Campo requerido',
                text: 'Por favor, ingresa una descripción para la categoría.',
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

        axios.post('/categories', formData, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
            .then(response => {
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.data.message || 'Categoría guardada correctamente',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => {
                    window.location.reload();
                });
            })
            .catch(error => {
                console.error('Error al guardar:', error.response?.data || error);

                // Alerta SweetAlert de error
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.response?.data?.message || 'Ocurrió un error al guardar la categoría.',
                    confirmButtonText: 'Aceptar'
                });

                // Restaurar botón
                $submitBtn.prop('disabled', false).html(originalBtnText);
            });
    });

    $(document).on('click', '.edit-action-category', function() {
        const categoryId   = $(this).data('id');
        const categoryName  = $(this).data('name');
        const description  = $(this).data('description');
        const colorValue   = $(this).data('color');

        // Limpiar estados de color anteriores en el modal de edición
        $('#updateCategoriaModal .color-option').removeClass('select-color');
        $('#updateCategoriaModal input[name="color"]').prop('checked', false);

        // Inyectar los valores en los campos correspondientes dentro del modal de actualización
        $('#updateCategoriaModal').data('category-id', categoryId);
        $('#updateCategoriaModal #category_name').val(categoryName);  
        $('#updateCategoriaModal #category_description').val(description);

        // Buscar el círculo de color que coincida con el valor de la base de datos e iluminarlo
        const targetColorInput = $('#updateCategoriaModal input[name="color"][value="' + colorValue + '"]');

        if(targetColorInput.length) {
            targetColorInput.prop('checked', true);
            targetColorInput.closest('.color-option').addClass('select-color');
        } else {
            // Si el color no coincide con ninguno, marcamos el primero por defecto
            $('#updateCategoriaModal input[name="color"]').first().prop('checked', true);
            $('#updateCategoriaModal .color-option').first().addClass('select-color');
        }

        let status = $(this).data('status');
        let details = $(this).data('details');

        // Asignar el estado al Checkbox/Switch
        let isChecked = status == 1 || status === true;
        $('#categoryStatus').prop('checked', isChecked);
        $('#categoryStatusLabel').text(isChecked ? 'Activado' : 'Desactivado');

        // Asignar la información de detalles
        $('#categoryDetailsText').text(details);

        // Mostrar el modal
        updateCategoriaModal.modal('show');
    });

    $(document).on('change', '#categoryStatus', function () {
        if ($(this).is(':checked')) {
            $('#categoryStatusLabel').text('Activado');
        } else {
            $('#categoryStatusLabel').text('Desactivado');
        }
    });

    $('#updateCategoriaForm').on('submit', function (e) {
        e.preventDefault();

        const form = $(this);
        const categoryId = $('#updateCategoriaModal').data('category-id'); 

        // Validamos y extraemos la información estructural de los campos
        const formData = {
            name: $('#updateCategoriaModal #category_name').val().trim(),
            description: $('#updateCategoriaModal #category_description').val().trim(),
            color: $('#updateCategoriaModal input[name="color"]:checked').val(),
            status: $('#updateCategoriaModal #categoryStatus').is(':checked') ? 1 : 0 
        };

        // Validaciones en Frontend
        if (!formData.name || formData.name === '') {
            Swal.fire({ icon: 'warning', title: 'Campo requerido', text: 'Por favor, ingresa el nombre de la categoría.', confirmButtonText: 'Aceptar' });
            return; 
        }

        if (!formData.description || formData.description === '') {
            Swal.fire({ icon: 'warning', title: 'Campo requerido', text: 'Por favor, ingresa una descripción para la categoría.', confirmButtonText: 'Aceptar' });
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
        axios.put(`/categories/${categoryId}`, formData, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Content-Type': 'application/json'
            }
        })
        .then(response => {
            Swal.fire({
                icon: 'success',
                title: '¡Actualizado!',
                text: response.data.message || 'Categoría actualizada correctamente',
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
                text: error.response?.data?.message || 'Ocurrió un error al actualizar la categoría.',
                confirmButtonText: 'Aceptar'
            });

            // Si falla el flujo, reactivamos el botón
            submitBtn.prop('disabled', false).html(originalBtnText);
        });
    });

});