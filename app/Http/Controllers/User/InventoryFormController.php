<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\SubmitInventoryResponseRequest;
use App\Models\Form;
use App\Models\Response;
use App\Services\InventoryResponseService;
use Illuminate\Http\Request;

class InventoryFormController extends Controller
{
    protected InventoryResponseService $inventoryService;

    public function __construct(InventoryResponseService $inventoryService)
    {
        $this->inventoryService = $inventoryService;
    }

    /**
     * Show Public Inventory Form for Kalimantan Partners
     */
    public function showForm()
    {
        $form = Form::with(['sections.fields.optionItems'])
            ->where('is_active', true)
            ->first();

        if (!$form) {
            // Fallback default form structure
            $form = new Form([
                'title' => 'FORM INVENTARIS JARINGAN PARTNER KALIMANTAN',
                'description' => 'Formulir pendataan dan inventarisasi infrastruktur jaringan partner Life Solution Connection (STARKINK) di wilayah Kalimantan.',
                'max_clients_per_antenna' => 25,
            ]);
        }

        $regenciesKalimantan = [
            'Kalimantan Timur' => ['Balikpapan', 'Samarinda', 'Bontang', 'Kutai Kartanegara', 'Kutai Timur', 'Kutai Barat', 'Paser', 'Penajam Paser Utara', 'Berau', 'Mahakam Ulu'],
            'Kalimantan Selatan' => ['Banjarmasin', 'Banjarbaru', 'Banjar', 'Tanah Laut', 'Tanah Bumbu', 'Kotabaru', 'Barito Kuala', 'Tapin', 'Hulu Sungai Selatan', 'Hulu Sungai Tengah', 'Hulu Sungai Utara', 'Tabalong', 'Balangan'],
            'Kalimantan Tengah' => ['Palangka Raya', 'Kotawaringin Barat', 'Kotawaringin Timur', 'Kapuas', 'Barito Selatan', 'Barito Utara', 'Katingan', 'Seruyan', 'Sukamara', 'Lamandau', 'Gunung Mas', 'Pulang Pisau', 'Murung Raya', 'Barito Timur'],
            'Kalimantan Barat' => ['Pontianak', 'Singkawang', 'Kuburaya', 'Mempawah', 'Sambas', 'Bengkayang', 'Landak', 'Sanggau', 'Sekadau', 'Sintang', 'Melawi', 'Kapuas Hulu', 'Kayong Utara', 'Ketapang'],
            'Kalimantan Utara' => ['Tanjung Selor', 'Tarakan', 'Bulungan', 'Malinau', 'Nunukan', 'Tana Tidung'],
        ];

        $topologyOptions = [
            'Star' => 'Star (Bintang)',
            'Tree' => 'Tree (Pohon)',
            'Mesh' => 'Mesh (Jaring)',
            'Point to Point' => 'Point to Point (PTP)',
            'Point to Multipoint' => 'Point to Multipoint (PTMP)',
            'Lainnya' => 'Lainnya',
        ];

        $deviceTypeOptions = [
            'Modem / ONT',
            'Router',
            'Switch',
            'Access Point (AP)',
            'Antena',
            'CPE / Bridge',
            'PoE Injector',
            'UPS / Power',
            'Kabel UTP',
            'Modem / Router Internet',
            'Perangkat lainnya',
        ];

        return view('user.form', compact('form', 'regenciesKalimantan', 'topologyOptions', 'deviceTypeOptions'));
    }

    /**
     * Store Inventory Response Submitted by Partner
     */
    public function submitForm(SubmitInventoryResponseRequest $request)
    {
        $form = Form::where('is_active', true)->first();
        if (!$form) {
            $form = Form::create([
                'title' => 'FORM INVENTARIS JARINGAN PARTNER KALIMANTAN',
                'slug' => 'inventaris-kalimantan',
                'code_prefix' => 'INV-KAL',
                'max_clients_per_antenna' => 25,
            ]);
        }

        $response = $this->inventoryService->saveResponse($request, $form);

        return redirect()->route('form.success', ['code' => $response->response_code])
            ->with('success', 'Formulir inventaris berhasil dikirim.');
    }

    /**
     * Show Confirmation Page with Response Code
     */
    public function showSuccess(Request $request, string $code)
    {
        $response = Response::with(['location', 'devices', 'antennas', 'topology'])
            ->where('response_code', $code)
            ->firstOrFail();

        return view('user.success', compact('response'));
    }
}
