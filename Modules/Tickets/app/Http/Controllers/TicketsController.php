<?php

namespace Modules\Tickets\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Modules\Tickets\Services\TicketService;

class TicketsController extends Controller
{
    public function __construct(
        private readonly TicketService $service
    )
    {
        
    }
    
    /**
     * Ruta para vista de prueba arquitectura modular
     * Test
     */
    public function test()
    {
        return view('tickets::test.test');
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
        return view('tickets::create');
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
        if (!view()->exists('tickets::show')) {
            abort(404, 'La vista de este ticket aún no está disponible.');
        }

        return view('tickets::show');
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
