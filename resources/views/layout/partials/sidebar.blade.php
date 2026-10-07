@if (!Route::is(['pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5']))
<!-- Sidebar -->
<div class="sidebar" id="sidebar">
    @endif

    @if (Route::is(['pos', 'pos-2', 'pos-3', 'pos-4', 'pos-5']))
    <!-- Sidebar -->
    <div class="sidebar d-none" id="sidebar">
        @endif
        <!-- Logo -->
        <div class="sidebar-logo justify-content-center">
            <a href="{{route('tickets.index')}}" class="logo logo-normal">
                <img 
                    style="width: 50px;
                           height: 50px;"
                    src="{{URL::asset('build/img/icons/helpdesk_img.png')}}" 
                    alt="Helpdesk logo">
            </a>
            <a href="{{route('tickets.index')}}" 
                class="logo logo-small">
                <img 
                    src="{{URL::asset('build/img/icons/helpdesk_img.png')}}" 
                    alt="Helpdesk logo">
            </a>
            <a id="toggle_btn" class="bg-mega" href="javascript:void(0);">
                <i data-feather="chevrons-left" class="feather-16"></i>
            </a>
        </div>
        <!-- /Logo -->
        <div class="modern-profile p-3 pb-0">
            <div class="text-center rounded bg-light p-3 mb-4 user-profile">
                <div class="avatar avatar-lg online mb-3">
                    <img src="{{URL::asset('build/img/customer/customer15.jpg')}}" alt="Img"
                        class="img-fluid rounded-circle">
                </div>
                <h6 class="fs-14 fw-bold mb-1">Adrian Herman</h6>
                {{-- <p class="fs-12 mb-0">System Admin</p> --}}
            </div>
            <div class="sidebar-nav mb-3">
                <ul class="nav nav-tabs nav-tabs-solid nav-tabs-rounded nav-justified bg-transparent" role="tablist">
                    <li class="nav-item"><a class="nav-link active border-0" href="#">Menu</a></li>
                    <li class="nav-item"><a class="nav-link border-0" href="{{route('chat')}}">Chats</a></li>
                    <li class="nav-item"><a class="nav-link border-0" href="{{route('email')}}">Inbox</a></li>
                </ul>
            </div>
        </div>
        <div class="sidebar-header p-3 pb-0 pt-2">
            <div class="text-center rounded bg-light p-2 mb-4 sidebar-profile d-flex align-items-center">
                <div class="avatar avatar-md onlin">
                    <img src="{{URL::asset('build/img/customer/customer15.jpg')}}" alt="Img"
                        class="img-fluid rounded-circle">
                </div>
                <div class="text-start sidebar-profile-info ms-2">
                    <h6 class="fs-14 fw-bold mb-1">{{Auth::user()->first_name ?? ''}}</h6>
                    {{-- <p class="fs-12">System Admin</p> --}}
                </div>
            </div>
            <div class="d-flex align-items-center justify-content-between menu-item mb-3">
                <div>
                    <a href="{{route('index')}}" class="btn btn-sm btn-icon bg-light">
                        <i class="ti ti-layout-grid-remove"></i>
                    </a>
                </div>
                <div>
                    <a href="{{route('chat')}}" class="btn btn-sm btn-icon bg-light">
                        <i class="ti ti-brand-hipchat"></i>
                    </a>
                </div>
                <div>
                    <a href="{{route('email')}}" class="btn btn-sm btn-icon bg-light position-relative">
                        <i class="ti ti-message"></i>
                    </a>
                </div>
                <div class="notification-item">
                    <a href="{{route('activities')}}" class="btn btn-sm btn-icon bg-light position-relative">
                        <i class="ti ti-bell"></i>
                        <span class="notification-status-dot"></span>
                    </a>
                </div>
                <div class="me-0">
                    <a href="{{route('general-settings')}}" class="btn btn-sm btn-icon bg-light">
                        <i class="ti ti-settings"></i>
                    </a>
                </div>
            </div>
        </div>
        <div class="sidebar-inner slimscroll">
            <div id="sidebar-menu" class="sidebar-menu">
                <!-- inicio del menu -->
                <ul>
                    <li class="submenu-open">
                        <h6 class="submenu-hdr">Menú</h6>
                        <ul>
                            <li class="submenu">
                                <a href="javascript:void(0);"
                                   class="{{ Route::is([
                                       'tickets.index', 
                                       'tickets.create', 
                                       'tickets.archive', 
                                       'tickets.assing', 
                                       'tickets.show',
                                       'tickets.my.daily.job',
                                       'tickets.reassing'
                                   ]) ? 'active subdrop' : '' }}">
                                    <span><i class="ti ti-ticket mr-1"></i> Tickets</span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <ul>
                                    {{-- Accesibles para todos los usuarios --}}
                                    <li>
                                        <a href="{{ route('tickets.create') }}" class="{{ Route::is('tickets.create') ? 'selected_menu' : '' }}">Crear</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('tickets.index') }}" class="{{ Route::is('tickets.index') ? 'selected_menu' : '' }}">Mis tickets</a>
                                    </li>
                    
                                    @if(auth()->check())
                                        @php
                                            $roleId = auth()?->user()?->roles?->first()?->id ?? 0;
                                        @endphp

                                        @hasanyrole([
                                            App\Supports\Enums\RoleEnum::SISTEMAS->value,
                                            App\Supports\Enums\RoleEnum::JEFE_EQUIPO->value
                                        ])
                                            <li>
                                                <a href="{{ route('tickets.assing') }}" 
                                                class="{{ Route::is('tickets.assing') ? 'selected_menu' : '' }}">
                                                    Asignar
                                                </a>
                                            </li>
                                        @endhasanyrole
                
                                        @hasanyrole([
                                            App\Supports\Enums\RoleEnum::SISTEMAS->value,
                                            App\Supports\Enums\RoleEnum::JEFE_EQUIPO->value
                                        ])
                                            <li>
                                                <a href="{{ route('tickets.reassing') }}" 
                                                class="{{ Route::is('tickets.reassing') ? 'selected_menu' : '' }}">
                                                    Reasignar
                                                </a>
                                            </li>
                                        @endhasanyrole

                                        @hasanyrole([
                                            App\Supports\Enums\RoleEnum::SISTEMAS->value,
                                            App\Supports\Enums\RoleEnum::JEFE_EQUIPO->value,
                                            App\Supports\Enums\RoleEnum::ENCARGADO->value
                                        ])
                                            <li>
                                                <a href="{{ route('tickets.my.daily.job') }}" 
                                                class="{{ Route::is('tickets.my.daily.job') ? 'selected_menu' : '' }}">
                                                    Mi trabajo diario
                                                </a>
                                            </li>
                                        @endhasanyrole
                                        
                                        @hasanyrole([
                                            App\Supports\Enums\RoleEnum::SISTEMAS->value,
                                            App\Supports\Enums\RoleEnum::JEFE_EQUIPO->value,
                                            App\Supports\Enums\RoleEnum::ENCARGADO->value
                                        ])
                                            <li>
                                                <a href="{{ route('tickets.archive') }}" 
                                                class="{{ Route::is('tickets.archive') ? 'selected_menu' : '' }}">
                                                    Archivo
                                                </a>
                                            </li>
                                        @endhasanyrole
                                    @endif
                                </ul>
                            </li>
                        </ul>
                    </li>

                    @if(auth()->check())
                        @hasanyrole([
                            App\Supports\Enums\RoleEnum::SISTEMAS->value,
                            App\Supports\Enums\RoleEnum::JEFE_EQUIPO->value,
                            App\Supports\Enums\RoleEnum::ENCARGADO->value
                        ])
                            <li class="submenu-open">
                                <ul>
                                    <li class="submenu">
                                        <a href="javascript:void(0);"
                                        class="{{ Route::is([
                                            'reports.index',
                                            'reports.index.service',
                                            'reports.index.users_assings',
                                        ]) ? 'active subdrop' : '' }}">
                                            <i class="ti ti-chart-pie fs-16 me-2"></i>
                                            <span>Reportes</span>
                                            <span class="menu-arrow"></span>
                                        </a>
                                        <ul>
                                            <li>
                                                <a href="{{ route('reports.index') }}"
                                                class="{{ Route::is('reports.index') ? 'selected_menu' : '' }}">Categorías</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('reports.index.service') }}"
                                                class="{{ Route::is('reports.index.service') ? 'selected_menu' : '' }}">Servicios</a>
                                            </li>
                                            <li>
                                                <a href="{{ route('reports.index.users_assings') }}"
                                                class="{{ Route::is('reports.index.users_assings') ? 'selected_menu' : '' }}">Encargado</a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="{{ Request::is('product-list', 'product-details', 'edit-product') ? 'active' : '' }}">
                                        <a href="{{ route('tickets.my.team') }}">
                                            <i class="ti ti-users fs-16 me-2"></i>
                                            <span>Mi equipo</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        @endhasanyrole
                    @endif

                    {{-- @if(auth()->check())
                        @hasanyrole([
                            App\Supports\Enums\RoleEnum::SISTEMAS->value,
                            App\Supports\Enums\RoleEnum::JEFE_EQUIPO->value,
                            App\Supports\Enums\RoleEnum::ENCARGADO->value
                        ])
                         <li class="submenu-open">
                            <ul>
                                <li class="submenu">
                                    <a href="javascript:void(0);"
                                       class="">
                                        <i class="ti ti-archive fs-16 me-2"></i>
                                        <span>Catálogos</span>
                                        <span class="menu-arrow"></span>
                                    </a>
                                    <ul>
                                        <li><a href="#">Categorías</a></li>
                                        <li><a href="#">Etiquetas</a></li>
                                        <li><a href="#">Servicios</a></li>
                                        <li><a href="#">Operadores</a></li>
                                    </ul>
                                </li>
                            </ul>
                         </li>
                        @endhasanyrole
                    @endif --}}
                </ul>
                <!-- end menu -->
            </div>
        </div>
    </div>
    <!-- /Sidebar -->