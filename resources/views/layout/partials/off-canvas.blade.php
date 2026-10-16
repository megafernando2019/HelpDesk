<div class="offcanvas offcanvas-end custom-offcanvas" style="width: 520px !important;" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel" aria-modal="true" role="dialog">
    <div class="offcanvas-header">
        <!-- Título cambiado a Resultados -->
        <h4 id="offcanvasRightLabel" class="text-grey">Resultados</h4>
        <button type="button" class="btn-close ms-auto" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div> <!-- end offcanvas header -->

    <div class="offcanvas-body">
        <!-- Filtros de Notificaciones -->
        <div id="notification-filters" class="d-flex align-items-center gap-2 mb-3 d-none">
            <button type="button" class="btn btn-info rounded-pill px-4 py-1.5 btn-notif-filter active" data-filter="today">Hoy</button>
            <button type="button" class="btn btn-light text-muted rounded-pill px-4 py-1.5 btn-notif-filter" data-filter="week">Esta semana</button>
            <button type="button" class="btn btn-light text-muted rounded-pill px-4 py-1.5 btn-notif-filter" data-filter="read">Leídas</button>
        </div>

         <div class="loading-tugui p-1 d-flex justify-content-center d-none">
            <img width="100" 
            src="{{asset('build\img\icons\gif_tugui_en_computadora_sin_fondo.gif')}}" 
            alt="tugui">
        </div>
        <!-- Contenedor donde se pintarán las tarjetas de los tickets -->
        <div id="contenedor-resultados" class="d-flex flex-column gap-3">
            <p class="text-muteds">Escribe algo en el buscador para ver resultados...</p>
        </div>
    </div> <!-- end offcanvas body -->
</div>