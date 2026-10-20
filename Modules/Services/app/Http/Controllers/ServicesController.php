<?php

namespace Modules\Services\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Categories\Models\TicketCategory;
use Modules\Services\Models\LogActionsService;
use Modules\Services\Models\TicketServiceEntity;
use Modules\Services\Services\CatalogService;
use Modules\Services\Services\GetServices;

class ServicesController extends Controller
{
    public function __construct(
        private readonly CatalogService $catalog_service
    )
    {
        
    }

    public function getServicesByCategory(Request $request)
    {
       try {

        $data = $this->catalog_service->getServicesByCategory($request);

        return response()->json([
            'data' => $data
        ], 200);

       } catch (\Throwable $th) {

         \Log::info($th->getMessage());

         return response()->json([
            'message' => 'Ocurrio un error al recuperar los servicios'
         ], 500);

       }
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = User::with('teams')->find(Auth::user()->id);
        $user_team_id = $user->teams?->first()?->id ?? 0;
        $categoryId = $request?->query('categoria') ?? null;
        //Traer todas las categorias del equipo para la asignacion del select
        $categorias = TicketCategory::where('team_id', $user_team_id)->get();
        $firstCategory = $categorias->isNotEmpty() ? $categorias->first() : null;
        //Si hay una query string agarra esa, si no toma el primer id de la categoria
        $queryParamCard = (int) ($categoryId ? $categoryId : $firstCategory?->id ?? null);

        $services = DB::table('tickets_services as s')
        ->join('tickets_categories as c', function($join) use ($user_team_id) {
            $join->on('c.id', '=', 's.category_id')
                 ->where('c.team_id', '=', $user_team_id);
        })
        ->leftJoin('users as u', 'u.id', '=', 's.created_by')
        ->select(
            'u.first_name',
            'u.last_name',
            's.id as service_id',           
            's.uid as service_uid',        
            's.name as service_name',
            's.description as service_description',
            's.status_id as service_status',
            's.template as service_template',
            's.color as color_service',
            's.created_at as service_created_at',
            'c.id as category_id',
            'c.name as category_name',
            'c.color as category_color'
        )
        ->when($queryParamCard, function ($q, $queryParamCard) {
            return $q->where('s.category_id', $queryParamCard);
        })  
        ->orderBy('s.id', 'desc')
        ->get();

        $serviceIds = $services->pluck('service_id');
        $logs = DB::table('log_actions_services')
            ->whereIn('service_id', $serviceIds)
            ->orderBy('id', 'desc')
            ->get()
            ->groupBy('service_id');

        $services->transform(function ($service) use ($logs) {
            $service->logs = $logs->get($service->service_id, collect());
            return $service;
        });

        return view('services::index', compact('services', 'categorias', 'queryParamCard'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('services::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'description'  => 'required|string',
            'category_id'  => 'required|exists:tickets_categories,id',
            'template'     => 'nullable|string',
            'color'        => 'nullable|string|max:30',
        ], [
            'name.required'        => 'El nombre del servicio es obligatorio.',
            'description.required' => 'La descripción es obligatoria.',
            'category_id.required'  => 'Debes seleccionar una categoría válida.',
            'category_id.exists'    => 'La categoría seleccionada no existe.',
        ]);

        $user = Auth::user();

        try {

             do {
                $uid = 'SRV' . strtoupper(Str::random(5));
            } while (TicketServiceEntity::where('uid', $uid)->exists());

            // Creación del registro
            $record = TicketServiceEntity::create([
                'created_by'    => auth()->id(),       
                'uid'           => $uid,        
                'category_id'   => $validated['category_id'],
                'department_id' => auth()->user()->department_id ?? null, 
                'status_id'     => 1,                             
                'name'          => $validated['name'],
                'description'   => $validated['description'],
                'template'      => $validated['template'] ?? null,
                'color'         => $validated['color'] ?? '#C4C4C4',
                'supervisor'    => 0,
            ]);

            if ($record) {
                LogActionsService::create([
                    'service_id'    => $record->id,
                    'user_id'       => $user->id,
                    'resource_name' => 'store',
                    'section_name'  => 'Crear Servicio',
                    'message'       => ($user->first_name ?? '') . ' ' . ($user->last_name ?? 'Un empleado') 
                                        . ' creó este servicio el ' 
                                        . (\Carbon\Carbon::now()->locale('es')->translatedFormat('l d \d\e F \d\e\l Y \a \l\s h:i a')),
                    'values'        => $record->toArray(),
                ]);
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'Servicio creado exitosamente.',
                'data'    => $record
            ], 201);

        } catch (\Exception $e) {
             \Log::info($e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Ocurrió un error al intentar guardar el servicio.'
            ], 500);
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('services::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('services::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string',
            'category_id' => 'required|exists:tickets_categories,id',
            'template'    => 'nullable|string',
            'color'       => 'nullable|string|max:30',
            'status_id'   => 'required|in:0,1',
        ], [
            'name.required'       => 'El nombre es obligatorio.',
            'description.required'=> 'La descripción es obligatoria.',
            'category_id.required'=> 'Selecciona una categoría válida.',
        ]);

        $user = Auth::user();

        try {
            $service = TicketServiceEntity::with('category')->findOrFail($id);
            $oldService = clone $service;
            $oldCategory = $oldService?->category?->name ?? '';

            $status = match ($validated['status_id']) {
                1 => (int) 1,
                0 => (int) 2,
                default => (int) 1
            };

            $service->name        = $validated['name'];
            $service->description = $validated['description'];
            $service->category_id = $validated['category_id'];
            $service->template    = $validated['template'] ?? null;
            $service->color       = $validated['color'] ?? '#C4C4C4';
            $service->status_id   = $status;
            $service->save();

            $serviceFresh = $service->fresh('category');
            $categoryNew = $serviceFresh?->category?->name;

            foreach ($validated as $key => $value) {
                      
                   switch ($key) {
                    case 'name':

                         if ($value !== $oldService->name) {
                            $details = sprintf(
                                'Detalle: Cambio el nombre [%s] por [%s]',
                                $oldService->name,
                                $value
                            );

                            LogActionsService::create([
                                'service_id'   => $service->id,
                                'user_id'       => $user->id,
                                'resource_name' => 'update',
                                'section_name'  => 'Editar Servicio',
                                'message'       =>  ($user->first_name ?? '') . ' ' . ($user->last_name ?? 'Un empleado') 
                                                    . ' editó este servicio el ' 
                                                    . (\Carbon\Carbon::now()->locale('es')->translatedFormat('l d \d\e F \d\e\l Y \a \l\a\s h:i a')) . ' '.
                                                    $details,
                                'values'        => $service->toArray(),
                            ]);
                         }
                            
                        break;
                    case 'description':
                        if ($value !== $oldService->description) {
                            $details = sprintf(
                                'Detalle: Cambio la descripción [%s] por [%s]',
                                $oldService->description ?? 'Sin descripción',
                                $value
                            );

                            LogActionsService::create([
                                'service_id'   => $service->id,
                                'user_id'       => $user->id,
                                'resource_name' => 'update',
                                'section_name'  => 'Editar Servicio',
                                'message'       =>  ($user->first_name ?? '') . ' ' . ($user->last_name ?? 'Un empleado') 
                                                    . ' editó este servicio el ' 
                                                    . (\Carbon\Carbon::now()->locale('es')->translatedFormat('l d \d\e F \d\e\l Y \a \l\a\s h:i a')) . ' '.
                                                    $details,
                                'values'        => $service->toArray(),
                            ]);
                        }
                    break;
                    case 'color':
                        if ($value !== $oldService->color) {
                            $details = sprintf(
                                'Detalle: Cambio el color [%s] por [%s]',
                                $oldService->color ?? 'Sin color',
                                $value
                            );

                            LogActionsService::create([
                                'service_id'   => $service->id,
                                'user_id'       => $user->id,
                                'resource_name' => 'update',
                                'section_name'  => 'Editar Servicio',
                                'message'       =>  ($user->first_name ?? '') . ' ' . ($user->last_name ?? 'Un empleado') 
                                                    . ' editó este servicio el ' 
                                                    . (\Carbon\Carbon::now()->locale('es')->translatedFormat('l d \d\e F \d\e\l Y \a \l\a\s h:i a')) . ' '.
                                                    $details,
                                'values'        => $service->toArray(),
                            ]);
                        }
                    break;
                    case 'category_id':
                        $categoryId = (int) $value;
                        if ($categoryId !== $oldService->category_id) {
                            
                            $details = sprintf(
                                'Detalle: Cambio la categoria [%s] por [%s]',
                                $oldCategory,
                                $categoryNew,
                            );

                            LogActionsService::create([
                                'service_id'   => $service->id,
                                'user_id'       => $user->id,
                                'resource_name' => 'update',
                                'section_name'  => 'Editar Servicio',
                                'message'       =>  ($user->first_name ?? '') . ' ' . ($user->last_name ?? 'Un empleado') 
                                                    . ' editó este servicio el ' 
                                                    . (\Carbon\Carbon::now()->locale('es')->translatedFormat('l d \d\e F \d\e\l Y \a \l\a\s h:i a')) . ' '.
                                                    $details,
                                'values'        => $service->toArray(),
                            ]);
                        }
                        break;
                        case 'template':
                            if ($value !== $oldService->template) {
                            
                                $details = sprintf(
                                    'Detalle: Cambio la plantilla [%s] por [%s]',
                                    $oldService->template,
                                    $value,
                                );

                                LogActionsService::create([
                                    'service_id'   => $service->id,
                                    'user_id'       => $user->id,
                                    'resource_name' => 'update',
                                    'section_name'  => 'Editar Servicio',
                                    'message'       =>  ($user->first_name ?? '') . ' ' . ($user->last_name ?? 'Un empleado') 
                                                        . ' editó este servicio el ' 
                                                        . (\Carbon\Carbon::now()->locale('es')->translatedFormat('l d \d\e F \d\e\l Y \a \l\a\s h:i a')) . ' '.
                                                        $details,
                                    'values'        => $service->toArray(),
                                ]);
                            }
                        break;
                        
                    default:
                        break;
                   }
            }

             $aditionalAction = $oldService->status_id !== $status;

            if ($aditionalAction) {
                 //Guardar log activar/desactivar
                 $action = match ($status) {
                    2 => 'desactivo',
                    1 => 'activó',
                    default => ''
                 };

                LogActionsService::create([
                    'service_id'   => $service->id,
                    'user_id'       => $user->id,
                    'resource_name' => 'update',
                    'section_name'  => $action,
                    'message'       =>  ($user->first_name ?? '') . ' ' . ($user->last_name ?? 'Un empleado') 
                                        .' '. $action .' este servicio el ' 
                                        . (\Carbon\Carbon::now()->locale('es')->translatedFormat('l d \d\e F \d\e\l Y \a \l\a\s h:i a')),
                    'values'        =>  [
                        'status' => $status 
                    ],
                ]);
            }

            return response()->json([
                'status'  => 'success',
                'message' => 'Servicio actualizado correctamente.',
                'data'    => $service
            ], 200);

        } catch (\Exception $e) {
            \Log::info($e->getMessage());

            return response()->json([
                'status'  => 'error',
                'message' => 'Ocurrió un error al actualizar el servicio.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
