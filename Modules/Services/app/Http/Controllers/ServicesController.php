<?php

namespace Modules\Services\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Modules\Services\Services\GetServices;

class ServicesController extends Controller
{

    public function getServicesByCategory(Request $request, GetServices $getServices)
    {
       try {

         $data = $getServices($request);

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
    public function index()
    {
        return view('services::index');
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
    public function store(Request $request) {}

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
    public function update(Request $request, $id) {}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {}
}
