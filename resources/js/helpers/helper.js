import Swal from 'sweetalert2'; 

'use strict';

export const ui = {
    /**
     * Muestra un mensaje tipo Toast con SweetAlert2
     */
    showToast: (icon, title, timer = 2000) => {
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: timer,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        });

        Toast.fire({
            icon: icon,
            title: title
        });
    }
};

window.ui = ui;
