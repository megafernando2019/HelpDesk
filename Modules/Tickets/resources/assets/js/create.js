import axios from 'axios';
import { ui } from '@/helpers/helper.js';

'use strict';

$(document).ready(function () {

    let prioritiesData = [];
    let teamsData = [];
    const $prioritiesSelect = $('.ticket-priorities-s');
    const $categorySelect = $('.category-select');
    const $serviceSelect = $('.service-select');
    const $typesSelect = $('.ticket-types-s');
    const $inputDrop = $('.drop-zone__input');
    const $dropZone = $('.drop-zone');
    const container = new DataTransfer();
    const $fileList = $('#file-list');

    async function getCurrentDetails() {
        const endpoint = '/tickets/get_current_details_create';

        try {
            const response = await axios.get(endpoint);

             prioritiesData = response?.data?.ticket_priorities;

             teamsData = response?.data?.teams;

            initSelects(prioritiesData, teamsData);
           
        } catch (error) {
            console.error('Error al obtener detalles:', error.response?.data || error.message);
        }
    }

    async function getCategoriesByTeam(teamId) {
        
        try {
            const response = await axios.get('/categories/by_department', {
                params: { team_id: teamId }
            });

            initCategoriesSelect(response?.data?.data ?? []);

        } catch (error) {
            ui.showToast('error','No se pudieron cargar las categorías');
            console.error('Error al obtener categorías:', error.response?.data || error.message);
            throw error;
        }
    }

    async function getServicesByCategory(categoryId) {
        try {
            const response = await axios.get('/services/by_category', {
                params: { category_id: categoryId }
            });
            
            return response?.data?.data ?? [];

        } catch (error) {
            console.error('Error al obtener servicios:', error.response?.data || error.message);
            throw error;
        }
    }

    function initSelects(priorities, teams)
    {
        if (priorities && priorities.length > 0) {
        
            priorities.forEach(element => {
                $prioritiesSelect.append(
                    `<option value="${element.id}">${element.name}</option>`
                );
            });
        }

        if (teams && teams.length > 0) {
           
            initTypeTeamSelect(teams);
        }
    }

    function initCategoriesSelect(categories) {

        $categorySelect.empty().append('<option value="">Selecciona una categoria</option>');

        if (categories && categories.length > 0) {
            categories.forEach(item => {
                $categorySelect.append(
                    `<option value="${item.id}">${item.name}</option>`
                );
            });
        } else {
            ui.showToast('info', 'No hay categorías disponibles para este equipo.')
        }

       
        if ($.fn.select2) {
           
            if ($categorySelect.hasClass('select2-hidden-accessible')) {
                $categorySelect.select2('destroy');
            }

            $categorySelect.select2({
                placeholder: 'Selecciona una categoria',
                width: '100%'
            });
        }
    }

    function initServicesSelect(services) {

        if ($.fn.select2 && $serviceSelect.hasClass('select2-hidden-accessible')) {
            $serviceSelect.select2('destroy');
        }

        $serviceSelect.empty().append('<option value="">Selecciona una servicio</option>');

        if (services && services.length > 0) {
            services.forEach(item => {
                console.log(item)
                $serviceSelect.append(
                    `<option value="${item?.id}">${item?.name}</option>`
                );
            });
        }
       
        if ($.fn.select2) {

            $serviceSelect.select2({
                placeholder: 'Selecciona un servicio',
                width: '100%'
            });
        }

    }


     function initTypeTeamSelect(teams) {

        if ($.fn.select2 && $typesSelect.hasClass('select2-hidden-accessible')) {
            $typesSelect.select2('destroy');
        }

        $typesSelect.empty().append('<option value="">Selecciona una servicio</option>');

        if (teams && teams.length > 0) {
            teams.forEach(item => {
               
                $typesSelect.append(
                    `<option value="${item?.id}">${item?.name}</option>`
                );
            });
        }
       
        if ($.fn.select2) {

            $typesSelect.select2({
                placeholder: 'Selecciona un servicio',
                width: '100%'
            });
        }

    }

    //Mostrar alerta
    ui.showToast('info', 'Cargando información.');

    getCurrentDetails();


    /**
     * Events
     */
    $categorySelect.on('change', async function () {
        const categoryId = $(this).val();
    
        if (!categoryId) {
            initServicesSelect([]);
            return;
        }

        try {
            const services = await getServicesByCategory(categoryId);
            initServicesSelect(services);

        } catch (error) {
            console.log('No se pudieron cargar los servicios', error);
            ui.showToast('error','No se pudieron cargar los servicios');
        }
    });

    $typesSelect.on('change', async function () {
        const teamId = $(this).val();

        try {

            const categories = await getCategoriesByTeam(teamId);

        } catch (error) {
            console.log('No se pudieron cargar las categorias', error);
            ui.showToast('error','No se pudieron cargar las categorias');
        }
    });

    $typesSelect

    $(document).on('submit', '.action-create', function (e) {
        e.preventDefault();

        const form = this;
        const formData = new FormData(form);

        if (typeof container !== 'undefined' && container.files.length > 0) {
            formData.delete('attachments[]'); 
            Array.from(container.files).forEach(file => {
                formData.append('attachments[]', file);
            });
        }

        const $submitBtn = $(form).find('button[type="submit"]');
        $submitBtn.prop('disabled', true);

        axios.post('/tickets', formData, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        })
        .then(response => {
           
            form.reset();
            if (typeof container !== 'undefined') {
                container.items.clear();
                renderFileList();
            }

            getCurrentDetails();
            $categorySelect.empty();
            $serviceSelect.empty();

            //Destruir instancias de select2
            if ($categorySelect.hasClass('select2-hidden-accessible')) {
                $categorySelect.select2('destroy');
            }

            if ($serviceSelect.hasClass('select2-hidden-accessible')) {
                $serviceSelect.select2('destroy');
            }

            $prioritiesSelect.empty();

            $('#modalSuccessCreate').modal('show');

        })
        .catch(error => {
            $(`.message-feedback`).text('');
            $(`.error-attachments`).text('');
            $('.form-control').removeClass('is-invalid');
            $(`select[name="category"]`)
              .next('.select2-container')
              .find('.select2-selection')
              .removeClass('is-invalid');

            if (error.response && error.response.status === 422) {
                
                const errors = error.response.data.errors;
                console.error('Errores de validación:', errors);
            
                // Recorrer y mostrar errores
                Object.keys(errors).forEach(key => {
                    
                    $(`input[name="${key}"]`).addClass('is-invalid');
                    $(`textarea[name="${key}"]`).addClass('is-invalid');
                    $(`select[name="${key}"]`).addClass('is-invalid');
                    $(`select[name="${key}"]`)
                          .next('.select2-container')
                          .find('.select2-selection')
                          .addClass('is-invalid');
                    $(`.error-${key}`).text(errors[key][0]);

                    if (key.startsWith('attachments')) {
                       $(`.error-attachments`).text(errors[key][0]);
                    }

                });
            } else {
                console.error('Error en el servidor:', error);
            }
        }).finally(function() {
             $submitBtn.prop('disabled', false);
        });
    });

    $dropZone.click(function () { 
        $inputDrop.trigger('click');
        
    });


    /**
     * drop and drag files
     */
    $dropZone.on('dragover', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $dropZone.addClass('drop-zone--over');
    });

    $dropZone.on('dragleave dragend', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $dropZone.removeClass('drop-zone--over');
    });

    $dropZone.on('drop', function (e) {
        e.preventDefault();
        e.stopPropagation();
        $dropZone.removeClass('drop-zone--over');

        const files = e.originalEvent.dataTransfer.files;
        if (files.length > 0) {
            addFiles(files);
        }
    });

    // Disparar input al hacer clic (evitando el bucle infinito)
    $dropZone.on('click', function (e) {
        if (!$(e.target).is($inputDrop)) {
            $inputDrop.trigger('click');
        }
    });

    $inputDrop.on('click', function (e) {
        e.stopPropagation();
    });

    // Capturar archivos seleccionados via explorador
    $inputDrop.on('change', function () {
        if (this.files.length > 0) {
            addFiles(this.files);
        }
    });

    function addFiles(files) {
        Array.from(files).forEach(file => {
            
            const exists = Array.from(container.files).some(
                f => f.name === file.name && f.size === file.size
            );

            if (!exists) {
                container.items.add(file);
            }
        });

        $inputDrop[0].files = container.files;
        renderFileList();
    }

    function renderFileList() {
        $fileList.empty();

        Array.from(container.files).forEach((file, index) => {

            const currentSize = formatFileSize(file.size);
           
            const fileItemHtml = `
                <div class="file-item">
                    <div class="header-file d-flex">
                        <strong>${currentSize}</strong>
                        <button type="button" class="file-item__remove" data-index="${index}">&times;</button>
                    </div>
                    <div class="title-file"><p>${file.name}</p></div>
                </div>
            `;
            $fileList.append(fileItemHtml);
        });
    }

    $fileList.on('click', '.file-item__remove', function () {
        const indexToRemove = $(this).data('index');

        const newContainer = new DataTransfer();
        Array.from(container.files).forEach((file, index) => {
            if (index !== indexToRemove) {
                newContainer.items.add(file);
            }
        });

        container.items.clear();
        Array.from(newContainer.files).forEach(f => container.items.add(f));

        $inputDrop[0].files = container.files;
        renderFileList();
    });

    function formatFileSize(bytes) {
        if (bytes === 0) return '0 MB';
        const mb = bytes / (1024 * 1024);
    
        if (mb < 0.01) {
            return (bytes / 1024).toFixed(2) + ' KB';
        }
    
        return mb.toFixed(2) + ' MB';
    }
    
});