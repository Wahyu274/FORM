<?php
/**
 * STARKINK Inventory Database Setup / Migration Script
 * Use this script to create or repair all required database tables.
 */

// Try loading .env if available
$envFile = __DIR__ . '/.env';
if (!file_exists($envFile)) {
    $envFile = __DIR__ . '/../.env';
}

$dbHost = '127.0.0.1';
$dbPort = '3306';
$dbName = 'u660474867_lsc';
$dbUser = 'u660474867_info';
$dbPass = '9@d9&VtHU';

if (file_exists($envFile)) {
    $lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') !== false) {
            list($key, $value) = explode('=', $line, 2);
            $key = trim($key);
            $value = trim($value, " \t\n\r\0\x0B\"'");
            if ($key === 'DB_HOST') $dbHost = $value;
            if ($key === 'DB_PORT') $dbPort = $value;
            if ($key === 'DB_DATABASE') $dbName = $value;
            if ($key === 'DB_USERNAME') $dbUser = $value;
            if ($key === 'DB_PASSWORD') $dbPass = $value;
        }
    }
}

header('Content-Type: text/html; charset=utf-8');
echo "<!DOCTYPE html><html><head><title>Database Migration & Repair</title>";
echo "<style>body{font-family:sans-serif;background:#0f172a;color:#f8fafc;padding:30px;line-height:1.6;} .card{background:#1e293b;border-radius:12px;padding:24px;max-width:800px;margin:0 auto;box-shadow:0 10px 25px rgba(0,0,0,0.3);} .success{color:#4ade80;} .error{color:#f87171;} .info{color:#38bdf8;} pre{background:#090d16;padding:12px;border-radius:8px;overflow-x:auto;}</style>";
echo "</head><body><div class='card'>";
echo "<h2>🛠️ STARLINK Database Migration & Repair</h2>";
echo "<p>Menghubungkan ke database <b>{$dbName}</b> di <b>{$dbHost}:{$dbPort}</b>...</p>";

try {
    $db = new PDO("mysql:host={$dbHost};port={$dbPort};dbname={$dbName};charset=utf8mb4", $dbUser, $dbPass, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
    echo "<p class='success'>✅ Berhasil terhubung ke database!</p><hr style='border-color:#334155;'>";
} catch (PDOException $e) {
    echo "<p class='error'>❌ Gagal koneksi database: " . htmlspecialchars($e->getMessage()) . "</p>";
    echo "</div></body></html>";
    exit;
}

$tables = [
    'users' => "
        CREATE TABLE IF NOT EXISTS `users` (
            `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `name` VARCHAR(255) NOT NULL,
            `email` VARCHAR(255) NOT NULL UNIQUE,
            `email_verified_at` TIMESTAMP NULL,
            `password` VARCHAR(255) NOT NULL,
            `role` ENUM('admin', 'superadmin') DEFAULT 'admin',
            `remember_token` VARCHAR(100) NULL,
            `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",
    'password_reset_tokens' => "
        CREATE TABLE IF NOT EXISTS `password_reset_tokens` (
            `email` VARCHAR(255) PRIMARY KEY,
            `token` VARCHAR(255) NOT NULL,
            `created_at` TIMESTAMP NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",
    'sessions' => "
        CREATE TABLE IF NOT EXISTS `sessions` (
            `id` VARCHAR(255) PRIMARY KEY,
            `user_id` BIGINT UNSIGNED NULL,
            `ip_address` VARCHAR(45) NULL,
            `user_agent` TEXT NULL,
            `payload` LONGTEXT NOT NULL,
            `last_activity` INT NOT NULL,
            INDEX `sessions_user_id_index` (`user_id`),
            INDEX `sessions_last_activity_index` (`last_activity`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",
    'forms' => "
        CREATE TABLE IF NOT EXISTS `forms` (
            `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `title` VARCHAR(255) NOT NULL,
            `slug` VARCHAR(255) NOT NULL UNIQUE,
            `code_prefix` VARCHAR(50) DEFAULT 'INV-KAL',
            `description` TEXT NULL,
            `is_active` TINYINT(1) DEFAULT 1,
            `max_clients_per_antenna` INT DEFAULT 25,
            `settings` JSON NULL,
            `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",
    'form_sections' => "
        CREATE TABLE IF NOT EXISTS `form_sections` (
            `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `form_id` BIGINT UNSIGNED NOT NULL,
            `title` VARCHAR(255) NOT NULL,
            `code` VARCHAR(100) NULL,
            `description` TEXT NULL,
            `sort_order` INT DEFAULT 0,
            `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `form_sections_form_id_index` (`form_id`),
            CONSTRAINT `fk_sections_form` FOREIGN KEY (`form_id`) REFERENCES `forms`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",
    'form_fields' => "
        CREATE TABLE IF NOT EXISTS `form_fields` (
            `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `form_id` BIGINT UNSIGNED NOT NULL,
            `section_id` BIGINT UNSIGNED NOT NULL,
            `label` VARCHAR(255) NOT NULL,
            `name` VARCHAR(255) NOT NULL,
            `type` ENUM('text','textarea','number','date','dropdown','radio','checkbox','file','image','gps_location') DEFAULT 'text',
            `is_required` TINYINT(1) DEFAULT 0,
            `is_active` TINYINT(1) DEFAULT 1,
            `sort_order` INT DEFAULT 0,
            `placeholder` VARCHAR(255) NULL,
            `help_text` VARCHAR(255) NULL,
            `default_value` VARCHAR(255) NULL,
            `validation_rules` JSON NULL,
            `options` JSON NULL,
            `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `form_fields_form_id_index` (`form_id`),
            INDEX `form_fields_section_id_index` (`section_id`),
            CONSTRAINT `fk_fields_form` FOREIGN KEY (`form_id`) REFERENCES `forms`(`id`) ON DELETE CASCADE,
            CONSTRAINT `fk_fields_section` FOREIGN KEY (`section_id`) REFERENCES `form_sections`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",
    'form_field_options' => "
        CREATE TABLE IF NOT EXISTS `form_field_options` (
            `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `field_id` BIGINT UNSIGNED NOT NULL,
            `label` VARCHAR(255) NOT NULL,
            `value` VARCHAR(255) NOT NULL,
            `sort_order` INT DEFAULT 0,
            `is_active` TINYINT(1) DEFAULT 1,
            `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `form_field_options_field_id_index` (`field_id`),
            CONSTRAINT `fk_options_field` FOREIGN KEY (`field_id`) REFERENCES `form_fields`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",
    'responses' => "
        CREATE TABLE IF NOT EXISTS `responses` (
            `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `form_id` BIGINT UNSIGNED NOT NULL,
            `response_code` VARCHAR(100) NOT NULL UNIQUE,
            `location_name` VARCHAR(255) NOT NULL,
            `regency` VARCHAR(100) NOT NULL,
            `province` VARCHAR(100) DEFAULT 'Kalimantan',
            `pic_name` VARCHAR(255) NOT NULL,
            `pic_phone` VARCHAR(50) NOT NULL,
            `total_devices` INT DEFAULT 0,
            `total_antennas` INT DEFAULT 0,
            `total_clients` INT DEFAULT 0,
            `status` ENUM('submitted','verified','archived','draft') DEFAULT 'submitted',
            `ip_address` VARCHAR(45) NULL,
            `user_agent` TEXT NULL,
            `submitted_at` TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `responses_form_id_index` (`form_id`),
            CONSTRAINT `fk_responses_form` FOREIGN KEY (`form_id`) REFERENCES `forms`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",
    'response_values' => "
        CREATE TABLE IF NOT EXISTS `response_values` (
            `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `response_id` BIGINT UNSIGNED NOT NULL,
            `field_id` BIGINT UNSIGNED NULL,
            `field_name` VARCHAR(255) NOT NULL,
            `value` TEXT NULL,
            `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `response_values_response_id_index` (`response_id`),
            INDEX `response_values_field_id_index` (`field_id`),
            CONSTRAINT `fk_values_response` FOREIGN KEY (`response_id`) REFERENCES `responses`(`id`) ON DELETE CASCADE,
            CONSTRAINT `fk_values_field` FOREIGN KEY (`field_id`) REFERENCES `form_fields`(`id`) ON DELETE SET NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",
    'locations' => "
        CREATE TABLE IF NOT EXISTS `locations` (
            `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `response_id` BIGINT UNSIGNED NOT NULL,
            `instance_name` VARCHAR(255) NOT NULL,
            `address` TEXT NOT NULL,
            `regency` VARCHAR(100) NOT NULL,
            `province` VARCHAR(100) NOT NULL,
            `pic_name` VARCHAR(255) NOT NULL,
            `pic_position` VARCHAR(255) NULL,
            `pic_phone` VARCHAR(50) NOT NULL,
            `pic_email` VARCHAR(255) NULL,
            `distance_km` DECIMAL(8,2) NULL,
            `distance_unit` VARCHAR(10) DEFAULT 'km',
            `access_mode` VARCHAR(255) NULL,
            `road_condition` VARCHAR(255) NULL,
            `vehicle_type` VARCHAR(255) NULL,
            `travel_time` VARCHAR(100) NULL,
            `latitude` DECIMAL(10,8) NULL,
            `longitude` DECIMAL(11,8) NULL,
            `access_notes` TEXT NULL,
            `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `locations_response_id_index` (`response_id`),
            CONSTRAINT `fk_locations_response` FOREIGN KEY (`response_id`) REFERENCES `responses`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",
    'topologies' => "
        CREATE TABLE IF NOT EXISTS `topologies` (
            `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `response_id` BIGINT UNSIGNED NOT NULL,
            `topology_type` VARCHAR(100) NOT NULL,
            `description` TEXT NULL,
            `notes` TEXT NULL,
            `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `topologies_response_id_index` (`response_id`),
            CONSTRAINT `fk_topologies_response` FOREIGN KEY (`response_id`) REFERENCES `responses`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",
    'devices' => "
        CREATE TABLE IF NOT EXISTS `devices` (
            `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `response_id` BIGINT UNSIGNED NOT NULL,
            `device_type` VARCHAR(100) NOT NULL,
            `brand` VARCHAR(100) NULL,
            `model` VARCHAR(100) NULL,
            `quantity` INT DEFAULT 1,
            `specs` TEXT NULL,
            `condition` VARCHAR(100) DEFAULT 'Baik',
            `notes` TEXT NULL,
            `sort_order` INT DEFAULT 0,
            `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `devices_response_id_index` (`response_id`),
            CONSTRAINT `fk_devices_response` FOREIGN KEY (`response_id`) REFERENCES `responses`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",
    'antennas' => "
        CREATE TABLE IF NOT EXISTS `antennas` (
            `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `response_id` BIGINT UNSIGNED NOT NULL,
            `antenna_code` VARCHAR(100) NOT NULL,
            `brand_model` VARCHAR(100) NULL,
            `frequency` VARCHAR(50) NULL,
            `install_location` VARCHAR(255) NULL,
            `client_count` INT DEFAULT 0,
            `max_clients` INT DEFAULT 25,
            `notes` TEXT NULL,
            `sort_order` INT DEFAULT 0,
            `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `antennas_response_id_index` (`response_id`),
            CONSTRAINT `fk_antennas_response` FOREIGN KEY (`response_id`) REFERENCES `responses`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    ",
    'uploads' => "
        CREATE TABLE IF NOT EXISTS `uploads` (
            `id` BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            `response_id` BIGINT UNSIGNED NOT NULL,
            `field_name` VARCHAR(100) NOT NULL,
            `category` VARCHAR(50) DEFAULT 'dokumentasi',
            `original_name` VARCHAR(255) NOT NULL,
            `filename` VARCHAR(255) NOT NULL,
            `filepath` VARCHAR(255) NOT NULL,
            `mime_type` VARCHAR(100) NULL,
            `file_size` BIGINT UNSIGNED DEFAULT 0,
            `created_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
            `updated_at` TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            INDEX `uploads_response_id_index` (`response_id`),
            CONSTRAINT `fk_uploads_response` FOREIGN KEY (`response_id`) REFERENCES `responses`(`id`) ON DELETE CASCADE
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
    "
];

echo "<ul style='list-style:none;padding:0;'>";
foreach ($tables as $name => $sql) {
    try {
        $db->exec($sql);
        echo "<li><span class='success'>✔</span> Tabel <code>`{$name}`</code> siap digunakan.</li>";
    } catch (PDOException $e) {
        echo "<li><span class='error'>✖</span> Gagal membuat tabel <code>`{$name}`</code>: " . htmlspecialchars($e->getMessage()) . "</li>";
    }
}
echo "</ul><hr style='border-color:#334155;'>";

// Seed Admin & Default Form
try {
    $pass = password_hash('admin123', PASSWORD_BCRYPT);
    $stmt = $db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?) ON DUPLICATE KEY UPDATE name=VALUES(name), password=VALUES(password)");
    $stmt->execute(['Administrator STARLINK', 'admin@starkink.co.id', $pass, 'admin']);
    $stmt->execute(['Administrator Life Solution', 'admin@lifesolution.co.id', $pass, 'admin']);
    echo "<p class='success'>✔ Akun Admin (<code>admin@starkink.co.id</code> atau <code>admin@lifesolution.co.id</code> / <code>admin123</code>) siap.</p>";
} catch (PDOException $e) {
    echo "<p class='info'>ℹ Info User: " . htmlspecialchars($e->getMessage()) . "</p>";
}

try {
    $stmtForm = $db->prepare("INSERT INTO forms (title, slug, code_prefix, is_active, max_clients_per_antenna) VALUES (?, ?, ?, 1, 25) ON DUPLICATE KEY UPDATE title=VALUES(title)");
    $stmtForm->execute(['FORM INVENTARIS JARINGAN PARTNER KALIMANTAN', 'inventaris-kalimantan', 'INV-KAL']);
    $formId = $db->query("SELECT id FROM forms WHERE slug='inventaris-kalimantan' LIMIT 1")->fetchColumn();
    echo "<p class='success'>✔ Form Default inventaris siap (ID: {$formId}).</p>";

    // Check if sections already exist
    $chkSections = $db->prepare("SELECT COUNT(*) FROM form_sections WHERE form_id = ?");
    $chkSections->execute([$formId]);
    if ($chkSections->fetchColumn() == 0) {
        $sections = [
            ['code' => 'location', 'title' => 'BAGIAN 1 — INFORMASI LOKASI', 'desc' => 'Isi data instansi, alamat lengkap, dan penanggung jawab lokasi.', 'order' => 1],
            ['code' => 'access', 'title' => 'BAGIAN 2 — JARAK DAN AKSES LOKASI', 'desc' => 'Lengkapi rute perjalanan, kondisi jalan, dan koordinat GPS lokasi.', 'order' => 2],
            ['code' => 'topology', 'title' => 'BAGIAN 3 — TOPOLOGI JARINGAN', 'desc' => 'Pilih topologi jaringan dan sertakan keterangan skema distribusi.', 'order' => 3],
            ['code' => 'devices', 'title' => 'BAGIAN 4 — DAFTAR PERANGKAT JARINGAN', 'desc' => 'Data perangkat router, switch, access point, dan periferal lainnya.', 'order' => 4],
            ['code' => 'antenna', 'title' => 'BAGIAN 5 — DATA ANTENA & JUMLAH CLIENT', 'desc' => 'Pendataan antena wireless dan jumlah user/client terhubung.', 'order' => 5],
            ['code' => 'additional', 'title' => 'BAGIAN 6 — CATATAN & KEBUTUHAN KHUSUS', 'desc' => 'Catatan lapangan atau kebutuhan upgrade / peremajaan.', 'order' => 6],
            ['code' => 'documentation', 'title' => 'BAGIAN 7 — DOKUMENTASI FOTO', 'desc' => 'Upload foto pendukung instalasi, lokasi, dan perangkat.', 'order' => 7],
        ];

        $insSec = $db->prepare("INSERT INTO form_sections (form_id, title, code, description, sort_order) VALUES (?, ?, ?, ?, ?)");
        $insField = $db->prepare("INSERT INTO form_fields (form_id, section_id, label, name, type, is_required, is_active, sort_order, placeholder) VALUES (?, ?, ?, ?, ?, ?, 1, ?, ?)");
        $insOpt = $db->prepare("INSERT INTO form_field_options (field_id, label, value, sort_order, is_active) VALUES (?, ?, ?, ?, 1)");

        foreach ($sections as $s) {
            $insSec->execute([$formId, $s['title'], $s['code'], $s['desc'], $s['order']]);
            $secId = $db->lastInsertId();

            if ($s['code'] === 'location') {
                $locFields = [
                    ['Nama Instansi / Lokasi', 'instance_name', 'text', 1, 'Contoh: Kantor Cabang Balikpapan / Basecamp A'],
                    ['Alamat Lengkap', 'address', 'textarea', 1, 'Jl. Ahmad Yani No. 12...'],
                    ['Kabupaten / Kota', 'regency', 'dropdown', 1, null],
                    ['Provinsi', 'province', 'dropdown', 1, null],
                    ['Nama PIC / Pengisi', 'pic_name', 'text', 1, 'Nama lengkap pengisi form'],
                    ['Jabatan', 'pic_position', 'text', 0, 'Contoh: IT Support / Network Engineer'],
                    ['Nomor HP / WhatsApp', 'pic_phone', 'text', 1, '081234567890'],
                    ['Email (Opsional)', 'pic_email', 'text', 0, 'pic@perusahaan.com'],
                ];
                foreach ($locFields as $idx => $f) {
                    $insField->execute([$formId, $secId, $f[0], $f[1], $f[2], $f[3], $idx + 1, $f[4]]);
                    $fid = $db->lastInsertId();
                    if ($f[1] === 'regency') {
                        $regencies = ['Balikpapan', 'Samarinda', 'Bontang', 'Kutai Kartanegara', 'Kutai Timur', 'Banjarmasin', 'Banjarbaru', 'Palangka Raya', 'Pontianak', 'Tanjung Selor', 'Kabupaten/Kota Lainnya'];
                        foreach ($regencies as $ri => $r) { $insOpt->execute([$fid, $r, $r, $ri + 1]); }
                    } elseif ($f[1] === 'province') {
                        $provinces = ['Kalimantan Timur', 'Kalimantan Selatan', 'Kalimantan Tengah', 'Kalimantan Barat', 'Kalimantan Utara'];
                        foreach ($provinces as $pi => $p) { $insOpt->execute([$fid, $p, $p, $pi + 1]); }
                    }
                }
            } elseif ($s['code'] === 'access') {
                $accFields = [
                    ['Jarak dari Titik Referensi', 'distance_km', 'number', 1, '15.5'],
                    ['Akses Menuju Lokasi', 'access_mode', 'dropdown', 1, null],
                    ['Kondisi Jalan', 'road_condition', 'dropdown', 1, null],
                    ['Kendaraan yang Direkomendasikan', 'vehicle_type', 'text', 0, 'Mobil 4WD / Motor Trail'],
                    ['Estimasi Waktu Tempuh', 'travel_time', 'text', 0, '2 Jam 30 Menit'],
                    ['Catatan Tambahan Akses', 'access_notes', 'textarea', 0, 'Perlu izin pos satpam di pintu masuk...'],
                ];
                foreach ($accFields as $idx => $f) {
                    $insField->execute([$formId, $secId, $f[0], $f[1], $f[2], $f[3], $idx + 1, $f[4]]);
                    $fid = $db->lastInsertId();
                    if ($f[1] === 'access_mode') {
                        $modes = ['Darat (Jalan Aspal)', 'Darat (Jalan Tanah / Offroad)', 'Sungai / Perahu', 'Kombinasi Darat & Sungai', 'Udara / Helikopter'];
                        foreach ($modes as $mi => $m) { $insOpt->execute([$fid, $m, $m, $mi + 1]); }
                    } elseif ($f[1] === 'road_condition') {
                        $conds = ['Bagus / Aspal Mulus', 'Cukup Baik / Berlubang Sedang', 'Rusak / Tanah Berlumpur', 'Ekstrem / Memerlukan 4WD'];
                        foreach ($conds as $ci => $c) { $insOpt->execute([$fid, $c, $c, $ci + 1]); }
                    }
                }
            } elseif ($s['code'] === 'topology') {
                $insField->execute([$formId, $secId, 'Jenis Topologi Jaringan', 'topology_type', 'dropdown', 1, 1, null]);
                $fid = $db->lastInsertId();
                $topos = ['Star (Bintang)', 'Tree (Pohon)', 'Mesh (Jaring)', 'Point to Point (PTP)', 'Point to Multipoint (PTMP)', 'Lainnya'];
                foreach ($topos as $ti => $t) { $insOpt->execute([$fid, $t, $t, $ti + 1]); }

                $insField->execute([$formId, $secId, 'Deskripsi Singkat Topologi', 'topology_description', 'textarea', 0, 2, 'Jelaskan skema distribusi sinyal Starlink...']);
                $insField->execute([$formId, $secId, 'Catatan Khusus Topologi', 'topology_notes', 'textarea', 0, 3, null]);
            }
        }
        echo "<p class='success'>✔ Form sections & fields berhasil di-seed.</p>";
    } else {
        echo "<p class='info'>ℹ Form sections sudah ada sebelumnya.</p>";
    }
} catch (PDOException $e) {
    echo "<p class='info'>ℹ Info Form/Fields: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<h3 class='success'>🎉 SEMUA TABEL DAN SKEMA DATABASE BERHASIL DIPERBAIKI!</h3>";
echo "<p><a href='/' style='color:#38bdf8;text-decoration:underline;'>Kembali ke Formulir</a> | <a href='/admin/login' style='color:#38bdf8;text-decoration:underline;'>Login Admin</a></p>";
echo "</div></body></html>";
