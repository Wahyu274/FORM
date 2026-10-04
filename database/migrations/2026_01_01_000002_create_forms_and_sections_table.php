<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('forms')) {
            Schema::create('forms', function (Blueprint $table) {
                $table->id();
                $table->string('title');
                $table->string('slug')->unique();
                $table->string('code_prefix')->default('INV-KAL');
                $table->text('description')->nullable();
                $table->boolean('is_active')->default(true);
                $table->integer('max_clients_per_antenna')->default(25);
                $table->json('settings')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('form_sections')) {
            Schema::create('form_sections', function (Blueprint $table) {
                $table->id();
                $table->foreignId('form_id')->constrained()->onDelete('cascade');
                $table->string('title');
                $table->string('code')->nullable(); // location, access, topology, devices, antenna, additional, documentation
                $table->text('description')->nullable();
                $table->integer('sort_order')->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('form_sections');
        Schema::dropIfExists('forms');
    }
};
