<?php

namespace Modules\Categories\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
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
        $categories = DB::table('tickets_categories')->simplePaginate(8);

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
        $validated = $request->validate([
            'name'        => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
            'color'       => 'nullable|string|max:20',
        ]);

        do {
            $uid = 'CAT' . strtoupper(Str::random(5));
        } while (TicketCategory::where('uid', $uid)->exists());

        // 3. Asignar campos requeridos por la base de datos
        $validated['uid']           = $uid;
        $validated['department_id'] = auth()->user()->department_id; // Ajusta según la relación de tu User/Sesión
        $validated['team_id']       = auth()->user()->team_id ?? null; // Opcional

        $category = TicketCategory::create($validated);

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
     */
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
