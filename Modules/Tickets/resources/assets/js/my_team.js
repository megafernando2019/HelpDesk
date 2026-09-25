import axios from "axios";

$(document).ready(function () {
    
    // Tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    
    const STATUS_COLORS = {
        'Cerrado': '#f3972c',     // Naranja
        'Solucionado': '#28c76f', // Verde
        'En espera': '#a3a4ac',   // Gris
        'En proceso': '#0049fc'   // Azul
    };

    // Almacena los IDs de los miembros seleccionados (Siempre como ARRAY)
    let currentMembersIds = [];

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

    const colorPalette = [
        { color: '#f89d59', waveClass: 'aletory-wave-2' },
        { color: '#00a896', waveClass: 'aletory-wave-3' },
        { color: '#fbc02d', waveClass: 'aletory-wave-4' },
        { color: '#cb9b7a', waveClass: 'aletory-wave-5' }
    ];

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

    // Inicialización de Gráficas de ApexCharts
    var optionsAvgTime = {
        series: [{ name: 'Días promedio', data: [0, 0, 0, 0] }],
        chart: { type: 'bar', height: 280, toolbar: { show: false } },
        plotOptions: { bar: { horizontal: true, barHeight: '55%', distributed: true, borderRadius: 6 } },
        colors: ['#0052FF', '#A3A8B5', '#20C997', '#F59E0B'],
        dataLabels: { enabled: false },
        legend: { show: false },
        xaxis: { categories: ['En proceso', 'En espera', 'Solucionado', 'Cerrado'] }
    };
    let avgTimeChart = new ApexCharts(document.querySelector("#avg-time-status-chart"), optionsAvgTime);
    avgTimeChart.render();

    var optionsCloseRate = {
        series: [0, 0],
        chart: { type: 'donut', height: 220 },
        colors: ['#7C3AED', '#F59E0B'], 
        labels: ['Asignados','Cerrados'],
        legend: { show: false },
        dataLabels: { enabled: false }
    };
    let closeRateAssigment = new ApexCharts(document.querySelector("#close-rate-assignment-chart"), optionsCloseRate);
    closeRateAssigment.render();

    var optionsCloseRadial = {
        series: [0],
        chart: { type: 'donut', width: 130, height: 130, sparkline: { enabled: true } },
        colors: ['#f3972c', '#28c76f']
    };
    let closeRateRadialChart = new ApexCharts(document.querySelector("#close-rate-radial-chart"), optionsCloseRadial);
    closeRateRadialChart.render();

    var optionsCancelRadial = {
        series: [0],
        chart: { type: 'donut', width: 130, height: 130, sparkline: { enabled: true } },
        colors: ['#ff5757', '#0cc0df']
    };
    let cancellationRadialChart = new ApexCharts(document.querySelector("#cancellation-rate-chart"), optionsCancelRadial);
    cancellationRadialChart.render();

    var options = {
        series: [{ name: 'Tickets', data: [0, 0, 0, 0] }],
        chart: { type: 'bar', height: 350, toolbar: { show: false } },
        plotOptions: { bar: { horizontal: true, barHeight: '55%', distributed: true, borderRadius: 6 } },
        colors: ['#0049fc', '#a3a4ac', '#28c76f', '#f3972c'],
        dataLabels: { enabled: false },
        legend: { show: false },
        xaxis: { categories: ['En proceso', 'En espera', 'Solucionado', 'Cerrado'] }
    };
    var chart = new ApexCharts(document.querySelector("#tickets-status-chart"), options);
    chart.render();


    /**
     * Extrae todos los filtros del DOM y el array de miembros seleccionado
     */
    function getSelectedFilters() {
        const categoryVal = $('#filter_category').val();
        const serviceVal = $('#filter_service').val();

        return {
            date_range: $('#flatpickr-range').val() || null,
            categories: categoryVal ? [categoryVal] : [],
            services: (serviceVal && serviceVal !== 'Selecciona servicio(s)') ? [serviceVal] : [],
            members_id: currentMembersIds 
        };
    }

    /**
     * Carga y actualiza las métricas en las gráficas
     */
    async function loadDashboardMetrics() {
        const params = getSelectedFilters();

        ui.showToast('info', 'Consultando datos...');
        $('.set-loading').addClass('item-disabled');

        try {
            const response = await axios.get('/tickets/my_team/apply_filters_charts', { params });
            const dataByStatusDistribution = response.data.dataByStatusDistribution ?? {};
            let dynamicColors;
            const seriesData = dataByStatusDistribution.series?.[0]?.data || [];
            let totalAllCloseOption = 0;
            let totalAllProgressOption = 0;
           
            const isStacked = dataByStatusDistribution.mode === 'stacked';

            const statusColorsMap = {
                'En proceso': '#0052CC',
                'En espera': '#9FA6B2',
                'Solucionado': '#00D084',
                'Cerrado': '#FF9F43'
            };

            if (isStacked) {
                dynamicColors = (dataByStatusDistribution.series || []).map(s => statusColorsMap[s.name] || '#7367f0');
                chart.updateOptions({
                    chart: { stacked: true, stackType: 'normal', animations: { enabled: false } },
                    xaxis: { categories: dataByStatusDistribution.categories || [] },
                    colors: dynamicColors,
                    plotOptions: { bar: { horizontal: true, distributed: false, borderRadius: 4 } },
                    legend: { show: true, position: 'top', horizontalAlign: 'left' }
                }, false, true);

                 dataByStatusDistribution.series.forEach(element => {
                
                        switch (element.name) {
                            case 'Cerrado':
                                totalAllCloseOption = element.data.reduce((t, actual) => t + actual, 0);
                                $('.title-count-closed').text(totalAllCloseOption);
                                break;
                            case 'En proceso':
                                 totalAllProgressOption = element.data.reduce((t, actual) => t + actual, 0);
                                $('.title-count-proccess').text(totalAllProgressOption);
                                $('.compare-process').text(totalAllProgressOption);
                                break;
                    
                            default:
                                break;
                        }
                });


            } else {
                dynamicColors = (dataByStatusDistribution.categories || []).map(cat => STATUS_COLORS[cat] || statusColorsMap[cat] || '#7367f0');
                chart.updateOptions({
                    chart: { stacked: false, animations: { enabled: false } },
                    xaxis: { categories: dataByStatusDistribution.categories || [] },
                    colors: dynamicColors,
                    plotOptions: { bar: { horizontal: true, distributed: true, borderRadius: 6 } },
                    legend: { show: false }
                }, false, true);

                const getCount = (statusName) => {
                    const categories = dataByStatusDistribution.categories || [];
                    const index = categories.indexOf(statusName);
                    return index !== -1 ? (seriesData[index] ?? 0) : 0;
                };

                $('.compare-process').text(getCount('En proceso'));
                $('.title-count-proccess').text(getCount('En proceso'));
                $('.title-count-closed').text(getCount('Cerrado'));
            }

            chart.updateSeries(dataByStatusDistribution.series || []);

            // --- Tasa de Cierre ---
            const tasaCierre = response.data.tasaCierre ?? {};

            $('.title-count-assigned').text(tasaCierre.assigned ?? 0);         
            $('.title-count-closed-rate').text(tasaCierre.closed ?? 0);
            $('.title-avg-days').html(
                `<h3 class="fw-bold mb-0 text-dark title-avg-days">
                    ${tasaCierre?.avg_days ?? 0}
                <small class="fs-6 fw-normal text-muted">días</small></h3>`
            );

            const cerrados = tasaCierre.closed ?? 0;
            const asignados = tasaCierre.assigned ?? 0;
            const pendientes = asignados - cerrados;

            if (typeof closeRateAssigment !== 'undefined' && closeRateAssigment) {
                closeRateAssigment.updateSeries([pendientes < 0 ? 0 : pendientes, cerrados]);
            }

            // --- Tiempo Promedio ---
            const avgTimeData = response.data.avgTimeData ?? {};
            const categories = avgTimeData.categories || [];
            const rawSeries = avgTimeData.series?.[0]?.data || [];
            const numericSeriesData = rawSeries.map(val => parseFloat(val) || 0);

            $('.count-title-tickets-assing').text(asignados);$('.compare-assign').text(asignados);

            if (typeof avgTimeChart !== 'undefined' && avgTimeChart) {
                avgTimeChart.updateOptions({
                    xaxis: { categories: categories },
                    colors: dynamicColors
                }, false, true);

                avgTimeChart.updateSeries([{ name: 'Días Promedio', data: numericSeriesData }]);
            }

            // --- Tarjetas Radial ---
            if (response.data.cardMetricsClousure && typeof closeRateRadialChart !== 'undefined') {
                $('.percentage-tasa-closed').text(`${response.data.cardMetricsClousure.percentage ?? 0}%`);
                closeRateRadialChart.updateSeries(response.data.cardMetricsClousure.series || []);
            }

            if (response.data.cardMetricsCancellation && typeof cancellationRadialChart !== 'undefined') {
                $('.percentage-tasa-cancelation').text(`${response.data.cardMetricsCancellation.percentage ?? 0}%`);
                cancellationRadialChart.updateSeries(response.data.cardMetricsCancellation.series || []);
            }

        } catch (error) {
            console.error('Error al cargar métricas:', error);
        } finally {
            $('.set-loading').removeClass('item-disabled');
        }
    }


    // ==========================================
    // LISTENERS DE EVENTOS
    // ==========================================
    $(document).on('click', '.team-card', function () {
        const $card =$(this);

        // Estilos visuales
        $('.team-card').removeClass('active-team-card active');
        $('.all-tugui-option-wave').removeClass('member-card active');
        $card.addClass('active-team-card active');

        const memberId = $card.data('member-id') ?? 'all';
        
        if (memberId === 'all') {
            // Si es "Todos", recolectamos los IDs de los demás
            currentMembersIds = [];
            $('.team-card').not($card).each(function () {
                const id = $(this).data('member-id');
                if (id && id !== 'all') {
                    currentMembersIds.push(id);
                }
            });

            $('.all-tugui-option-wave').addClass('member-card active');
        } else if (memberId) {
            currentMembersIds = [memberId];
        } else {
            currentMembersIds = [];
        }

        loadDashboardMetrics();
    });

    // Rango de fechas
    $("#flatpickr-range").flatpickr({
        mode: "range",
        dateFormat: "Y-m-d",
        locale: "es",
        onChange: function (selectedDates) {
            if (selectedDates.length === 2) {
                loadDashboardMetrics();
            }
        }
    });

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

    $('#filter_category').on('change', async function () {
        const value = $(this).val();
        $('#filter_service').empty();
        $('#filter_services').html('<option>Selecciona servicio(s)</option>');

        if (!value) {
            return;
        }

       let data = await getServicesByCategory(value);
       let html = (data?.map(s => `
                                <option value="${s?.id}">${s?.name ?? ''}</option>
                            `) ?? []).join('');

       $('#filter_service').html(html).trigger('change');
    }); 

    $('#filter_service').on('change', function () {
        const value = $(this).val();
       
        if (!value) {
           
            return;
        }

        loadDashboardMetrics();
        
    });

});