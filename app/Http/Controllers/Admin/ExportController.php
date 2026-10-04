<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Response;
use App\Services\ExportService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportExcel(Request $request)
    {
        $query = Response::with(['location', 'topology', 'devices', 'antennas']);
        $this->applyFilters($query, $request);

        $responses = $query->orderBy('submitted_at', 'desc')->get();
        return ExportService::toExcel($responses);
    }

    public function exportCsv(Request $request)
    {
        $query = Response::with(['location', 'topology', 'devices', 'antennas']);
        $this->applyFilters($query, $request);

        $responses = $query->orderBy('submitted_at', 'desc')->get();
        return ExportService::toCsv($responses);
    }

    private function applyFilters($query, Request $request)
    {
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('response_code', 'LIKE', "%{$search}%")
                  ->orWhere('location_name', 'LIKE', "%{$search}%")
                  ->orWhere('pic_name', 'LIKE', "%{$search}%")
                  ->orWhere('regency', 'LIKE', "%{$search}%");
            });
        }

        if ($request->filled('regency')) {
            $query->where('regency', $request->regency);
        }

        if ($request->filled('province')) {
            $query->where('province', $request->province);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('submitted_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('submitted_at', '<=', $request->date_to);
        }

        if ($request->filled('ids')) {
            $ids = explode(',', $request->ids);
            $query->whereIn('id', $ids);
        }
    }
}
