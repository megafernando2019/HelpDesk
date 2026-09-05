<?php

namespace Modules\Categories\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        return view('categories::index');
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
    public function store(Request $request) {}

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
