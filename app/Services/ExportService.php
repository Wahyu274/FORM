<?php

namespace App\Services;

use App\Models\Response;
use Illuminate\Database\Eloquent\Collection;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportService
{
    /**
     * Export responses to CSV stream
     */
    public static function toCsv(Collection $responses): StreamedResponse
    {
        $filename = "starkink_inventory_export_" . date('Ymd_His') . ".csv";

        $headers = [
            "Content-Type" => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"{$filename}\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($responses) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // CSV Columns Header
            fputcsv($file, [
                'Kode Respon',
                'Nama Instansi / Lokasi',
                'Alamat Lengkap',
                'Kabupaten / Kota',
                'Provinsi',
                'PIC / Pengisi',
                'Jabatan PIC',
                'Nomor HP / WA',
                'Email',
                'Jarak (KM)',
                'Akses Lokasi',
                'Kondisi Jalan',
                'Kendaraan',
                'Estimasi Waktu',
                'Latitude',
                'Longitude',
                'Jenis Topologi',
                'Penjelasan Topologi',
                'Total Antena',
                'Total Client',
                'Total Perangkat',
                'Daftar Perangkat',
                'Daftar Antena',
                'Tanggal Pengisian',
                'Status'
            ]);

            foreach ($responses as $res) {
                $loc = $res->location;
                $top = $res->topology;

                // Format Devices Summary string
                $deviceSummaryArr = [];
                foreach ($res->devices as $dev) {
                    $deviceSummaryArr[] = "{$dev->device_type} ({$dev->brand} {$dev->model} - {$dev->quantity} unit)";
                }
                $deviceStr = implode('; ', $deviceSummaryArr);

                // Format Antenna Summary string
                $antennaSummaryArr = [];
                foreach ($res->antennas as $ant) {
                    $antennaSummaryArr[] = "{$ant->antenna_code}: {$ant->brand_model} ({$ant->client_count} client)";
                }
                $antennaStr = implode('; ', $antennaSummaryArr);

                fputcsv($file, [
                    $res->response_code,
                    $loc?->instance_name ?? $res->location_name,
                    $loc?->address ?? '-',
                    $loc?->regency ?? $res->regency,
                    $loc?->province ?? $res->province,
                    $loc?->pic_name ?? $res->pic_name,
                    $loc?->pic_position ?? '-',
                    $loc?->pic_phone ?? $res->pic_phone,
                    $loc?->pic_email ?? '-',
                    $loc?->distance_km ?? 0,
                    $loc?->access_mode ?? '-',
                    $loc?->road_condition ?? '-',
                    $loc?->vehicle_type ?? '-',
                    $loc?->travel_time ?? '-',
                    $loc?->latitude ?? '-',
                    $loc?->longitude ?? '-',
                    $top?->topology_type ?? '-',
                    $top?->description ?? '-',
                    $res->total_antennas,
                    $res->total_clients,
                    $res->total_devices,
                    $deviceStr,
                    $antennaStr,
                    $res->submitted_at ? $res->submitted_at->format('Y-m-d H:i:s') : '-',
                    strtoupper($res->status),
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Export responses to Excel HTML/XLS stream
     */
    public static function toExcel(Collection $responses): StreamedResponse
    {
        $filename = "starkink_inventory_export_" . date('Ymd_His') . ".xls";

        $headers = [
            "Content-Type" => "application/vnd.ms-excel; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=\"{$filename}\"",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        ];

        $callback = function () use ($responses) {
            echo "<html><head><meta charset='UTF-8'></head><body>";
            echo "<table border='1'>";
            echo "<tr style='background-color:#0F172A; color:#FFFFFF; font-weight:bold;'>";
            echo "<th>Kode Respon</th><th>Nama Lokasi</th><th>Alamat</th><th>Kabupaten</th><th>Provinsi</th>";
            echo "<th>PIC</th><th>Jabatan</th><th>No HP/WA</th><th>Email</th><th>Jarak (KM)</th>";
            echo "<th>Akses</th><th>Kondisi Jalan</th><th>Latitude</th><th>Longitude</th>";
            echo "<th>Topologi</th><th>Total Antena</th><th>Total Client</th><th>Total Perangkat</th>";
            echo "<th>Rincian Perangkat</th><th>Rincian Antena</th><th>Tanggal Pengisian</th>";
            echo "</tr>";

            foreach ($responses as $res) {
                $loc = $res->location;
                $top = $res->topology;

                $devList = $res->devices->map(fn($d) => "• {$d->device_type} - {$d->brand} {$d->model} ({$d->quantity}x)")->join('<br>');
                $antList = $res->antennas->map(fn($a) => "• {$a->antenna_code}: {$a->brand_model} [{$a->client_count}/{$a->max_clients} client]")->join('<br>');

                echo "<tr>";
                echo "<td>" . e($res->response_code) . "</td>";
                echo "<td>" . e($loc?->instance_name ?? $res->location_name) . "</td>";
                echo "<td>" . e($loc?->address ?? '-') . "</td>";
                echo "<td>" . e($loc?->regency ?? $res->regency) . "</td>";
                echo "<td>" . e($loc?->province ?? $res->province) . "</td>";
                echo "<td>" . e($loc?->pic_name ?? $res->pic_name) . "</td>";
                echo "<td>" . e($loc?->pic_position ?? '-') . "</td>";
                echo "<td>" . e($loc?->pic_phone ?? $res->pic_phone) . "</td>";
                echo "<td>" . e($loc?->pic_email ?? '-') . "</td>";
                echo "<td>" . e($loc?->distance_km ?? 0) . "</td>";
                echo "<td>" . e($loc?->access_mode ?? '-') . "</td>";
                echo "<td>" . e($loc?->road_condition ?? '-') . "</td>";
                echo "<td>" . e($loc?->latitude ?? '-') . "</td>";
                echo "<td>" . e($loc?->longitude ?? '-') . "</td>";
                echo "<td>" . e($top?->topology_type ?? '-') . "</td>";
                echo "<td>" . e($res->total_antennas) . "</td>";
                echo "<td>" . e($res->total_clients) . "</td>";
                echo "<td>" . e($res->total_devices) . "</td>";
                echo "<td>" . $devList . "</td>";
                echo "<td>" . $antList . "</td>";
                echo "<td>" . ($res->submitted_at ? $res->submitted_at->format('d/m/Y H:i') : '-') . "</td>";
                echo "</tr>";
            }

            echo "</table></body></html>";
        };

        return response()->stream($callback, 200, $headers);
    }
}
