<?php

namespace Modules\User\app\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Modules\User\app\Services\UserService;

class UserController extends Controller
{
    public function __construct(
        private readonly UserService $service,
    )
    {
        
    }

    public function getRoles()
    {
        try {

            $roles = $this->service->getRoles();

            return response()->json([
                'roles' => $roles,
                'current_rol' => Auth::user()->roles->first()
            ], 200);

        } catch (\Throwable $th) {
            \Log::info('Excepción producida: '. $th);

            return response()->json([
                'message' => 'Ocurrió un error al guardar el rol; prueba más tarde.'
            ], 500);

        }
    }

    /**
     * Actualizar el rol en sesion
     */
    public function changeRol(Request $request)
    {
       try {

        //Guardar rol nuevo
        $this->service->changeProcessRole($request);
        
        return response()->json([
            'message' => ' El rol se ha actualizado exitosamente.'
        ], 201);

       } catch (\Throwable $th) {
         
        \Log::info('Excepción producida: '. $th);

        return response()->json([
            'message' => 'Ocurrió un error al guardar el rol; prueba más tarde.'
        ], 500);

       }
    }

    public function getMembers()
    {
        try {
            $membersCtx = $this->service->getCurrentMembers();

            $members = $this->service->getCollectionMembersDto(
                $membersCtx
                );

            return response($members);

        } catch (\Throwable $th) {
            
            return response([
                'message' => 'Ocurrio un error al obtener a los miembros del equipo, intente más tarde.'
            ], 500);
        }
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
     * Obtener usuarios por el equipo id
     */
    public function getUsersByTeam(Request $request)
    {
        try {

            $users = $this->service->getUsersByTeam($request);

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
