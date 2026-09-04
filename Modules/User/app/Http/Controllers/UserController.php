<?php

namespace Modules\User\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\User\app\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $service
    )
    {
        
    }

    /**
     * Obtener usuarios por el departamento id
     */
    public function getUsersDepartment(Request $request)
    {
        try {

            $users = $this->service->getUsersByDepartmentId($request);

            return response()->json([
                'data' => $users
            ], 200);

        } catch (\Throwable $th) {
            \Log::info($th);

            return response()->json([
                'data' => 'Ocurrio un error al consultar los usuarios',
            ], 500);
        }
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('user::index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('user::create');
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
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('user::edit');
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
