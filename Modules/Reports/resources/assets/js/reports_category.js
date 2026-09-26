import axios from "axios";

$(document).ready(function () {
    
    const colorPalette = [
        { color: '#f89d59', waveClass: 'aletory-wave-2' },
        { color: '#00a896', waveClass: 'aletory-wave-3' },
        { color: '#fbc02d', waveClass: 'aletory-wave-4' },
        { color: '#cb9b7a', waveClass: 'aletory-wave-5' }
    ];

    // const tooltipList = containerElement.querySelectorAll('[data-bs-toggle="tooltip"]');
    // tooltipList.forEach(el => new bootstrap.Tooltip(el));

    if ($.fn.DataTable.isDataTable('#categories-report-table')) {
        $('#categories-report-table').DataTable().destroy();
    }

    if ($('#categories-report-table').length > 0) {
        $('#categories-report-table').DataTable({
            "destroy": true,
            "bFilter": false, // Ocultar barra de búsqueda si no la requieres
            "bLengthChange": false,
            "pageLength": 10,
            "ordering": false,
            "language": {
                "paginate": {
                    "next": '<i class="fa fa-angle-right"></i>',
                    "previous": '<i class="fa fa-angle-left"></i>'
                }
            }
        });
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
            <div data-bs-toggle="tooltip" title="Ver todo" class="card border shadow-sm rounded-4 team-card active-team-card overflow-hidden all-tugui-option-wave"  
                 data-member-id="all">
                <div class="card-body p-2 d-flex align-items-center gap-3">
                    <img src="/build/img/icons/tugui_en_computadora.png" alt="Tugui" style="width: 60px; height: 60px; object-fit: cover;">
                    <div class="title-all">
                        <span class="fw-bold text-dark fs-14">Todos</span>
                        <span class="fs-14 hide-word">Todos</span>
                        <span class="fs-14 hide-word">Todos</span>
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

    renderTeamMembers(document.querySelector('.render-members'));

});