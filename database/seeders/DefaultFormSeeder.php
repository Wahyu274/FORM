<?php

namespace Database\Seeders;

use App\Models\Form;
use App\Models\FormField;
use App\Models\FormFieldOption;
use App\Models\FormSection;
use Illuminate\Database\Seeder;

class DefaultFormSeeder extends Seeder
{
    public function run(): void
    {
        $form = Form::firstOrCreate(
            ['slug' => 'inventaris-kalimantan'],
            [
                'title' => 'FORM INVENTARIS JARINGAN PARTNER KALIMANTAN',
                'code_prefix' => 'INV-KAL',
                'description' => 'Formulir pendataan dan inventarisasi infrastruktur jaringan partner Life Solution Connection (STARLINK) di wilayah Kalimantan.',
                'is_active' => true,
                'max_clients_per_antenna' => 25,
            ]
        );

        $sectionsData = [
            [
                'code' => 'location',
                'title' => 'BAGIAN 1 — INFORMASI LOKASI',
                'description' => 'Isi data instansi, alamat lengkap, dan penanggung jawab lokasi.',
                'sort_order' => 1,
                'fields' => [
                    ['label' => 'Nama Instansi / Lokasi', 'name' => 'instance_name', 'type' => 'text', 'is_required' => true, 'placeholder' => 'Contoh: Kantor Cabang Balikpapan / Basecamp A'],
                    ['label' => 'Alamat Lengkap', 'name' => 'address', 'type' => 'textarea', 'is_required' => true, 'placeholder' => 'Jl. Ahmad Yani No. 12, RT 05...'],
                    ['label' => 'Kabupaten / Kota', 'name' => 'regency', 'type' => 'dropdown', 'is_required' => true],
                    ['label' => 'Provinsi', 'name' => 'province', 'type' => 'dropdown', 'is_required' => true],
                    ['label' => 'Nama PIC / Pengisi', 'name' => 'pic_name', 'type' => 'text', 'is_required' => true, 'placeholder' => 'Nama lengkap pengisi form'],
                    ['label' => 'Jabatan', 'name' => 'pic_position', 'type' => 'text', 'is_required' => false, 'placeholder' => 'Contoh: IT Support / Network Engineer'],
                    ['label' => 'Nomor HP / WhatsApp', 'name' => 'pic_phone', 'type' => 'text', 'is_required' => true, 'placeholder' => '081234567890'],
                    ['label' => 'Email (Opsional)', 'name' => 'pic_email', 'type' => 'text', 'is_required' => false, 'placeholder' => 'pic@perusahaan.com'],
                ]
            ],
            [
                'code' => 'access',
                'title' => 'BAGIAN 2 — JARAK DAN AKSES LOKASI',
                'description' => 'Lengkapi rute perjalanan, kondisi jalan, dan koordinat GPS lokasi.',
                'sort_order' => 2,
                'fields' => [
                    ['label' => 'Jarak dari Kantor / Titik Referensi', 'name' => 'distance_km', 'type' => 'number', 'is_required' => true, 'placeholder' => '15.5'],
                    ['label' => 'Akses Menuju Lokasi', 'name' => 'access_mode', 'type' => 'dropdown', 'is_required' => true],
                    ['label' => 'Kondisi Jalan', 'name' => 'road_condition', 'type' => 'dropdown', 'is_required' => true],
                    ['label' => 'Kendaraan yang Dapat Digunakan', 'name' => 'vehicle_type', 'type' => 'text', 'is_required' => true, 'placeholder' => 'Mobil 4WD / Motor Trail / Speedboat'],
                    ['label' => 'Estimasi Waktu Perjalanan', 'name' => 'travel_time', 'type' => 'text', 'is_required' => false, 'placeholder' => '2 Jam 30 Menit'],
                    ['label' => 'Koordinat Lokasi GPS', 'name' => 'gps_coordinates', 'type' => 'gps_location', 'is_required' => false, 'help_text' => 'Gunakan tombol Ambil Lokasi Saya untuk akurasi GPS.'],
                    ['label' => 'Catatan Akses Lokasi', 'name' => 'access_notes', 'type' => 'textarea', 'is_required' => false, 'placeholder' => 'Petunjuk khusus rute perjalanan...'],
                ]
            ],
            [
                'code' => 'topology',
                'title' => 'BAGIAN 3 — TOPOLOGI JARINGAN',
                'description' => 'Pilih jenis skema jaringan dan deskripsi topologi.',
                'sort_order' => 3,
                'fields' => [
                    ['label' => 'Jenis Topologi', 'name' => 'topology_type', 'type' => 'dropdown', 'is_required' => true],
                    ['label' => 'Penjelasan Topologi', 'name' => 'topology_description', 'type' => 'textarea', 'is_required' => false, 'placeholder' => 'Jelaskan alur distribusi koneksi dari Starlink ke router/switch...'],
                    ['label' => 'Upload Gambar Topologi', 'name' => 'topology_file', 'type' => 'file', 'is_required' => false, 'help_text' => 'Format JPG, PNG, atau PDF. Maks 10 MB.'],
                    ['label' => 'Foto Kondisi Jaringan', 'name' => 'network_condition_photo', 'type' => 'image', 'is_required' => false, 'help_text' => 'Foto rack / kabinet / ruangan server.'],
                ]
            ],
            [
                'code' => 'devices',
                'title' => 'BAGIAN 4 — PERANGKAT JARINGAN',
                'description' => 'Daftar tabel dinamis seluruh perangkat yang terpasang di lokasi.',
                'sort_order' => 4,
                'fields' => []
            ],
            [
                'code' => 'antenna',
                'title' => 'BAGIAN 5 — ANTENA DAN CLIENT',
                'description' => 'Informasi antena pemancar dan jumlah client terhubung (Maks. 25 client / antena).',
                'sort_order' => 5,
                'fields' => []
            ],
            [
                'code' => 'additional',
                'title' => 'BAGIAN 6 — INFORMASI TAMBAHAN',
                'description' => 'Kendala teknis, kondisi daya, sinyal, dan kebutuhan penambahan perangkat.',
                'sort_order' => 6,
                'fields' => [
                    ['label' => 'Kendala Jaringan', 'name' => 'network_issues', 'type' => 'textarea', 'is_required' => false, 'placeholder' => 'Sebutkan kendala jika ada...'],
                    ['label' => 'Kondisi Sinyal', 'name' => 'signal_condition', 'type' => 'text', 'is_required' => false, 'placeholder' => 'Sangat Baik / Stabil / Fluktuatif'],
                    ['label' => 'Kondisi Listrik & Power Backup', 'name' => 'power_condition', 'type' => 'text', 'is_required' => false, 'placeholder' => 'PLN 2200W + UPS 1200VA / Genset'],
                    ['label' => 'Kondisi Tower / Tiang', 'name' => 'tower_condition', 'type' => 'text', 'is_required' => false, 'placeholder' => 'Monopole 15m / Triangle 24m'],
                    ['label' => 'Kebutuhan Perangkat Tambahan', 'name' => 'required_hardware', 'type' => 'textarea', 'is_required' => false, 'placeholder' => 'Rencana penambahan AP atau Switch...'],
                    ['label' => 'Catatan Teknis Lainnya', 'name' => 'technical_notes', 'type' => 'textarea', 'is_required' => false, 'placeholder' => 'Informasi penting lainnya...'],
                ]
            ],
            [
                'code' => 'documentation',
                'title' => 'BAGIAN 7 — DOKUMENTASI FOTO',
                'description' => 'Upload foto pendukung instalasi, lokasi, dan perangkat.',
                'sort_order' => 7,
                'fields' => [
                    ['label' => 'Foto Lokasi & Bangunan', 'name' => 'foto_lokasi', 'type' => 'image', 'is_required' => false],
                    ['label' => 'Foto Perangkat & Rack Server', 'name' => 'foto_perangkat', 'type' => 'image', 'is_required' => false],
                    ['label' => 'Foto Antena & Dish Starlink', 'name' => 'foto_antena', 'type' => 'image', 'is_required' => false],
                    ['label' => 'Foto Router & Switch', 'name' => 'foto_router', 'type' => 'image', 'is_required' => false],
                    ['label' => 'Foto Instalasi & Jalur Kabel', 'name' => 'foto_instalasi', 'type' => 'image', 'is_required' => false],
                ]
            ],
        ];

        foreach ($sectionsData as $sData) {
            $fields = $sData['fields'];
            unset($sData['fields']);

            $section = FormSection::create(array_merge($sData, ['form_id' => $form->id]));

            foreach ($fields as $idx => $fData) {
                $field = FormField::create(array_merge($fData, [
                    'form_id' => $form->id,
                    'section_id' => $section->id,
                    'is_active' => true,
                    'sort_order' => $idx + 1,
                ]));

                // Populate Dropdown Options
                if ($fData['name'] === 'regency') {
                    $regencies = ['Balikpapan', 'Samarinda', 'Bontang', 'Kutai Kartanegara', 'Kutai Timur', 'Banjarmasin', 'Banjarbaru', 'Palangka Raya', 'Pontianak', 'Tanjung Selor', 'Kabupaten/Kota Lainnya'];
                    foreach ($regencies as $rIdx => $rName) {
                        FormFieldOption::create([
                            'field_id' => $field->id,
                            'label' => $rName,
                            'value' => $rName,
                            'sort_order' => $rIdx + 1,
                            'is_active' => true,
                        ]);
                    }
                } elseif ($fData['name'] === 'province') {
                    $provinces = ['Kalimantan Timur', 'Kalimantan Selatan', 'Kalimantan Tengah', 'Kalimantan Barat', 'Kalimantan Utara'];
                    foreach ($provinces as $pIdx => $pName) {
                        FormFieldOption::create([
                            'field_id' => $field->id,
                            'label' => $pName,
                            'value' => $pName,
                            'sort_order' => $pIdx + 1,
                            'is_active' => true,
                        ]);
                    }
                } elseif ($fData['name'] === 'access_mode') {
                    $modes = ['Darat (Jalan Aspal)', 'Darat (Jalan Tanah / Offroad)', 'Sungai / Perahu', 'Kombinasi Darat & Sungai', 'Udara / Helikopter'];
                    foreach ($modes as $mIdx => $mName) {
                        FormFieldOption::create(['field_id' => $field->id, 'label' => $mName, 'value' => $mName, 'sort_order' => $mIdx + 1, 'is_active' => true]);
                    }
                } elseif ($fData['name'] === 'road_condition') {
                    $conditions = ['Bagus / Aspal Mulus', 'Cukup Baik / Berlubang Sedang', 'Rusak / Tanah Berlumpur', 'Ekstrem / Memerlukan 4WD'];
                    foreach ($conditions as $cIdx => $cName) {
                        FormFieldOption::create(['field_id' => $field->id, 'label' => $cName, 'value' => $cName, 'sort_order' => $cIdx + 1, 'is_active' => true]);
                    }
                } elseif ($fData['name'] === 'topology_type') {
                    $topologies = ['Star (Bintang)', 'Tree (Pohon)', 'Mesh (Jaring)', 'Point to Point (PTP)', 'Point to Multipoint (PTMP)', 'Lainnya'];
                    foreach ($topologies as $tIdx => $tName) {
                        FormFieldOption::create(['field_id' => $field->id, 'label' => $tName, 'value' => $tName, 'sort_order' => $tIdx + 1, 'is_active' => true]);
                    }
                }
            }
        }
    }
}
