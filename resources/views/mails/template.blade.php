<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $subject ?? 'Notificación de Ticket' }}</title>
    <style>
        body {
            margin: 0;
            padding: 20px;
            background-color: #f4f5f9;
            font-family: Arial, Helvetica, sans-serif;
            color: #333333;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
        }
        .header {
            display: flex;
            align-items: center;
            margin-bottom: 25px;
        }
        .header-img {
            width: 75px;
            height: auto;
            margin-right: 15px;
        }
        .header-title {
            font-size: 20px;
            font-weight: bold;
            color: #1a202c;
            margin: 0 0 5px 0;
        }
        .header-subtitle {
            font-size: 14px;
            color: #4a5568;
            margin: 0;
        }
        .highlight {
            font-weight: bold;
        }
        .status-asignado { color: #6c5ce7; }
        .status-observacion { color: #2563eb; }
        .status-solucionado { color: #10b981; }

        /* Card de detalles */
        .details-card {
            background-color: #eef2ff;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
        }
        .details-title {
            font-size: 14px;
            font-weight: bold;
            color: #1e3a8a;
            margin-top: 0;
            margin-bottom: 15px;
        }
        .grid {
            width: 100%;
            border-collapse: collapse;
        }
        .grid td {
            width: 33.33%;
            vertical-align: top;
            padding: 6px 4px;
        }
        .detail-item {
            display: flex;
            align-items: flex-start;
        }
        .icon {
            width: 16px;
            height: 16px;
            margin-right: 6px;
            margin-top: 2px;
        }
        .label {
            font-size: 11px;
            color: #64748b;
            margin: 0;
        }
        .value {
            font-size: 12px;
            font-weight: bold;
            color: #1e293b;
            margin: 2px 0 0 0;
            word-break: break-word;
        }
        .badge-prioridad {
            display: inline-block;
            background-color: #fef08a;
            color: #854d0e;
            font-size: 11px;
            font-weight: bold;
            padding: 2px 8px;
            border-radius: 10px;
            margin-top: 2px;
        }

        /* Pie y botones */
        .footer-text {
            text-align: center;
            font-size: 13px;
            color: #64748b;
            margin-bottom: 20px;
        }
        .actions {
            text-align: center;
            margin-bottom: 25px;
        }
        .btn {
            display: inline-block;
            padding: 10px 22px;
            font-size: 13px;
            font-weight: bold;
            text-decoration: none;
            border-radius: 8px;
            margin: 0 5px;
        }
        .btn-primary {
            background-color: #0052cc;
            color: #ffffff;
        }
        .btn-outline {
            border: 1.5px solid #0052cc;
            color: #0052cc;
            background-color: transparent;
        }
        .copyright {
            text-align: right;
            font-size: 10px;
            color: #94a3b8;
            margin: 0;
        }
    </style>
</head>
<body>

    <div class="container">
        <!-- Encabezado con imagen dinámica según acción -->
        <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-bottom: 20px;">
            <tr>
                <td width="90" valign="top">
                    @if($type === 'assigned')
                        <img src="{{ asset('build/img/icons/mailer/tugui_asignar.png') }}" class="header-img" alt="Asignado">
                    @elseif($type === 'observation')
                        <img src="{{ asset('build/img/icons/mailer/tugui_agregar_observacion.png') }}" class="header-img" alt="Observación">
                    @elseif($type === 'solved')
                        <img src="{{ asset('build/img/icons/mailer/tugui_solucionado.png') }}" class="header-img" alt="Solucionado">
                    @elseif($type === 'create')
                        <img src="{{asset('build/img/icons/tugui_creacion.png')}}" class="header-img" alt="Creación del ticket">
                    @endif
                </td>
                <td valign="middle">
                    @if($type === 'assigned')
                        <h1 class="header-title">¡Hola {{ $recipientName }}!</h1>
                        <p class="header-subtitle">
                            Te informamos que el ticket <strong>{{ $ticket->title }}</strong> te fue <span class="highlight status-asignado">asignado</span></p>
                    @elseif($type === 'create')
                        <h1 class="header-title">¡Hola {{ $recipientName }}!</h1>
                        <p class="header-subtitle">
                         Te informamos que el ticket <strong>{{ $ticket->title }}</strong> fue <strong style="color: #0049fc;">creado</strong>
                        </p>
                    @elseif($type === 'observation')
                        <h1 class="header-title">¡Hola!</h1>
                        <p class="header-subtitle">Te informamos que fue <span class="highlight status-observacion">agregada una observación</span> al ticket <strong>{{ $ticket->title }}</strong></p>
                    @elseif($type === 'solved')
                        <h1 class="header-title">¡Hola {{ $recipientName }}!</h1>
                        <p class="header-subtitle">Te informamos que el ticket <strong>{{ $ticket->title }}</strong> fue <span class="highlight status-solucionado">solucionado</span></p>
                    @endif
                </td>
            </tr>
        </table>

        <!-- Card con detalles del ticket -->
        <div class="details-card">
            <h2 class="details-title">Detalles del ticket</h2>
            <table class="grid">
                <tr>
                    <!-- Columna 1 -->
                    <td>
                        <div class="detail-item">
                            <img src="{{ asset('build/img/icons/mailer/folio.png') }}" class="icon" alt="Folio">
                            <div>
                                <p class="label">Folio</p>
                                <p class="value">{{ $ticket->uid  }}</p>
                            </div>
                        </div>
                        <br>
                        <div class="detail-item">
                            <img src="{{ asset('build/img/icons/mailer/usuario.png') }}" class="icon" alt="Usuario">
                            <div>
                                <p class="label">
                                    @if($type === 'observation') Observación por: @elseif($type === 'solved') Encargado @else Usuario @endif
                                </p>
                                <p class="value">
                                    @if ($type === 'observation')
                                      {{ $userEmail}}
                                    @elseif ($type === 'solved')
                                      @php
                                        $assignedUser = $ticket?->assignees?->last() ?? null;
                                      @endphp
                                      {{sprintf(
                                        '%s %s',
                                         $assignedUser->first_name,
                                         $assignedUser->last_name
                                      )}} | {{$assignedUser->email}}  
                                    @else
                                      {{$ticket?->user?->email ?? ''}}
                                    @endif
                                    
                                </p>
                            </div>
                        </div>
                    </td>

                    <!-- Columna 2 -->
                    <td>
                        <div class="detail-item">
                            <img src="{{ asset('build/img/icons/mailer/categoria.png') }}" class="icon" alt="Categoría">
                            <div>
                                <p class="label">Categoría</p>
                                <p class="value">{{ $ticket?->ticketService?->category->name ?? '' }}</p>
                            </div>
                        </div>
                        <br>
                        <div class="detail-item">
                            <img src="{{ asset('build/img/icons/mailer/servicio.png') }}" class="icon" alt="Servicio">
                            <div>
                                <p class="label">Servicio</p>
                                <p class="value">{{ $ticket?->ticketService?->name ?? '' }}</p>
                            </div>
                        </div>
                    </td>

                    <!-- Columna 3 -->
                    <td>
                        <div class="detail-item">
                            <img src="{{ asset('build/img/icons/mailer/prioridad.png') }}" class="icon" alt="Prioridad">
                            <div>
                                @php
                                    $priority = strtolower($ticket?->priority?->name ?? 'baja');
    
                                    $badgeStyle = match($priority) {
                                        'media' => 'background-color: #ff9800; color: #ffffff;', // Naranja
                                        'alta' => 'background-color: #f44336; color: #ffffff;', // Rojo
                                        'muy alta' => 'background-color: #b71c1c; color: #ffffff;', // Rojo intenso
                                        default => 'background-color: #ffeb3b; color: #000000;', // Baja (Amarillo)
                                    };
                                @endphp
                                <p class="label">Prioridad</p>
                                <span class="badge-prioridad" style="{{ $badgeStyle }} padding: 2px 6px; border-radius: 4px; display: inline-block;">
                                    {{ ucfirst($ticket?->priority?->name ?? 'Baja') }}
                                </span>
                            </div>
                        </div>
                        <br>
                        <div class="detail-item">
                            <img src="{{ asset('build/img/icons/mailer/fecha.png') }}" class="icon" alt="Fecha">
                            <div>
                                <p class="label">
                                    @if($type === 'assigned') Fecha de asignación @elseif($type === 'observation') Fecha de observación @else Fecha de solución @endif
                                </p>
                                <p class="value">{{ now()->locale('es')->translatedFormat('d \d\e F Y, H:i') }} h</p>
                            </div>
                        </div>
                    </td>
                </tr>
            </table>
        </div>

        <!-- Mensaje de pie dinámico -->
        <p class="footer-text">
            @if($type === 'assigned')
                Revisa tu bandeja de "Mi trabajo diario" para ver más detalles y atender cuanto antes
            @elseif($type === 'observation')
                Consulta más información en los detalles del ticket
            @elseif($type === 'solved')
                Consulta más información en los detalles del ticket y ciérralo para concluir el proceso
            @elseif($type === 'create')
                Revisa tu bandeja de “Mis tickets” o los detalles del ticket para conocer información releavante
            @endif
        </p>

        <!-- Botones de Acción -->
        <div class="actions">
            @if($type === 'assigned')
                <a href="{{ route('tickets.my.daily.job') }}" class="btn btn-outline">Ir a Mi trabajo diario</a>
            @endif
            @if ($type === 'create')
                <a href="{{ route('tickets.index') }}" class="btn btn-outline">Ir a Mis tickets</a>
            @endif
            <a href="{{ route('tickets.show', $ticket->uid ) }}" class="btn btn-primary">Ver ticket</a>
        </div>

        <p class="copyright">Helpdesk {{ date('Y') }}. All rights reserved.</p>
    </div>

</body>
</html>