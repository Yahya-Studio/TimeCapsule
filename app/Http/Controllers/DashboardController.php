<?php

namespace App\Http\Controllers;

use App\Services\CapsuleService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Show the authenticated user dashboard.
     */
    public function index(Request $request, CapsuleService $service): View
    {
        $stats = $service->getDashboardStats($request->user());

        return view('dashboard', [
            'user' => $request->user(),
            'stats' => $stats,
        ]);
    }
}
