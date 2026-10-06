import axios from 'https://cdn.jsdelivr.net/npm/axios@1.3.5/+esm';
import Swal from 'https://cdn.jsdelivr.net/npm/sweetalert2@11/+esm';

$(document).ready(function () {
    const element = $('.change-rol-action');
    const modalRol = $('#modalChangeRolId');
    const rolSelectNew = $('.roles-nuevos');
    const rolSelectOld = $('.roles-actual');

    /**
     * Events
     */
    element.click(function () { 
         getRoles();
        modalRol.modal('show');
    });

    // Petición Axios al dar clic en Guardar
    $('#btnGuardarRol').click(function () {
        const nuevoRol = rolSelectNew.val();

        if (!nuevoRol) {
            Swal.fire({
                icon: 'warning',
                title: 'Atención',
                text: 'Por favor selecciona un nuevo rol antes de continuar.'
            });
            return;
        }

        // Deshabilitar botón durante la petición
        const $btn = $(this);
        $btn.prop('disabled', true);

        axios.post("/users/update_session_rol", {
            role: nuevoRol
        }, {
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })
        .then(function (response) {
           
                Swal.fire({
                    icon: 'success',
                    title: '¡Éxito!',
                    text: response.data.message || 'Rol actualizado correctamente.',
                    confirmButtonText: 'Aceptar'
                }).then((result) => {
                    if (result.isConfirmed || result.dismiss) {
                         modalRol.modal('hide');
                         rolSelectNew.empty();
                         rolSelectOld.empty();
                         window.location.reload();
                    }
                });
            
        })
        .catch(function (error) {
            console.error(error);
            const msg = error.response?.data?.message || 'Ocurrió un error al intentar cambiar el rol.';
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: msg
            });
        })
        .then(function () {
            // Habilitar botón nuevamente al finalizar
            $btn.prop('disabled', false);
        });
    });

    async function getRoles() {
        const endpoint = '/users/get_current_roles';

        $('.default-picture-tugui-roles').addClass('d-none ');

        $('.loading-roles-panel').removeClass('d-none ');
        rolSelectNew.empty().prop('disabled', true);

        try {
            const res = await axios.get(endpoint);
            const roles = res?.data?.roles ?? [];
            const currentRolId = res?.data?.current_rol?.id ?? 0;
            let htmlNewOptions = '';
            let htmlActualOptions = '';

            if (roles.length > 0) {
                
                roles.forEach(rol => {
                     
                     htmlNewOptions += `<option value="${rol?.id ?? 0}">${rol?.name ?? 'Dato no disponible'}</option>`;
                     htmlActualOptions += `<option value="${rol?.id ?? 0}" ${(currentRolId === rol?.id ?? 0) ? 'selected' : ''}>${rol?.name ?? 'Dato no disponible'}</option>`;

                     rolSelectNew.html(htmlNewOptions);
                     rolSelectOld.html(htmlActualOptions);
                });
            }

        } catch (error) {
            console.error('Hubo un error al obtener los roles:', error);
        } finally {
             $('.default-picture-tugui-roles').removeClass('d-none ');

             $('.loading-roles-panel').addClass('d-none ');
             rolSelectNew.prop('disabled', false);
        }
    }
});