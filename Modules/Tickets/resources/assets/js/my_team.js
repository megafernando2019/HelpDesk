import axios from "axios";

$(document).ready(function () {
    
    //Tooltips
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    const STATUS_COLORS = {
        'Cerrado': '#f3972c',     // Naranja
        'Solucionado': '#28c76f', // Verde
        // 'Cancelado': '#ea5455',   // Rojo
        'En espera': '#a3a4ac',   // Gris
        'En proceso': '#0049fc'   // Azul
    };
    let dateRangePicker = null;
    let selectedUserId = null;


    /**
     * Obtiene los miembros del equipo actual desde el servidor.
     * 
     * @returns {Promise<Array>} Lista de equipos y sus miembros mapeados
     */
    async function getCurrentMembers() {
        try {
            const response = await axios.get('/users/get_current_members');
        
            return response.data;
        } catch (error) {
            console.error('Error al obtener los miembros del equipo:', error);
        
            // Puedes personalizar la notificación al usuario (Toastr, SweetAlert2, etc.)
            const message = error.response?.data?.message || 'No se pudieron cargar los miembros.';
        
            return [];
        }
    }

    // Paleta de colores extraída directamente de tu diseño
    const colorPalette = [
        { color: '#f89d59', waveClass: 'aletory-wave-2' }, // Naranja
        { color: '#00a896', waveClass: 'aletory-wave-3' }, // Verde / Turquesa
        { color: '#fbc02d', waveClass: 'aletory-wave-4' }, // Amarillo
        { color: '#cb9b7a' , waveClass: 'aletory-wave-5' }  // Café / Beige
    ];

    /**
     * Renderiza la lista dinámica de miembros dentro del contenedor HTML.
     * 
     * @param {HTMLElement} containerElement Contenedor .d-flex.flex-column.gap-3
     */
    async function renderTeamMembers(containerElement) {
        ui.showToast('info', 'Cargando información de los integrantes...');
        // Obtener datos del endpoint
        const teamsData = await getCurrentMembers();

        if (!teamsData || !teamsData.length) {
            return;
        }

        // Extraer todos los miembros de los equipos
        let allMembers = [];
        teamsData.forEach(team => {
            if (team.members && Array.isArray(team.members)) {
                allMembers = allMembers.concat(team.members);
            }
        });

        // Eliminar duplicados si un usuario pertenece a más de un equipo
        const uniqueMembers = Array.from(new Map(allMembers.map(m => [m.id, m])).values());

        // HTML de la opción fija "Todos" (Tugui)
        let htmlContent = `
            <div data-bs-toggle="tooltip" title="Ver todo" class="card border shadow-sm rounded-4 team-card active-team-card overflow-hidden all-tugui-option-wave">
                <div class="card-body p-2 d-flex align-items-center gap-3">
                    <img 
                       src="/build/img/icons/tugui_en_computadora.png" alt="Tugui" 
                       style="width: 60px; height: 60px; object-fit: cover;"
                    >
                    <div class="title-all">
                        <span class="fw-bold text-dark fs-14">Todos</span>
                        <span class="fs-14 hide-word">Todos</span>
                        <span class="fs-14 hide-word">Todos</span>
                    </div>
                </div>
            </div>
        `;

        // Renderizar dinámicamente cada integrante cíclicamente
        uniqueMembers.forEach((member, index) => {
            // Selecciona el color y clase correspondiente según el índice actual
            const theme = colorPalette[index % colorPalette.length];

            const fullName = `${member.first_name || ''} ${member.last_name || ''}`.trim();
            const initials = member.initials || `${(member.first_name || '')[0] || ''}${(member.last_name || '')[0] || ''}`.toUpperCase();
            const email = member.email || '';

            htmlContent += `
                <div data-bs-toggle="tooltip" title="${email}" class="card border ${theme.waveClass} shadow-sm rounded-4 team-card overflow-hidden" data-member-id="${member.id}">
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

        // Inyectar HTML y re-inicializar tooltips de Bootstrap
        containerElement.innerHTML = htmlContent;

        // Inicializar tooltips de Bootstrap 5 en las nuevas tarjetas
        const tooltipTriggerList = containerElement.querySelectorAll('[data-bs-toggle="tooltip"]');
        tooltipTriggerList.forEach(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
    }

    renderTeamMembers(document.querySelector('.render-members'));

    if($('#flatpickr-range').length > 0 ){
        
        dateRangePicker = flatpickr("#flatpickr-range", {
            mode: "range",
            dateFormat: "d-m-Y",
            locale: "es", 
            onChange: function(selectedDates, dateStr, instance) {
                
                if (selectedDates.length === 2) {
                    // const $container = $('#tickets-container');
                    // const currentStatus = $container.attr('data-current-status') || null;
                    // const priority = $('[data-action=filter-by-priority]').val() || 0;
                    
                    // getTicketsDataKanban(currentStatus, null, priority);
                }
            },
            onClose: function(selectedDates, dateStr, instance) {
               
            }
        });
    }


    //Tiempo promedio
    var optionsAvgTime = {
        series: [{
            name: 'Días promedio',
            data: [2.0, 2.0, 1.0, 3.0] // En proceso, En espera, Solucionado, Cerrado
        }],
        chart: {
            type: 'bar',
            height: 280,
            toolbar: { show: false }
        },
        plotOptions: {
            bar: {
                horizontal: true,
                barHeight: '55%',
                distributed: true,
                borderRadius: 6,
                borderRadiusApplication: 'end'
            }
        },
        colors: ['#0052FF', '#A3A8B5', '#20C997', '#F59E0B'],
        dataLabels: { enabled: false },
        legend: { show: false },
        xaxis: {
            categories: ['En proceso', 'En espera', 'Solucionado', 'Cerrado'],
            min: 0,
            max: 3.0,
            tickAmount: 6,
            labels: {
                formatter: (val) => val.toFixed(1)
            }
        },
        grid: {
            borderColor: '#f1f1f1',
            xaxis: { lines: { show: true } },
            yaxis: { lines: { show: false } }
        }
    };

    let avgTimeChart = new ApexCharts(document.querySelector("#avg-time-status-chart"), optionsAvgTime);
    avgTimeChart.render();

    //tickets cerrados por asignacion, preguntar esto a carmen mañana
    var optionsCloseRate = {
        series: [15, 10], // Cerrados vs Restante asignado
        chart: {
            type: 'donut',
            height: 220
        },
        colors: ['#7C3AED', '#F59E0B'], 
        labels: ['Asignados','Cerrados'],
        legend: { show: false },
        dataLabels: { enabled: false },
        plotOptions: {
            pie: {
                donut: {
                    size: '70%'
                }
            }
        },
        stroke: { width: 0 }
    };

    let closeRateAssigment = new ApexCharts(document.querySelector("#close-rate-assignment-chart"), optionsCloseRate);
    closeRateAssigment.render();

    //Tasa de cierre 
    var optionsCloseRadial = {
        series: [67],
        chart: {
            type: 'radialBar',
            width: 130,
            height: 130,
            sparkline: { enabled: true }
        },
        colors: ['#F59E0B'],
        plotOptions: {
            radialBar: {
                hollow: { size: '60%' },
                track: { background: '#20C997', strokeWidth: '100%' },
                dataLabels: { show: false }
            }
        }
    };

    new ApexCharts(document.querySelector("#close-rate-radial-chart"), optionsCloseRadial).render();


    //Tasa de cancelacion
    var optionsCancelRadial = {
        series: [2],
        chart: {
            type: 'radialBar',
            width: 130,
            height: 130,
            sparkline: { enabled: true }
        },
        colors: ['#EF4444'], 
        plotOptions: {
            radialBar: {
                hollow: { size: '60%' },
                track: { background: '#06B6D4', strokeWidth: '100%' },
                dataLabels: { show: false }
            }
        }
    };

    let cancellationRadialChart = new ApexCharts(document.querySelector("#cancellation-rate-chart"), optionsCancelRadial);
    cancellationRadialChart.render();

    var options = {
        series: [{
            name: 'Tickets',
            data: [2, 2, 30, 25] // En proceso, En espera, Solucionado, Cerrado
        }],
        chart: {
            type: 'bar',
            height: 350,
            toolbar: {
                show: false
            }
        },
        plotOptions: {
            bar: {
                horizontal: true,
                barHeight: '55%',
                distributed: true, 
                borderRadius: 6,
                borderRadiusApplication: 'end'
            }
        },
        colors: [
            '#0049fc', // En proceso 
            '#a3a4ac', // En espera 
            '#28c76f', // Solucionado
            '#f3972c'  // Cerrado
        ],
        dataLabels: {
            enabled: false
        },
        legend: {
            show: false
        },
        xaxis: {
            categories: ['En proceso', 'En espera', 'Solucionado', 'Cerrado'],
            min: 0,
            max: 30,
            tickAmount: 6,
            labels: {
                style: {
                    colors: '#6c757d',
                    fontSize: '13px'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#212529',
                    fontSize: '14px',
                    fontWeight: 500
                }
            }
        },
        grid: {
            borderColor: '#f1f1f1',
            xaxis: {
                lines: {
                    show: true
                }
            },
            yaxis: {
                lines: {
                    show: false
                }
            }
        },
        tooltip: {
            theme: 'light'
        }
    };

    //inyectar en el div los datos que se añadiran por hoy estaticos, mañana se añadiran los que vienen del backend
    var chart = new ApexCharts(document.querySelector("#tickets-status-chart"), options);
    chart.render();

    // Delegación de evento de click sobre cualquier .team-card dentro de su contenedor
    $(document).on('click', '.team-card', function () {
        const $card =$(this);

        // Manejo visual de la clase 'active-team-card'
        $('.team-card').removeClass('active-team-card');$card.addClass('active-team-card');

        // Obtener el ID del miembro (si es Tugui/Todos devolverá undefined/empty)
        const memberId = $card.data('member-id') || null;

        selectedUserId = memberId;

        if (!selectedUserId) {
            console.log('Filtro activado: Vista Global (Todos)');
        } else {
            console.log(`Filtro activado: Usuario ID ${selectedUserId}`);
        }

        // Disparar la actualización de métricas
        loadDashboardMetrics(selectedUserId);
    });

    /**
     * Función encargada de pedir al backend los datos con el filtro aplicado
     */
    async function loadDashboardMetrics(userId = null) {
        const params = {
            member_id: userId // Enviamos member_id como espera tu backend
        };

        console.log('Enviando parámetros a las métricas:', params);

        try {
            const response = await axios.get('/tickets/my_team/apply_filters_charts', { params });
            const dataByStatusDistribution = response.data.dataByStatusDistribution ?? {};
            const dynamicColors = dataByStatusDistribution.categories.map(cat => STATUS_COLORS[cat] || '#7367f0');
            const seriesData = dataByStatusDistribution.series?.[0]?.data || [];

            const getCount = (statusName) => {
                const index = dataByStatusDistribution.categories.indexOf(statusName);
                return index !== -1 ? (seriesData[index] ?? 0) : 0;
            };

            $('.title-count-proccess').text(getCount('En proceso'));
            $('.title-count-closed').text(getCount('Cerrado'));

            chart.updateOptions({
                xaxis: {
                    categories: dataByStatusDistribution.categories
                },
                colors: dynamicColors,
                plotOptions: {
                    bar: {
                        horizontal: true,
                        distributed: true,
                        borderRadius: 6,
                        borderRadiusApplication: 'end'
                    }
                }
            });

            chart.updateSeries(dataByStatusDistribution.series);

            //Para la tasa de cierre
            const tasaCierre = response.data.tasaCierre ?? {};

            $('.title-count-assigned').text(tasaCierre.assigned);         
            $('.title-count-closed-rate').text(tasaCierre.closed);
            $('.title-avg-days').
            html(
                `<h3 class="fw-bold mb-0 text-dark title-avg-days">
                    ${tasaCierre?.avg_days ?? 0}
                <small class="fs-6 fw-normal text-muted">días</small></h3>`
            );

            const cerrados = tasaCierre.closed;
            const pendientes = tasaCierre.assigned - tasaCierre.closed;

            closeRateAssigment.updateSeries([pendientes, cerrados]);

            const avgTimeData = response.data.avgTimeData ?? {};
            const categories = avgTimeData.categories || [];
            const rawSeries = avgTimeData.series?.[0]?.data || [];


            const numericSeriesData = rawSeries.map(val => parseFloat(val) || 0);

            // Actualizar la gráfica de tiempo promedio
            avgTimeChart.updateOptions({
                xaxis: {
                    categories: categories,
                    labels: {
                        formatter: function (val) {
                            // Forzar a mostrar solo la parte entera
                            return Math.round(val);
                        },
                        style: { colors: '#6c757d', fontSize: '13px' }
                    }
                },
                yaxis: {
                    labels: {
                        formatter: function (val) {
                            return typeof val === 'number' ? val.toFixed(0) : val;
                        }
                    }
                },
                colors: dynamicColors
            });

            avgTimeChart.updateSeries([{
                name: 'Días Promedio',
                data: numericSeriesData
            }]);

        } catch (error) {
            console.error('Error al cargar métricas:', error);
        }
    }
});