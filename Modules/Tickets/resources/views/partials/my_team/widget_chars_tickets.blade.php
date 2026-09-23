<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h5 class="card-title fw-bold text-dark mb-1">Distribución de tickets por estatus</h5>
                <p class="card-subtitle text-muted fs-7">Muestra cómo se distribuyen los tickets según su estado actual.</p>
            </div>
            <div class="card-body px-4 pb-4">
                <div id="tickets-status-chart" style="min-height: 365px;"></div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h5 class="card-title fw-bold text-dark mb-1">Tasa de cierre por asignación</h5>
                <p class="card-subtitle text-muted fs-7">Porcentaje de tickets asignados que han sido cerrados.</p>
            </div>
            <div class="card-body px-4 pb-4">
                <div id="close-rate-assignment-chart" style="min-height: 220px;"></div>
        
                <div class="row align-items-center text-center mt-3 pt-2 border-top">
                    <div class="col-4">
                        <!-- Agregada clase: title-count-assigned -->
                        <h3 class="fw-bold mb-0 text-dark title-count-assigned">0</h3>
                        <span class="badge fw-semibold px-2 py-1 rounded-pill fs-8" style="background-color: #f3eeff; color:blueviolet;">Asignados</span>
                    </div>
                    <div class="col-4">
                        <!-- Agregada clase: title-count-closed-rate -->
                        <h3 class="fw-bold mb-0 text-dark title-count-closed-rate">0</h3>
                        <span class="badge bg-warning-subtle text-warning fw-semibold px-2 py-1 rounded-pill fs-8">Cerrados</span>
                    </div>
                    <div class="col-4 border-start">
                        <!-- Agregada clase: title-avg-days -->
                        <h3 class="fw-bold mb-0 text-dark title-avg-days">0 <small class="fs-6 fw-normal text-muted">días</small></h3>
                        <span class="badge text-success fw-semibold px-2 py-1 rounded-pill fs-8" style="background-color: #e4f8ed; text-wrap: wrap;">Tiempo promedio de solución</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-6">
        <div class="card shadow-sm border-0 rounded-4">
            <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                <h5 class="card-title fw-bold text-dark mb-1">Tiempo promedio por estatus</h5>
                <p class="card-subtitle text-muted fs-7">Mide el tiempo promedio que permanecen los tickets en cada estatus del flujo de atención.</p>
            </div>
            <div class="card-body px-4 pb-4">
                <div id="avg-time-status-chart" style="min-height: 280px;"></div>
            </div>
        </div>
    </div>

    <div class="col-md-6 d-flex">
       <div class="row">
        <div class="col-md-12">
            <div class="card shadow-sm border-0 rounded-4 mb-3">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title fw-bold text-dark mb-1">Tasa de cierre</h5>
                        <p class="card-subtitle text-muted fs-7 mb-3">Porcentaje de tickets solucionados o cerrados.</p>
                        <h2 class="display-6 fw-bold text-dark mb-1">67%</h2>
                        <span class="text-danger fs-7 fw-semibold">
                            <i class="bi bi-arrow-down"></i> 2% <span class="text-muted fw-normal">vs periodo anterior</span>
                        </span>
                    </div>
                    <div style="width: 120px; height: 120px;">
                        <div id="close-rate-radial-chart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-12">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-4 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="card-title fw-bold text-dark mb-1">Tasa de cancelación</h5>
                        <p class="card-subtitle text-muted fs-7 mb-3">Porcentaje de tickets cancelados respecto al total.</p>
                        <h2 class="display-6 fw-bold text-dark mb-1">2%</h2>
                        <span class="text-danger fs-7 fw-semibold">
                            <i class="bi bi-arrow-down"></i> 10% <span class="text-muted fw-normal">vs periodo anterior</span>
                        </span>
                    </div>
                    <div class="position-relative" style="width: 120px; height: 120px;">
                        <div id="cancellation-rate-chart"></div>
                        <!-- Icono central -->
                        <div class="position-absolute top-50 start-50 translate-middle text-danger">
                            <i class="bi bi-slash-circle fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
       </div>
    </div>
</div>