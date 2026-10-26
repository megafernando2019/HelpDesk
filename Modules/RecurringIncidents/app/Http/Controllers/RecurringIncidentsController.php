<?php

namespace Modules\RecurringIncidents\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\HelpDeskUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\Categories\Models\TicketCategory;
use Modules\Services\Models\TicketServiceEntity;
use Modules\Tickets\Support\Enums\TicketStatus;

class RecurringIncidentsController extends Controller
{
    use HelpDeskUtils;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $categorias_ids = [];

        if ($user) {
            $user->load('teams');
        }

        $teamIds = $user?->teams?->pluck('id')?->toArray() ?? [];

        //Traer integrantes del equipo del usuario en sesion
        $supportUsers = 
        DB::table('users as u')
        ->join('team_user as tu', 'u.id', '=', 'tu.user_id')
        ->whereIn('tu.team_id', $teamIds)
        ->where('u.active', 1)
        ->select(
            'u.id',
            'u.first_name',
            'u.last_name',
            'u.email'
        )
        ->distinct()
        ->get();

        $categorias = TicketCategory::whereIn('team_id', $teamIds)->get();

        if ($categorias->isNotEmpty()) {
            $categorias_ids = $categorias?->pluck('id')?->toArray() ?? [];
        }

        $servicios = TicketServiceEntity::whereIn('category_id', $categorias_ids)->get();

        $ctxStatus = DB::table('status')->get();

        return view('recurringincidents::index', compact('supportUsers', 'categorias', 'servicios', 'ctxStatus'));
    }

    public function getDataKpMetrics(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            $user->load('teams');
        }

        $teamIds = $user?->teams?->pluck('id')?->toArray() ?? [];

        $query = DB::table('tickets')
            ->select(
                'users.id as usuario_id',
                'users.first_name as first_name_user',
                'users.last_name as last_name_user',
                'tickets_categories.name as categoria',
                'tickets_services.id as servicio_id',
                'tickets_services.name as servicio',
                DB::raw('COUNT(tickets.id) as total_tickets')
            )
            // Los joins van primero para que las tablas estén disponibles en los filtros
            ->join('users', 'tickets.user_id', '=', 'users.id')
            ->join('tickets_services', 'tickets.ticket_service_id', '=', 'tickets_services.id')
            ->join('tickets_categories', 'tickets_services.category_id', '=', 'tickets_categories.id')
            // Filtrar por el equipo de la categoría correspondiente
            ->whereIn('tickets_categories.team_id', $teamIds)
            ->groupBy(
                'users.id', 
                'tickets_services.id', 
                'users.first_name', 
                'users.last_name', 
                'tickets_categories.name', 
                'tickets_services.name'
            )
            ->havingRaw('COUNT(tickets.id) >= 3');

        // Buscador General de Texto
        $query->when($request->filled('search'), function ($q) use ($request) {
            $search = $request->search;
            $q->where(function ($sub) use ($search) {
                $sub->where('users.first_name', 'like', "%{$search}%")
                    ->orWhere('users.last_name', 'like', "%{$search}%")
                    ->orWhere('tickets_categories.name', 'like', "%{$search}%")
                    ->orWhere('tickets_services.name', 'like', "%{$search}%");
            });
        });

        // Filtros individuales
        $query->when($request->filled('user_id'), fn($q) => $q->where('users.id', $request->user_id));
        $query->when($request->filled('category_id'), fn($q) => $q->where('tickets_categories.id', $request->category_id));
        $query->when($request->filled('service_id'), fn($q) => $q->where('tickets_services.id', $request->service_id));
        $query->when($request->filled('status_id'), fn($q) => $q->where('tickets.status_id', $request->status_id));

        // Filtro por Rango de Fechas
        if ($request->filled('date_start') && $request->filled('date_end')) {
            $query->whereBetween('tickets.created_at', [
                $request->date_start . ' 00:00:00', 
                $request->date_end . ' 23:59:59'
            ]);
        } else {
            $query->where('tickets.created_at', '>=', now()->subMonth()->startOfDay());
        }

        // Paginación para la tabla
        $reincidencias = (clone $query)->simplePaginate(7)
                                       ->appends($request->query());

        $metrics = DB::query()
            ->fromSub(clone $query, 'metrics_sub')
            ->selectRaw('
                COUNT(DISTINCT usuario_id) as countUser,
                COUNT(DISTINCT servicio_id) as countService,
                SUM(total_tickets) as countRowTickets
            ')
            ->first();

        $metricts = [
            'count_service'    => $metrics->countService ?? 0,
            'count_user'       => $metrics->countUser ?? 0,
            'count_row_tickets' => $metrics->countRowTickets ?? 0,
        ];

        return response()->json(compact('reincidencias', 'metricts'));
    }

    public function getTicketsByGroup(Request $request)
    {
        $usuarioId = $request->input('usuario_id');
        $servicioId = $request->input('servicio_id'); 
        $data = collect();

        $ticketsDetalle = DB::table('tickets')
            ->select(
                'tickets.id',
                'tickets.uid', 
                'tickets.title',
                'tickets.description', 
                'tickets.created_at',
                'tickets.status_id',
                'tickets.ticket_priority_id',
                'tickets_services.name as servicio',
                'tickets_categories.name as categoria',
                'users.first_name',
                'users.last_name',
                'users.email',
                'tickets_priorities.name as priority_name',
                'status.name as status_name',
                'users_assing.first_name as encargado_first_name',
                'users_assing.last_name as encargado_last_name'
            )
            ->join('users', 'tickets.user_id', '=', 'users.id')
            ->join('tickets_services', 'tickets.ticket_service_id', '=', 'tickets_services.id')
            ->join('tickets_categories', 'tickets_services.category_id', '=', 'tickets_categories.id')
            ->join('tickets_priorities', 'tickets_priorities.id', '=', 'tickets.ticket_priority_id')
            ->join('status', 'status.id', '=', 'tickets.status_id')
            // Usar leftJoin por si un ticket no tiene asignación y evitar que se oculte
            ->leftJoin('tickets_users_assignations', 'tickets_users_assignations.ticket_id', '=', 'tickets.id')
            ->leftJoin('users as users_assing', 'users_assing.id', '=', 'tickets_users_assignations.user_id')
            ->where('tickets.user_id', $usuarioId)
            ->where('tickets.ticket_service_id', $servicioId);

        // Aplicar el MISMO rango de fechas recibido del cliente (o por defecto el último mes)
        if ($request->filled('date_start') && $request->filled('date_end')) {
            $ticketsDetalle->whereBetween('tickets.created_at', [
                $request->date_start . ' 00:00:00', 
                $request->date_end . ' 23:59:59'
            ]);
        } else {
            $ticketsDetalle->where('tickets.created_at', '>=', now()->subMonth()->startOfDay());
        }

        $ticketsDetalle = $ticketsDetalle->orderBy('tickets.created_at', 'desc')->get();

        if ($ticketsDetalle->isNotEmpty()) {
            $data = $ticketsDetalle->map(function ($d) {
                $fullName = trim(sprintf('%s %s', $d->first_name, $d->last_name));
                $d->initials = $this->getInitials($fullName);

                $d->display_name_user_assing = sprintf(
                    '%s %s',
                    $d?->encargado_first_name ?? '',
                    $d?->encargado_last_name ?? 'Sin asignar'
                );

                $d->status_color = TicketStatus::getBadgeClass($d?->status_name ?? '');
                $d->status_icon = TicketStatus::getIcon($d?->status_name ?? '');

                return $d;
            });
        }
    
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('recurringincidents::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('recurringincidents::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('recurringincidents::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
