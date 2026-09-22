$(document).ready(function () {
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
            '#0052FF', // En proceso 
            '#A3A8B5', // En espera 
            '#20C997', // Solucionado
            '#F59E0B'  // Cerrado
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

    new ApexCharts(document.querySelector("#avg-time-status-chart"), optionsAvgTime).render();

    //tickets cerrados por asignacion, preguntar esto a carmen mañana
    var optionsCloseRate = {
        series: [15, 10], // Cerrados vs Restante asignado
        chart: {
            type: 'donut',
            height: 220
        },
        colors: ['#F59E0B', '#7C3AED'], 
        labels: ['Cerrados', 'Pendientes'],
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

    new ApexCharts(document.querySelector("#close-rate-assignment-chart"), optionsCloseRate).render();

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

    new ApexCharts(document.querySelector("#cancellation-rate-chart"), optionsCancelRadial).render();

    //inyectar en el div los datos que se añadiran por hoy estaticos, mañana se añadiran los que vienen del backend
    var chart = new ApexCharts(document.querySelector("#tickets-status-chart"), options);
    chart.render();
});