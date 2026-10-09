<?php

namespace Modules\Services\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Modules\Categories\Models\TicketCategory;
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
        $categoryId = $request?->query('query_string_categoria') ?? 0;
        //Traer todas las categorias del equipo para la asignacion del select
        $categorias = TicketCategory::where('team_id', $user_team_id)->get();

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
            'c.name as category_name'
        )
        ->when($categoryId, function ($q, $categoryId) {
            return $q->where('s.category_id', $categoryId);
        })
        ->orderBy('s.id', 'desc')
        ->get();

        return view('services::index', compact('services', 'categorias'));
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

        try {

             do {
                $uid = 'SR' . strtoupper(Str::random(5));
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

        try {
            $service = TicketServiceEntity::findOrFail($id);

            $status = match ($validated['status_id']) {
                1 => (int) 1,
                0 => (int) 2,
                default => (int) 1
            };

            $service->update([
                'name'        => $validated['name'],
                'description' => $validated['description'],
                'category_id' => $validated['category_id'],
                'template'    => $validated['template'] ?? null,
                'color'       => $validated['color'] ?? '#C4C4C4',
                'status_id'   => $status,
            ]);

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
