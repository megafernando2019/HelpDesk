<?php

namespace Modules\Reports\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Modules\Reports\Services\ReportService;

class ReportsController extends Controller
{
    public function __construct(
        private readonly ReportService $service
    )
    {
        
    }

    public function getDataSummaryByModule(
        Request $request
    )
    {
        $ctx = $this->service->getSummaryReportsModule($request);

        $summary = $this->service->calculateMetrics($ctx);

        return response()->json($summary, 200, [], JSON_UNESCAPED_UNICODE);
    }

    /**
     * Se usara el metodo index para la vista de categoria en reportes
     */
    public function index()
    {

        $user = User::with('teams')->find(Auth::user()->id);
        $user_team_id = $user->teams?->first()?->id ?? 0;
        return view('reports::category-reports', compact(
            'user_team_id'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('reports::create');
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
        return view('reports::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('reports::edit');
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
