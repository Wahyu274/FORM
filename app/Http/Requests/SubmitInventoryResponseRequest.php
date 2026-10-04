<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitInventoryResponseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            // Section 1: Informasi Lokasi
            'instance_name' => 'required|string|max:255',
            'address' => 'required|string',
            'regency' => 'required|string|max:100',
            'province' => 'required|string|max:100',
            'pic_name' => 'required|string|max:255',
            'pic_position' => 'nullable|string|max:255',
            'pic_phone' => 'required|string|max:50',
            'pic_email' => 'nullable|email|max:255',

            // Section 2: Jarak & Akses Lokasi
            'distance_km' => 'required|numeric|min:0',
            'distance_unit' => 'nullable|string|max:10',
            'access_mode' => 'required|string|max:255',
            'road_condition' => 'required|string|max:255',
            'vehicle_type' => 'required|string|max:255',
            'travel_time' => 'nullable|string|max:100',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'access_notes' => 'nullable|string',

            // Section 3: Topologi Jaringan
            'topology_type' => 'required|string|max:100',
            'topology_description' => 'nullable|string',
            'topology_notes' => 'nullable|string',

            // Section 4: Dynamic Devices
            'devices' => 'nullable|array',
            'devices.*.device_type' => 'nullable|string|max:100',
            'devices.*.brand' => 'nullable|string|max:100',
            'devices.*.model' => 'nullable|string|max:100',
            'devices.*.quantity' => 'nullable|integer|min:1',
            'devices.*.specs' => 'nullable|string',
            'devices.*.condition' => 'nullable|string|max:100',

            // Section 5: Antena & Client
            'antennas' => 'nullable|array',
            'antennas.*.antenna_code' => 'nullable|string|max:100',
            'antennas.*.brand_model' => 'nullable|string|max:100',
            'antennas.*.frequency' => 'nullable|string|max:50',
            'antennas.*.install_location' => 'nullable|string|max:255',
            'antennas.*.client_count' => 'nullable|integer|min:0',

            // Section 7: File Uploads Validation
            'topology_file' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240', // 10MB
            'network_condition_photo' => 'nullable|file|mimes:jpg,jpeg,png|max:5120', // 5MB
            'foto_lokasi' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'foto_perangkat' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'foto_antena' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'foto_modem' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'foto_router' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'foto_ap' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'foto_switch' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'foto_instalasi' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
            'foto_kabel' => 'nullable|file|mimes:jpg,jpeg,png|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'instance_name.required' => 'Nama Instansi / Lokasi wajib diisi.',
            'address.required' => 'Alamat lengkap lokasi wajib diisi.',
            'regency.required' => 'Kabupaten / Kota wajib dipilih.',
            'province.required' => 'Provinsi wajib diisi.',
            'pic_name.required' => 'Nama PIC / Pengisi wajib diisi.',
            'pic_phone.required' => 'Nomor HP / WhatsApp wajib diisi.',
            'distance_km.required' => 'Jarak dari titik referensi wajib diisi.',
            'access_mode.required' => 'Akses menuju lokasi wajib diisi.',
            'road_condition.required' => 'Kondisi jalan wajib dipilih.',
            'vehicle_type.required' => 'Kendaraan yang dapat digunakan wajib diisi.',
            'topology_type.required' => 'Jenis topologi jaringan wajib dipilih.',
            'topology_file.mimes' => 'File topologi harus berupa gambar (JPG, JPEG, PNG) atau PDF.',
            'topology_file.max' => 'Ukuran file topologi maksimal 10 MB.',
            '*.max' => 'Ukuran foto maksimal 5 MB.',
        ];
    }
}
