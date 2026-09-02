<?php

namespace Modules\Tickets\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Traits\HelpDeskUtils;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Tickets\Http\Requests\StoreTicketRequest;
use Modules\Tickets\Services\TicketService;

class TicketsController extends Controller
{
    use HelpDeskUtils;

    const SUPPORT_DEPARTMENT = 2;

    public function __construct(
        private readonly TicketService $service
    )
    {
        
    }

    public function updateStatus(Request $request)
    {
        try {

            $result = $this->service->updateStatus($request);

            return response()->json([
                'result' => $result,
            ], 200);

        } catch (\Throwable $th) {
            \Log::info($th->getMessage());

             return response()->json([
                'message' => 'Ocurrió un error al actualizar el estatus del ticket.'
            ], 500);
        }
    }
    
    /**
     * Ruta para vista de prueba arquitectura modular
     * Test
     */
    public function test()
    {
        return view('tickets::test.test');
    }

    public function getDetailsCreateForm()
    {
        try {

            $types = $this->service->getTicketsTypes();
            $priorities = $this->service->getAllPriorities();

            return response()->json([
                'ticket_types' => $types,
                'ticket_priorities' => $priorities
            ], 200);

        } catch (\Throwable $th) {
            \Log::info($th->getMessage());

             return response()->json([
                'message' => 'Ocurrio un error al recuperar los demás detalles del formulario'
            ], 500);
        }
    }

    public function getTicketsByUserStatus(Request $request)
    {
        try {
            $data = $this->service->getDataIndexCard($request);

            return response()->json([
                'data' => $data
            ], 200);

        } catch (\Throwable $th) {
            \Log::info($th->getMessage());

             return response()->json([
                'message' => 'Ocurrio un error al recuperar los tickets'
            ], 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $dto = $this->service->getDetailsIndex();
       
        return view('tickets::index', compact('dto'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $department_session_id = Auth::user()->department_id;
        return view('tickets::create', compact('department_session_id'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTicketRequest $request) {
        try {
            
            $this->service->saveTicket($request);

            return response()->json([
                'message' => 'Se ha creado con éxito el ticket.'
            ], 200);

        } catch (\Throwable $th) {
            \Log::info($th->getMessage());

             return response()->json([
                'message' => 'Ocurrio un error al crear el ticket, pruebe más tarde'
            ], 500);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        if (!view()->exists('tickets::show')) {
            abort(404, 'La vista de este ticket aún no está disponible.');
        }

        $user = Auth::user();
        $relations = [
                      'ticketService.category', 
                      'priority', 
                      'status', 
                      'url', 
                      'attachments',
                      'assignees'
                      ];
        $full_name =  sprintf(
             '%s %s',
              $user?->first_name,
              $user?->last_name
        );

        $ticket = $this->service->getTicket($id, $relations);

        $initials = $this->getInitials($full_name);
        $attachments = $ticket?->attachments ?? collect();
        $UserAssignEntity = [];
        $assignedUserIds = $ticket?->assignees?->pluck('id')?->toArray() ?? [];
        $currentUserAssing = 0;

        if (!empty($assignedUserIds) && isset($assignedUserIds[0])) {
           $currentUserAssing = $assignedUserIds[0];
           $UserAssignEntity = $ticket?->assignees[0]?->toArray() ?? [];
        }

        $supportUsers = User::where('department_id', self::SUPPORT_DEPARTMENT)
        ->where('active', 1)
        ->select('id', 'first_name', 'last_name', 'email')
        ->get();

        $supportUsers = $supportUsers->map(function($u) {
             $full_name =  sprintf(
                 '%s %s',
                  $u?->first_name,
                  $u?->last_name
            );

            $u->initials = $this->getInitials($full_name);

            return $u;
        });

        return view('tickets::show', compact(
        'user', 
        'initials', 
        'full_name',
        'ticket',
        'attachments',
        'supportUsers',
        'currentUserAssing',
        'UserAssignEntity'
        ));
    }

    public function assingUserTicket(Request $request)
    {
        try {
                $result = $this->service->assignUser($request);

                return response()->json([
                    'data' => $result,
                ], 200);

           } catch (\Throwable $th) {
               \Log::info($th);

               return response()->json([
                    'message' => 'No se pudo asignar al usuario, pruebe más tarde.',
               ], 500);
           }
    }

    public function updateOrSaveObservations(Request $request)
    {
       try {
            
            $entity = $this->service->saveObservations($request);

            return response()->json([
                'description_observation_record' => $entity?->description ?? '',
            ], 200);

       } catch (\Throwable $th) {
           \Log::info($th);

           return response()->json([
                'message' => 'No se pudo guardar la observación, pruebe más tarde.',
           ], 500);
       }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('tickets::edit');
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
