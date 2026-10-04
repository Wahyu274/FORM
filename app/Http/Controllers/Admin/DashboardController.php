<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Response;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $today = now()->startOfDay();

        $stats = [
            'total_forms' => Response::count(),
            'forms_today' => Response::where('submitted_at', '>=', $today)->count(),
            'total_locations' => Response::distinct('location_name')->count('location_name'),
            'total_devices' => (int) Response::sum('total_devices'),
            'total_antennas' => (int) Response::sum('total_antennas'),
            'total_clients' => (int) Response::sum('total_clients'),
        ];

        $recentResponses = Response::with(['location', 'topology'])
            ->orderBy('submitted_at', 'desc')
            ->take(10)
            ->get();

        $regencyStats = Response::select('regency', DB::raw('count(*) as total'))
            ->groupBy('regency')
            ->orderBy('total', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentResponses', 'regencyStats'));
    }
}
