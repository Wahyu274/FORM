<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResponseController extends Controller
{
    public function index(Request $request)
    {
        $query = Response::with(['location', 'topology', 'devices', 'antennas']);

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('response_code', 'LIKE', "%{$search}%")
                  ->orWhere('location_name', 'LIKE', "%{$search}%")
                  ->orWhere('pic_name', 'LIKE', "%{$search}%")
                  ->orWhere('regency', 'LIKE', "%{$search}%");
            });
        }

        // Regency Filter
        if ($request->filled('regency')) {
            $query->where('regency', $request->regency);
        }

        // Province Filter
        if ($request->filled('province')) {
            $query->where('province', $request->province);
        }

        // Status Filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->whereDate('submitted_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('submitted_at', '<=', $request->date_to);
        }

        $responses = $query->orderBy('submitted_at', 'desc')->paginate(15)->withQueryString();

        // Get filter dropdown options
        $regencies = Response::select('regency')->distinct()->pluck('regency');
        $provinces = Response::select('province')->distinct()->pluck('province');

        return view('admin.responses.index', compact('responses', 'regencies', 'provinces'));
    }

    public function show(Response $response)
    {
        $response->load([
            'location', 
            'topology', 
            'devices', 
            'antennas', 
            'uploads', 
            'values.field'
        ]);

        return view('admin.responses.show', compact('response'));
    }

    public function printPdf(Response $response)
    {
        $response->load([
            'location', 
            'topology', 
            'devices', 
            'antennas', 
            'uploads', 
            'values'
        ]);

        return view('admin.responses.pdf', compact('response'));
    }

    public function destroy(Response $response)
    {
        $code = $response->response_code;

        // Delete uploaded files
        foreach ($response->uploads as $upload) {
            Storage::disk('public')->delete($upload->filepath);
        }

        $response->delete();

        return redirect()->route('admin.responses.index')
            ->with('success', "Respon '{$code}' berhasil dihapus.");
    }
}
