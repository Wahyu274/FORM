<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Core Responses Table
        if (!Schema::hasTable('responses')) {
            Schema::create('responses', function (Blueprint $table) {
                $table->id();
                $table->foreignId('form_id')->constrained()->onDelete('cascade');
                $table->string('response_code')->unique(); // e.g. INV-KAL-2026-00001
                $table->string('location_name');
                $table->string('regency');
                $table->string('province')->default('Kalimantan');
                $table->string('pic_name');
                $table->string('pic_phone');
                $table->integer('total_devices')->default(0);
                $table->integer('total_antennas')->default(0);
                $table->integer('total_clients')->default(0);
                $table->enum('status', ['submitted', 'verified', 'archived', 'draft'])->default('submitted');
                $table->string('ip_address')->nullable();
                $table->text('user_agent')->nullable();
                $table->timestamp('submitted_at')->useCurrent();
                $table->timestamps();
            });
        }

        // Dynamic Key-Value Response Values
        if (!Schema::hasTable('response_values')) {
            Schema::create('response_values', function (Blueprint $table) {
                $table->id();
                $table->foreignId('response_id')->constrained('responses')->onDelete('cascade');
                $table->foreignId('field_id')->nullable()->constrained('form_fields')->onDelete('set null');
                $table->string('field_name');
                $table->text('value')->nullable();
                $table->timestamps();
            });
        }

        // Section 1 & 2: Relational Location Details
        if (!Schema::hasTable('locations')) {
            Schema::create('locations', function (Blueprint $table) {
                $table->id();
                $table->foreignId('response_id')->constrained('responses')->onDelete('cascade');
                $table->string('instance_name');
                $table->text('address');
                $table->string('regency');
                $table->string('province');
                $table->string('pic_name');
                $table->string('pic_position')->nullable();
                $table->string('pic_phone');
                $table->string('pic_email')->nullable();
                
                // Jarak & Akses
                $table->decimal('distance_km', 8, 2)->nullable();
                $table->string('distance_unit')->default('km');
                $table->string('access_mode')->nullable(); // Akses menuju lokasi
                $table->string('road_condition')->nullable(); // Kondisi jalan
                $table->string('vehicle_type')->nullable(); // Kendaraan
                $table->string('travel_time')->nullable(); // Estimasi waktu
                $table->decimal('latitude', 10, 8)->nullable();
                $table->decimal('longitude', 11, 8)->nullable();
                $table->text('access_notes')->nullable();
                $table->timestamps();
            });
        }

        // Section 3: Topology Information
        if (!Schema::hasTable('topologies')) {
            Schema::create('topologies', function (Blueprint $table) {
                $table->id();
                $table->foreignId('response_id')->constrained('responses')->onDelete('cascade');
                $table->string('topology_type'); // Star, Tree, Mesh, Point to Point, Point to Multipoint, Lainnya
                $table->text('description')->nullable();
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }

        // Section 4: Network Devices (Dynamic Table)
        if (!Schema::hasTable('devices')) {
            Schema::create('devices', function (Blueprint $table) {
                $table->id();
                $table->foreignId('response_id')->constrained('responses')->onDelete('cascade');
                $table->string('device_type'); // Modem/ONT, Router, Switch, Access Point, Antena, CPE/Bridge, PoE Injector, UPS/Power, Kabel UTP, Modem Internet, Lainnya
                $table->string('brand')->nullable();
                $table->string('model')->nullable();
                $table->integer('quantity')->default(1);
                $table->text('specs')->nullable();
                $table->string('condition')->nullable(); // Baik, Rusak Ringan, Rusak Berat, Perlu Peremajaan
                $table->text('notes')->nullable();
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }

        // Section 5: Antenna and Client Data
        if (!Schema::hasTable('antennas')) {
            Schema::create('antennas', function (Blueprint $table) {
                $table->id();
                $table->foreignId('response_id')->constrained('responses')->onDelete('cascade');
                $table->string('antenna_code'); // Antena 1, Antena 2, etc.
                $table->string('brand_model')->nullable();
                $table->string('frequency')->nullable(); // e.g. 5GHz, 2.4GHz
                $table->string('install_location')->nullable(); // Tower main, tiang 12m, rooftop
                $table->integer('client_count')->default(0);
                $table->integer('max_clients')->default(25);
                $table->text('notes')->nullable();
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }

        // Documentation Uploads Table
        if (!Schema::hasTable('uploads')) {
            Schema::create('uploads', function (Blueprint $table) {
                $table->id();
                $table->foreignId('response_id')->constrained('responses')->onDelete('cascade');
                $table->string('field_name'); // foto_lokasi, topology_file, foto_perangkat, foto_antena, etc.
                $table->string('category')->default('dokumentasi'); // topology, photo, document
                $table->string('original_name');
                $table->string('filename');
                $table->string('filepath');
                $table->string('mime_type')->nullable();
                $table->unsignedBigInteger('file_size')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('uploads');
        Schema::dropIfExists('antennas');
        Schema::dropIfExists('devices');
        Schema::dropIfExists('topologies');
        Schema::dropIfExists('locations');
        Schema::dropIfExists('response_values');
        Schema::dropIfExists('responses');
    }
};
