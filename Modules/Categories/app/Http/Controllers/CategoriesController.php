<?php

namespace Modules\Categories\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
use Modules\Categories\Models\LogActionsCategory;
use Modules\Categories\Models\TicketCategory;
use Modules\Categories\Services\TicketCategoryService;

class CategoriesController extends Controller
{
    public function __construct(
        private readonly TicketCategoryService $service
    ) {
        
    }

    public function getCategoriesByTeam(Request $request)
    {
        try {

            $data = $this->service->getCategoriesByTeam($request);

            return response()->json([
               'data' => $data
            ], 200);

        } catch (\Throwable $th) {

            \Log::info($th->getMessage());

            return response()->json([
               'message' => 'Ocurrio un error durante la obtención de las categorias'
            ],500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = User::with('teams')->find(Auth::user()->id);
        $user_team_id = $user->teams?->first()?->id ?? 0;

        $categories = TicketCategory::with([
            'creator:id,first_name,last_name', 
            'services:id,category_id,name',
            'logs_actions'
            ])
            ->where('team_id', $user_team_id)
            ->orderByDesc('id')
            ->simplePaginate(8);

        // Transformamos los elementos para aplanar la estructura manteniedo el tipo Paginated
        $categories->getCollection()->transform(function ($category) {
            $category->first_name = $category->creator?->first_name;
            $category->last_name = $category->creator?->last_name;
            // Creamos la propiedad service_name o una lista formateada
            $category->service_list = $category->services->pluck('name')->implode(','); 

            //Mapeo los logs
            $category->formatted_logs = $category->logs_actions->map(function ($log) {
                $userName = $log->user 
                    ? trim("{$log->user->first_name} {$log->user->last_name}")
                    : 'Usuario';

                // Formato: "Miércoles 04 de Octubre del 2023 a las 12:14 pm"
                $dateFormatted = ucfirst($log->created_at->locale('es')->isoFormat('dddd DD [de] MMMM [del] YYYY [a las] hh:mm a'));

                $actionText = $log->message ?? 'realizó un cambio en esta categoría';

                return [
                    'user' => $userName,
                    'message' => $actionText,
                    'date' => $dateFormatted,
                    'full_text' => "{$userName} {$actionText} el {$dateFormatted}"
                ];
            });
            return $category;
        });

        return view('categories::index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('categories::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $record = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color'       => 'nullable|string|max:200',
        ]);

        do {
            $uid = 'CAT' . strtoupper(Str::random(5));
        } while (TicketCategory::where('uid', $uid)->exists());

        //Buscar el team id del usuario 
        $user = User::with('teams')->find(Auth::user()->id);

        if (!$user) {
            throw new InvalidArgumentException("Usuario invalido o no encontrado en la BD");
        }

        $user_team_id = $user?->teams?->first()?->id ?? null;

        $record['uid']           = $uid;
        $record['department_id'] = auth()->user()->department_id; 
        $record['team_id']       = $user_team_id; 
        $record['created_by'] = $user->id;

        $category = TicketCategory::create($record);

        //Si se creo la categoria
        if ($category) {
            //Guardar log
            LogActionsCategory::create([
                'category_id'   => $category->id,
                'user_id'       => $user->id,
                'resource_name' => 'store',
                'section_name'  => 'Agregar Categoría',
                'message'       =>  ($user->first_name ?? '') . ' ' . ($user->last_name ?? 'Un empleado') 
                                    . ' creó esta categoría el ' 
                                    . (\Carbon\Carbon::parse($category?->created_at)->translatedFormat('l d \d\e F \d\e\l Y \a \l\a\s h:i a')),
                'values'        => $category->toArray(),
            ]);
        }

        return response()->json([
            'message'  => 'Categoría creada con éxito',
            'category' => $category
        ], 201);
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('categories::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('categories::edit');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'color'       => 'nullable|string|max:200',
        ]);

        try {
            $user = Auth::user();
            $category = TicketCategory::findOrFail($id);

            $oldStatus = (int) $category->status;

            $category->name        = $validatedData['name'];
            $category->description = $validatedData['description'];
            $category->color       = $validatedData['color'] ?? '#C4C4C4'; // Valor de resguardo por defecto
            $category->status      = $request?->status ?? 0;
            $category->save();

            $categoryStatus = $category->status;


            //Guardar log edicion
            LogActionsCategory::create([
                'category_id'   => $category->id,
                'user_id'       => $user->id,
                'resource_name' => 'update',
                'section_name'  => 'Editar Categoría',
                'message'       =>  ($user->first_name ?? '') . ' ' . ($user->last_name ?? 'Un empleado') 
                                    . ' editó esta categoría el ' 
                                    . (\Carbon\Carbon::now()->translatedFormat('l d \d\e F \d\e\l Y \a \l\a\s h:i a')),
                'values'        => $category->toArray(),
            ]);

            $aditionalAction = $oldStatus !== $categoryStatus;

            if ($aditionalAction) {
                 //Guardar log activar/desactivar
                 $action = match ($categoryStatus) {
                    0 => 'desactivo',
                    1 => 'activó',
                 };

                LogActionsCategory::create([
                    'category_id'   => $category->id,
                    'user_id'       => $user->id,
                    'resource_name' => 'update',
                    'section_name'  => $action,
                    'message'       =>  ($user->first_name ?? '') . ' ' . ($user->last_name ?? 'Un empleado') 
                                        .' '. $action .' esta categoría el ' 
                                        . (\Carbon\Carbon::now()->translatedFormat('l d \d\e F \d\e\l Y \a \l\a\s h:i a')),
                    'values'        =>  [
                        'status' => $categoryStatus 
                    ],
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'La categoría ha sido actualizada con éxito.'
            ], 200);

        } catch (\Exception $e) {
            \Log::info($e);
            
            return response()->json([
                'success' => false,
                'message' => 'No se pudieron guardar los cambios.'
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
