<div class="row g-3">
    <!-- Tickets asignados -->
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
        <div class="card border-0 shadow-sm rounded-4 flex-fill bg-white">
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 52px; height: 52px; background-color: #f3f0ff; flex-shrink: 0;">
                        <i class="ti ti-user fs-2 text-primary" style="color: #7367f0 !important;"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0 text-dark lh-1 count-title-tickets-assing">0</h3>
                        <span class="text-muted fs-11">Tickets asignados</span>
                    </div>
                </div>
                <div class="mt-2 pt-1">
                    <small class="text-success fw-semibold fs-8">
                        {{-- <i class="ti ti-arrow-up"></i> 15% <span class="text-muted fw-normal fs-11">vs periodo anterior</span> --}}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets en proceso -->
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
        <div class="card border-0 shadow-sm rounded-4 flex-fill bg-white">
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 52px; height: 52px; background-color: #e8f1ff; flex-shrink: 0;">
                        <i class="ti ti-progress-check fs-2 text-info" style="color: #288ec7 !important;"></i>
                        {{-- <i class="ti ti-progress-check"></i> --}}
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0 text-dark lh-1 title-count-proccess">0</h3>
                        <span class="text-muted fs-11">Tickets en proceso</span>
                    </div>
                </div>
                <div class="mt-2 pt-1">
                    <small class="text-danger fw-semibold">
                        {{-- <i class="ti ti-arrow-down"></i> 2% <span class="text-muted fw-normal fs-11">vs periodo anterior</span> --}}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Tickets cerrados -->
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
        <div class="card border-0 shadow-sm rounded-4 flex-fill bg-white">
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 52px; height: 52px; background-color: #fff4e5; flex-shrink: 0;">
                        <i class="ti ti-lock-check fs-2" style="color: #ff9f43 !important;"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0 text-dark lh-1 title-count-closed">0</h3>
                        <span class="text-muted fs-11">Tickets cerrados</span>
                    </div>
                </div>
                <div class="mt-2 pt-1">
                    <small class="text-success fw-semibold fs-11">
                        {{-- <i class="ti ti-arrow-up"></i> 8% <span class="text-muted fw-normal">vs periodo anterior</span> --}}
                    </small>
                </div>
            </div>
        </div>
    </div>

    <!-- Carga actual -->
    <div class="col-xl-3 col-sm-6 col-12 d-flex">
        <div class="card border-0 shadow-sm rounded-4 flex-fill bg-white">
            <div class="card-body p-3 d-flex flex-column justify-content-between">
                <div class="d-flex align-items-center gap-3">
                    <div class="d-flex align-items-center justify-content-center rounded-3" style="width: 52px; height: 52px; background-color: #e6f6f5; flex-shrink: 0;">
                        <i class="ti ti-ticket fs-2" style="color: #12939a !important;"></i>
                    </div>
                    <div>
                        <h3 class="fw-bold mb-0 text-dark lh-1">
                            <span class="compare-process">0</span>/<span class="compare-assign">0</span>
                        </h3>
                        <span class="text-muted fs-11">Carga actual</span>
                    </div>
                </div>
                <div class="mt-2 pt-1">
                    <small class="text-danger fw-semibold fs-11">
                        {{-- <i class="ti ti-arrow-down"></i> 4% <span class="text-muted fw-normal">vs periodo anterior</span> --}}
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>