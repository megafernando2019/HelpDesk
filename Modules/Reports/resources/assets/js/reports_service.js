import axios from "axios";

$(document).ready(function () {
    
    const currentTeamId = $('.metadata-page-index').data('teamId');
    const colorPalette = [
        { color: '#f89d59', waveClass: 'aletory-wave-2' },
        { color: '#00a896', waveClass: 'aletory-wave-3' },
        { color: '#fbc02d', waveClass: 'aletory-wave-4' },
        { color: '#cb9b7a', waveClass: 'aletory-wave-5' }
    ];
    let currentMembersIds = [];
    let currentUrl = '/reports/get_summary?page=1';

     // Rango de fechas
    $("#flatpickr-range").flatpickr({
        mode: "range",
        dateFormat: "Y-m-d",
        locale: "es",
        onChange: function (selectedDates) {
            if (selectedDates.length === 2) {
                loadAndRenderReport();
            }
        }
    });

    function renderPaginationButtons(pagination) {
        const container = document.getElementById('pagination-container');
        if (!container) return;
        
        container.innerHTML = '';

        const currentPage = pagination.current_page || 1;
        const lastPage = pagination.last_page || 1;

        // Si solo hay 1 página o no hay datos, no renderiza controles
        if (lastPage <= 1 && (!pagination.data || pagination.data.length === 0)) return;

        // Botón Anterior (<)
        const prevBtn = document.createElement('button');
        prevBtn.type = 'button';
        prevBtn.className = 'pagination-btn';
        prevBtn.innerHTML = '<i class="fa fa-angle-left"></i>';
        prevBtn.disabled = !pagination.prev_page_url;
        prevBtn.onclick = () => loadAndRenderReport(pagination.prev_page_url);
        container.appendChild(prevBtn);

        for (let page = 1; page <= lastPage; page++) {
           
            const pageBtn = document.createElement('button');
            pageBtn.type = 'button';
            pageBtn.className = `pagination-btn ${page === currentPage ? 'active' : ''}`;
            pageBtn.innerText = currentPage;

            if (page !== currentPage) {
                pageBtn.onclick = () => {
                    const pageUrl = `${pagination.path}?page=${page}`;
                    loadAndRenderReport(pageUrl);
                };
            }

            container.appendChild(pageBtn);
        }

        // Botón Siguiente (>)
        const nextBtn = document.createElement('button');
        nextBtn.type = 'button';
        nextBtn.className = 'pagination-btn';
        nextBtn.innerHTML = '<i class="fa fa-angle-right"></i>';
        nextBtn.disabled = !pagination.next_page_url;
        nextBtn.onclick = () => loadAndRenderReport(pagination.next_page_url);
        container.appendChild(nextBtn);
    }

    function initDataTableReport(data = []) {
    
        if ($.fn.DataTable.isDataTable('#categories-report-table')) {
            $('#categories-report-table').DataTable().clear().destroy();
        }

        let tabla = null;

        if ($('#categories-report-table').length > 0) {
            tabla = $('#categories-report-table').DataTable({
                "data": data,
                "destroy": true,
                "bFilter": false, 
                "bLengthChange": false,
                "bPaginate": false,
                "pageLength": 10,
                "ordering": false,
                "buttons": [
                    {
                        extend: 'excelHtml5',
                        title: 'Reporte_Por_Servicios',
                        className: 'buttons-excel d-none',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdfHtml5',
                        title: 'Reporte por Servicios',
                        orientation: 'landscape',
                        pageSize: 'A4',
                        className: 'buttons-pdf d-none', 
                        exportOptions: {
                            columns: ':visible'
                        }
                    }
                ],
                "language": {
                    "paginate": {
                        "next": '<i class="fa fa-angle-right"></i>',
                        "previous": '<i class="fa fa-angle-left"></i>'
                    },
                    "emptyTable": "No hay datos disponibles en la tabla"
                },
                "columns": [
                    { 
                        "data": null,
                        "render": function (data, type, row, meta) {
                            return meta.row + 1;
                        }
                    },
                    { 
                        "data": null,
                        "render": function (data, type, row, meta) {
                            return `<div class="text-start">${row?.service_name ?? '-'}</div>`;
                        }
                    },
                    { 
                        "data": null,
                        "render": function (data, type, row, meta) {
                            return `<div class="text-start">${row?.category_name ?? '-'}</div>`;
                        }
                    },
                    { "data": "total_tickets", "defaultContent": "0" },
                    { "data": "por_asignar", "defaultContent": "0" },
                    { "data": "en_proceso", "defaultContent": "0" },
                    { "data": "en_espera", "defaultContent": "0" },
                    { "data": "solucionados", "defaultContent": "0" },
                    { "data": "cerrados", "defaultContent": "0" },
                    { "data": "cancelados", "defaultContent": "0" },
                    { "data": "compliance", "defaultContent": "0%" },
                    { "data": "tps", "defaultContent": "0 hrs" }
                ]
            });
        }

        return tabla;
    }


    /**
     * Obtiene los miembros del equipo actual desde el servidor.
     */
    async function getCurrentMembers() {
        try {
            const response = await axios.get('/users/get_current_members');
            return response.data;
        } catch (error) {
            console.error('Error al obtener los miembros del equipo:', error);
            return [];
        }
    }

    /**
     * Renderiza la lista dinámica de miembros
     */
    async function renderTeamMembers(containerElement) {
        if (typeof ui !== 'undefined') {
           
        }
        
        const teamsData = await getCurrentMembers();

        if (!teamsData || !teamsData.length) return;

        let allMembers = [];
        teamsData.forEach(team => {
            if (team.members && Array.isArray(team.members)) {
                allMembers = allMembers.concat(team.members);
            }
        });

        const uniqueMembers = Array.from(new Map(allMembers.map(m => [m.id, m])).values());

        // HTML Opción "Todos"
        let htmlContent = `
            <div data-bs-toggle="tooltip" title="Ver todo" class="mt-2 card border shadow-sm rounded-4 team-card active-team-card overflow-hidden all-tugui-option-wave"  
                 data-member-id="all">
                <div class="card-body p-2 d-flex align-items-center gap-3">
                    <img src="/build/img/icons/tugui_en_computadora.png" alt="Tugui" style="width: 60px; height: 60px; object-fit: cover;">
                    <div class="title-all">
                        <span class="fw-bold text-dark fs-14">Todos</span>
                    </div>
                </div>
            </div>
        `;

        uniqueMembers.forEach((member, index) => {
            const theme = colorPalette[index % colorPalette.length];
            const fullName = `${member.first_name || ''} ${member.last_name || ''}`.trim();
            const initials = member.initials || `${(member.first_name || '')[0] || ''}${(member.last_name || '')[0] || ''}`.toUpperCase();
            const email = member.email || '';

            htmlContent += `
                <div data-bs-toggle="tooltip" title="${email}" class="card border ${theme.waveClass} shadow-sm rounded-4 team-card member-card overflow-hidden" data-member-id="${member.id}">
                    <div class="card-body p-2 d-flex align-items-center gap-3">
                        <div class="avatar-circle text-white fw-bold d-flex align-items-center justify-content-center rounded-circle" style="width: 50px; height: 50px; background-color: ${theme.color}; flex-shrink: 0;">
                            ${initials}
                        </div>
                        <div class="text-truncate">
                            <div class="fw-bold text-dark fs-14 lh-sm text-truncate">${fullName}</div>
                            <small class="text-muted fs-10 text-truncate d-block">${email}</small>
                        </div>
                    </div>
                </div>
            `;
        });

        containerElement.innerHTML = htmlContent;

        const tooltipList = containerElement.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipList.forEach(el => new bootstrap.Tooltip(el));

        const $firstCard = $('.team-card[data-member-id="all"]');
        if ($firstCard.length) {
            $firstCard.trigger('click');
        } else {
            $('.team-card').first().trigger('click');
        }

    }

    async function fecthDataRerport(url = null) {
        
           $('.set-loading').addClass('item-disabled');
        try {
            const response = await axios.get(url ?? currentUrl, {
                params: {
                    team_id: [currentTeamId],
                    module: 'services',
                    members_id: currentMembersIds,
                    date_range: $('#flatpickr-range').val() || null,
                }
            });
            
            return response?.data ?? [];

        } catch (error) {
            console.error('Error al obtener información:', error.response?.data || error.message);
            throw error;
        } finally {

            $('.set-loading').removeClass('item-disabled');
        }
    }


    async function loadAndRenderReport(url = null) {
        if (url) currentUrl = url;
        const paginationData = await fecthDataRerport(currentUrl);

        initDataTableReport(paginationData.data || [], paginationData);
        renderPaginationButtons(paginationData);

        ui.showToast('success', 'Se actualizó la información correctamente')
    }

    renderTeamMembers(document.querySelector('.render-members'));

    /**
     * ----------------
     * Events
     * ----------------
     */
    $(document).on('click', '#btn-export-excel', function () {
        const table = $('#categories-report-table').DataTable();
        table.button('.buttons-excel').trigger();
    });

    $(document).on('click', '#btn-export-pdf', function () {
        const table = $('#categories-report-table').DataTable();
        table.button('.buttons-pdf').trigger();
    });
    
    $(document).on('click', '.team-card', async function () {
        const $card =$(this);

        $('.team-card').removeClass('active-team-card active');
        $('.all-tugui-option-wave').removeClass('member-card active');$card.addClass('active-team-card active');

        const memberId = $card.data('member-id') ?? 'all';
        
        if (memberId === 'all') {
            currentMembersIds = [];
            
            $('.all-tugui-option-wave').addClass('member-card active');
        } else if (memberId) {
            currentMembersIds = [memberId];
        } else {
            currentMembersIds = [];
        }

        // Reiniciar a la primera página al cambiar de filtro de miembro
        currentUrl = '/reports/get_summary?page=1';
        await loadAndRenderReport(currentUrl);
    });

});