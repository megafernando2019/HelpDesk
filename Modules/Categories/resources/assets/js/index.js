import axios from "axios";
import Swal from "sweetalert2";

$(document).ready(function () {

    const addCategoriaModal = $('#addCategoriaModal');


    $('#modal-add-category').click(function () { 
         console.log('hola')
         addCategoriaModal.modal('show');
    });

    $('#addCategoriaForm').on('submit', function (e) {
        e.preventDefault();

        const $form =$(this);
        const $submitBtn =$form.find('button[type="submit"]');
        const originalBtnText = $submitBtn.html();


        $submitBtn.prop('disabled', true).html(`
            <span class="spinner-border spinner-border-sm me-1" role="status" aria-hidden="true"></span>
            Guardando...
        `);

        
        const formData = {
            name: $('#category_name').val(),
            description: $('#category_description').val(),
            color: $('input[name="color"]:checked').val()
        };

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

});