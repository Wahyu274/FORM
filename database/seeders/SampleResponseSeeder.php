<?php

namespace Database\Seeders;

use App\Models\Antenna;
use App\Models\Device;
use App\Models\Form;
use App\Models\Location;
use App\Models\Response;
use App\Models\Topology;
use Illuminate\Database\Seeder;

class SampleResponseSeeder extends Seeder
{
    public function run(): void
    {
        $form = Form::first();
        if (!$form) return;

        $samples = [
            [
                'code' => 'INV-KAL-2026-00001',
                'instance_name' => 'PT Kalimantan Coal Resources - Site Samboja',
                'regency' => 'Kutai Kartanegara',
                'province' => 'Kalimantan Timur',
                'pic_name' => 'Budi Santoso',
                'pic_position' => 'Senior IT Field Specialist',
                'pic_phone' => '081255566778',
                'pic_email' => 'budi.santoso@kcr-mining.co.id',
                'address' => 'Jl. Poros Balikpapan-Samarinda KM 45, Samboja, Kutai Kartanegara',
                'distance_km' => 48.5,
                'access_mode' => 'Darat (Jalan Aspal)',
                'road_condition' => 'Bagus / Aspal Mulus',
                'vehicle_type' => 'Mobil Double Cabin 4WD',
                'travel_time' => '1 Jam 15 Menit',
                'lat' => -1.02345600,
                'long' => 116.98765400,
                'topology_type' => 'Star (Bintang)',
                'devices' => [
                    ['type' => 'Modem / ONT', 'brand' => 'Starlink', 'model' => 'Standard Actuated', 'qty' => 1, 'specs' => 'Dish Gen 2 + Router V2', 'cond' => 'Baik'],
                    ['type' => 'Router', 'brand' => 'MikroTik', 'model' => 'RB5009UG+S+IN', 'qty' => 1, 'specs' => '7x GbE, 1x 2.5G, 1x SFP+', 'cond' => 'Baik'],
                    ['type' => 'Switch', 'brand' => 'Ruijie', 'model' => 'RG-ES218GC-P', 'qty' => 2, 'specs' => '16-Port GbE Smart PoE Switch', 'cond' => 'Baik'],
                    ['type' => 'Access Point (AP)', 'brand' => 'Ruijie Reyee', 'model' => 'RG-RAP2260(E)', 'qty' => 4, 'specs' => 'Wi-Fi 6 AX3200 Indoor AP', 'cond' => 'Baik'],
                    ['type' => 'UPS / Power', 'brand' => 'ICA', 'model' => 'SE2000 2000VA', 'qty' => 1, 'specs' => 'Online UPS 2000VA / 1800W', 'cond' => 'Baik'],
                ],
                'antennas' => [
                    ['code' => 'Antena Main Basecamp', 'brand' => 'Ruijie Outdoor Sector', 'freq' => '5 GHz', 'location' => 'Tower Monopole 15m', 'clients' => 22, 'max' => 25],
                    ['code' => 'Antena Mess Karyawan', 'brand' => 'Ubiquiti LiteAP AC', 'freq' => '5 GHz', 'location' => 'Atap Gedung Mess 1', 'clients' => 19, 'max' => 25],
                ]
            ],
            [
                'code' => 'INV-KAL-2026-00002',
                'instance_name' => 'Klinik Medika Sehat - Muara Teweh',
                'regency' => 'Barito Utara',
                'province' => 'Kalimantan Tengah',
                'pic_name' => 'Ahmad Riza',
                'pic_position' => 'Kepala Unit IT',
                'pic_phone' => '082199887766',
                'pic_email' => 'riza@medikasehat.or.id',
                'address' => 'Jl. Jendral Sudirman No. 88, Muara Teweh, Barito Utara',
                'distance_km' => 120.0,
                'access_mode' => 'Kombinasi Darat & Sungai',
                'road_condition' => 'Rusak / Tanah Berlumpur',
                'vehicle_type' => 'Mobil SUV 4WD & Perahu Klotok',
                'travel_time' => '4 Jam 30 Menit',
                'lat' => -0.95432100,
                'long' => 114.89012300,
                'topology_type' => 'Point to Multipoint (PTMP)',
                'devices' => [
                    ['type' => 'Modem / ONT', 'brand' => 'Starlink High Performance', 'model' => 'Flat High Performance', 'qty' => 1, 'specs' => 'Enterprise Starlink Kit', 'cond' => 'Baik'],
                    ['type' => 'Router', 'brand' => 'MikroTik', 'model' => 'CCR2004-16G-2S+', 'qty' => 1, 'specs' => '16x GbE ports, 2x 10G SFP+', 'cond' => 'Baik'],
                    ['type' => 'Access Point (AP)', 'brand' => 'Ubiquiti', 'model' => 'U6-Pro', 'qty' => 3, 'specs' => 'Wi-Fi 6 Long Range AP', 'cond' => 'Baik'],
                ],
                'antennas' => [
                    ['code' => 'Antena PTMP Sektor Utara', 'brand' => 'Ubiquiti Rocket Prism 5AC', 'freq' => '5.8 GHz', 'location' => 'Tiang Galvanis 12m', 'clients' => 24, 'max' => 25],
                    ['code' => 'Antena PTMP Sektor Selatan', 'brand' => 'Ubiquiti Rocket Prism 5AC', 'freq' => '5.8 GHz', 'location' => 'Tiang Galvanis 12m', 'clients' => 25, 'max' => 25],
                    ['code' => 'Antena PTMP Sektor Timur', 'brand' => 'Ubiquiti LiteAP AC', 'freq' => '5.8 GHz', 'location' => 'Atap Gedung Utama', 'clients' => 12, 'max' => 25],
                ]
            ],
            [
                'code' => 'INV-KAL-2026-00003',
                'instance_name' => 'Basecamp Logistik Sawit Agro - Sambas',
                'regency' => 'Sambas',
                'province' => 'Kalimantan Barat',
                'pic_name' => 'Hendra Wijaya',
                'pic_position' => 'Estate IT Officer',
                'pic_phone' => '085344332211',
                'pic_email' => 'hendra.w@sawitagro.co.id',
                'address' => 'Kawasan Perkebunan Sawit Divisi II, Kecamatan Teluk Keramat, Sambas',
                'distance_km' => 85.2,
                'access_mode' => 'Darat (Jalan Tanah / Offroad)',
                'road_condition' => 'Ekstrem / Memerlukan 4WD',
                'vehicle_type' => 'Motor Trail & Mobil Offroad 4WD',
                'travel_time' => '3 Jam 00 Menit',
                'lat' => 1.34567800,
                'long' => 109.23456700,
                'topology_type' => 'Mesh (Jaring)',
                'devices' => [
                    ['type' => 'Modem / ONT', 'brand' => 'Starlink', 'model' => 'Standard Kit', 'qty' => 1, 'specs' => 'Gen 2 Motorized', 'cond' => 'Baik'],
                    ['type' => 'Router', 'brand' => 'MikroTik', 'model' => 'hEX S (RB760iGS)', 'qty' => 1, 'specs' => '5x GbE, 1x SFP', 'cond' => 'Baik'],
                    ['type' => 'Switch', 'brand' => 'TP-Link', 'model' => 'TL-SG1016PE', 'qty' => 1, 'specs' => '16-Port Gigabit Easy Smart PoE', 'cond' => 'Baik'],
                    ['type' => 'Access Point (AP)', 'brand' => 'TP-Link Omada', 'model' => 'EAP225-Outdoor', 'qty' => 5, 'specs' => 'AC1200 Wireless Dual Band Outdoor', 'cond' => 'Baik'],
                ],
                'antennas' => [
                    ['code' => 'Antena Outdoor Mesh 1', 'brand' => 'Omada Sector Antenna', 'freq' => '2.4 GHz / 5 GHz', 'location' => 'Tiang Pipa 9m', 'clients' => 18, 'max' => 25],
                ]
            ]
        ];

        foreach ($samples as $data) {
            $totalDev = 0;
            foreach ($data['devices'] as $d) {
                $totalDev += $d['qty'];
            }

            $totalAnt = count($data['antennas']);
            $totalCli = 0;
            foreach ($data['antennas'] as $a) {
                $totalCli += $a['clients'];
            }

            $response = Response::create([
                'form_id' => $form->id,
                'response_code' => $data['code'],
                'location_name' => $data['instance_name'],
                'regency' => $data['regency'],
                'province' => $data['province'],
                'pic_name' => $data['pic_name'],
                'pic_phone' => $data['pic_phone'],
                'total_devices' => $totalDev,
                'total_antennas' => $totalAnt,
                'total_clients' => $totalCli,
                'status' => 'submitted',
                'submitted_at' => now()->subDays(rand(0, 5)),
            ]);

            Location::create([
                'response_id' => $response->id,
                'instance_name' => $data['instance_name'],
                'address' => $data['address'],
                'regency' => $data['regency'],
                'province' => $data['province'],
                'pic_name' => $data['pic_name'],
                'pic_position' => $data['pic_position'],
                'pic_phone' => $data['pic_phone'],
                'pic_email' => $data['pic_email'],
                'distance_km' => $data['distance_km'],
                'distance_unit' => 'km',
                'access_mode' => $data['access_mode'],
                'road_condition' => $data['road_condition'],
                'vehicle_type' => $data['vehicle_type'],
                'travel_time' => $data['travel_time'],
                'latitude' => $data['lat'],
                'longitude' => $data['long'],
                'access_notes' => 'Akses aman dalam kondisi cuaca cerah.',
            ]);

            Topology::create([
                'response_id' => $response->id,
                'topology_type' => $data['topology_type'],
                'description' => "Distribusi sinyal Starlink disalurkan via router utama lalu dibagi ke switch PoE untuk AP indoor/outdoor.",
                'notes' => 'Daya cadangan menggunakan UPS Online.',
            ]);

            foreach ($data['devices'] as $idx => $d) {
                Device::create([
                    'response_id' => $response->id,
                    'device_type' => $d['type'],
                    'brand' => $d['brand'],
                    'model' => $d['model'],
                    'quantity' => $d['qty'],
                    'specs' => $d['specs'],
                    'condition' => $d['cond'],
                    'sort_order' => $idx + 1,
                ]);
            }

            foreach ($data['antennas'] as $idx => $a) {
                Antenna::create([
                    'response_id' => $response->id,
                    'antenna_code' => $a['code'],
                    'brand_model' => $a['brand'],
                    'frequency' => $a['freq'],
                    'install_location' => $a['location'],
                    'client_count' => $a['clients'],
                    'max_clients' => $a['max'],
                    'sort_order' => $idx + 1,
                ]);
            }
        }
    }
}
