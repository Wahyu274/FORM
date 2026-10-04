<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('form_fields')) {
            Schema::create('form_fields', function (Blueprint $table) {
                $table->id();
                $table->foreignId('form_id')->constrained()->onDelete('cascade');
                $table->foreignId('section_id')->constrained('form_sections')->onDelete('cascade');
                $table->string('label');
                $table->string('name'); // field key name
                $table->enum('type', [
                    'text', 'textarea', 'number', 'date', 
                    'dropdown', 'radio', 'checkbox', 
                    'file', 'image', 'gps_location'
                ])->default('text');
                $table->boolean('is_required')->default(false);
                $table->boolean('is_active')->default(true);
                $table->integer('sort_order')->default(0);
                $table->string('placeholder')->nullable();
                $table->string('help_text')->nullable();
                $table->string('default_value')->nullable();
                $table->json('validation_rules')->nullable();
                $table->json('options')->nullable(); // static json options if not using options table
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('form_field_options')) {
            Schema::create('form_field_options', function (Blueprint $table) {
                $table->id();
                $table->foreignId('field_id')->constrained('form_fields')->onDelete('cascade');
                $table->string('label');
                $table->string('value');
                $table->integer('sort_order')->default(0);
                $table->boolean('is_active')->default(true);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('form_field_options');
        Schema::dropIfExists('form_fields');
    }
};
