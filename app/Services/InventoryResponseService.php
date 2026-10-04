<?php

namespace App\Services;

use App\Models\Antenna;
use App\Models\Device;
use App\Models\Form;
use App\Models\Location;
use App\Models\Response;
use App\Models\ResponseValue;
use App\Models\Topology;
use App\Models\Upload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InventoryResponseService
{
    public function saveResponse(Request $request, Form $form): Response
    {
        return DB::transaction(function () use ($request, $form) {
            $code = ResponseCodeGenerator::generate($form->code_prefix ?? 'INV-KAL');

            // 1. Calculate Device, Antenna & Client Totals
            $devicesInput = $request->input('devices', []);
            $antennasInput = $request->input('antennas', []);

            $totalDevices = 0;
            foreach ($devicesInput as $dev) {
                $totalDevices += (int) ($dev['quantity'] ?? 1);
            }

            $totalAntennas = count($antennasInput);
            $totalClients = 0;
            foreach ($antennasInput as $ant) {
                $totalClients += (int) ($ant['client_count'] ?? 0);
            }

            // 2. Create Response Master Record
            $response = Response::create([
                'form_id' => $form->id,
                'response_code' => $code,
                'location_name' => $request->input('instance_name', 'Lokasi Partner'),
                'regency' => $request->input('regency', '-'),
                'province' => $request->input('province', 'Kalimantan Timur'),
                'pic_name' => $request->input('pic_name', '-'),
                'pic_phone' => $request->input('pic_phone', '-'),
                'total_devices' => $totalDevices,
                'total_antennas' => $totalAntennas,
                'total_clients' => $totalClients,
                'status' => 'submitted',
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
                'submitted_at' => now(),
            ]);

            // 3. Save Location & Access Details
            Location::create([
                'response_id' => $response->id,
                'instance_name' => $request->input('instance_name'),
                'address' => $request->input('address'),
                'regency' => $request->input('regency'),
                'province' => $request->input('province'),
                'pic_name' => $request->input('pic_name'),
                'pic_position' => $request->input('pic_position'),
                'pic_phone' => $request->input('pic_phone'),
                'pic_email' => $request->input('pic_email'),
                'distance_km' => $request->input('distance_km'),
                'distance_unit' => $request->input('distance_unit', 'km'),
                'access_mode' => $request->input('access_mode'),
                'road_condition' => $request->input('road_condition'),
                'vehicle_type' => $request->input('vehicle_type'),
                'travel_time' => $request->input('travel_time'),
                'latitude' => $request->input('latitude'),
                'longitude' => $request->input('longitude'),
                'access_notes' => $request->input('access_notes'),
            ]);

            // 4. Save Topology
            Topology::create([
                'response_id' => $response->id,
                'topology_type' => $request->input('topology_type', 'Star'),
                'description' => $request->input('topology_description'),
                'notes' => $request->input('topology_notes'),
            ]);

            // 5. Save Network Devices
            foreach ($devicesInput as $index => $deviceData) {
                if (!empty($deviceData['device_type'])) {
                    Device::create([
                        'response_id' => $response->id,
                        'device_type' => $deviceData['device_type'],
                        'brand' => $deviceData['brand'] ?? null,
                        'model' => $deviceData['model'] ?? null,
                        'quantity' => (int) ($deviceData['quantity'] ?? 1),
                        'specs' => $deviceData['specs'] ?? null,
                        'condition' => $deviceData['condition'] ?? 'Baik',
                        'notes' => $deviceData['notes'] ?? null,
                        'sort_order' => $index + 1,
                    ]);
                }
            }

            // 6. Save Antenna & Client Data
            $maxClientsPerAnt = $form->max_clients_per_antenna ?? 25;
            foreach ($antennasInput as $index => $antData) {
                $antennaNum = $index + 1;
                $antennaCode = $antData['antenna_code'] ?? "Antena {$antennaNum}";

                Antenna::create([
                    'response_id' => $response->id,
                    'antenna_code' => $antennaCode,
                    'brand_model' => $antData['brand_model'] ?? null,
                    'frequency' => $antData['frequency'] ?? null,
                    'install_location' => $antData['install_location'] ?? null,
                    'client_count' => (int) ($antData['client_count'] ?? 0),
                    'max_clients' => $maxClientsPerAnt,
                    'notes' => $antData['notes'] ?? null,
                    'sort_order' => $index + 1,
                ]);
            }

            // 7. Save Dynamic Response Values
            $allFields = $form->fields;
            foreach ($allFields as $field) {
                if ($request->has($field->name)) {
                    $val = $request->input($field->name);
                    if (is_array($val)) {
                        $val = json_encode($val, JSON_UNESCAPED_UNICODE);
                    }
                    ResponseValue::create([
                        'response_id' => $response->id,
                        'field_id' => $field->id,
                        'field_name' => $field->name,
                        'value' => $val,
                    ]);
                }
            }

            // 8. Handle File Uploads (Laravel Storage)
            $uploadFields = [
                'topology_file' => 'topology',
                'network_condition_photo' => 'photo',
                'foto_lokasi' => 'photo',
                'foto_perangkat' => 'photo',
                'foto_antena' => 'photo',
                'foto_modem' => 'photo',
                'foto_router' => 'photo',
                'foto_ap' => 'photo',
                'foto_switch' => 'photo',
                'foto_instalasi' => 'photo',
                'foto_kabel' => 'photo',
            ];

            foreach ($uploadFields as $fieldName => $category) {
                if ($request->hasFile($fieldName)) {
                    $file = $request->file($fieldName);
                    if ($file->isValid()) {
                        $uuid = (string) Str::uuid();
                        $ext = $file->getClientOriginalExtension();
                        $filename = "{$uuid}.{$ext}";
                        $path = $file->storeAs("uploads/{$response->response_code}", $filename, 'public');

                        Upload::create([
                            'response_id' => $response->id,
                            'field_name' => $fieldName,
                            'category' => $category,
                            'original_name' => $file->getClientOriginalName(),
                            'filename' => $filename,
                            'filepath' => $path,
                            'mime_type' => $file->getClientMimeType(),
                            'file_size' => $file->getSize(),
                        ]);
                    }
                }
            }

            return $response;
        });
    }
}
