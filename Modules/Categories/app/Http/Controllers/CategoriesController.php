<?php

namespace Modules\Categories\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use InvalidArgumentException;
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

        $categories = DB::table('tickets_categories as c')
                        ->leftJoin('users as u', 'u.id', '=', 'c.created_by')
                        ->where('c.team_id', $user_team_id)
                        ->select(
                            'u.first_name',
                            'u.last_name',
                            'c.name',
                            'c.description',
                            'c.color',
                            'c.id',
                            'c.status',
                            'c.created_by',
                            'c.created_at',
                            )
                        ->orderByDesc('c.id')
                        ->simplePaginate(8);

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
            $category = TicketCategory::findOrFail($id);

            $category->name        = $validatedData['name'];
            $category->description = $validatedData['description'];
            $category->color       = $validatedData['color'] ?? '#C4C4C4'; // Valor de resguardo por defecto
            $category->status      = $request?->status ?? 0;
            $category->save();

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
