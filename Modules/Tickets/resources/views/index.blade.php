@extends('layout.mainlayout')

@section('content')
<div class="page-wrapper">
    <div class="content container-fluid">
            
        <div class="page-header">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="page-title">
                        <i class="ti ti-ticket"></i>
                        Mis Tickets
                    </h3>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between gap-2">
            @forelse ($dto->statuses as $item)
                   <div 
                        data-action="filter-by-status"
                        data-id="{{$item?->id}}"
                        data-bg-color="{{$item?->bg_color ?? '#fff'}}"
                        style="background-color: 
                        {{$item?->bg_color ?? '#fff'}}; width:250px; border: 1px solid #eee; border-radius: 11px;"; 
                        class="{{$item?->id === 1 ? 'shadow-lg' : ''}} p-2 d-flex align-items-center gap-2 cursor: pointer;">
                        <span class="d-flex align-items-center justify-content-center" style="background: {{$item?->badge_bg??''}}; height: 50px; width: 50px; border-radius: 50%;">
                            <i style="color: {{$item?->text_color ?? ''}};" class="{{$item?->icon ?? ''}} fs-26"></i>
                        </span>
                       <div class="details-ticket-card-status d-flex flex-column">
                           <h3>{{$item?->tickets_count ?? 0}}</h3>
                           <span> {{$item?->name ?? ''}}</span>
                       </div>
                   </div>
            @empty
                   
            @endforelse
        </div>

        <div class="d-flex align-items-center justify-content-end mt-2 gap-2">
    
            <div style="width: 170px;">
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted pe-1">
                        <i class="ti ti-pin fs-16"></i>
                    </span>
                    <select class="form-control border-start-0  ps-1" 
                            name="priority_param_id"
                            data-action=filter-by-priority>
                        <option value="">Prioridad</option>
                        @forelse ($dto->priorities as $item)
                            <option value="{{ $item?->id ?? 0 }}">
                                {{ $item?->name ?? 'Dato no disponible' }}
                            </option>
                        @empty
                        @endforelse
                    </select>
                </div>
            </div>

            <div style="width: 250px;">
                <div class="input-group">
                    <span class="input-group-text bg-white text-muted pe-1">
                        <i class="ti ti-calendar-week fs-16"></i>
                    </span>
                    <input type="text" 
                           class="form-control border-start-0  ps-1" 
                           placeholder="Selecciona rango de fecha" 
                           id="flatpickr-range-tickets">
                </div>
            </div>

        </div>

        <div id="tickets-container" data-current-status="1" style="background-color: rgb(250, 248, 255);border: 2px solid #e8e8e8;" class="current-rounded row mt-4 p-4 rounded"></div>

        @include('tickets::partials.kaban-index-template')
        @include('tickets::partials.modal-add-observation')

    </div>
</div>

@vite(['Modules/Tickets/resources/assets/js/index.js'])
@endsection