<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('sampling_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shipment_id')->constrained()->cascadeOnDelete();
            $table->string('standard_ref', 100)->nullable();
            $table->unsignedInteger('target_sample_boxes')->nullable();
            $table->unsignedInteger('target_sample_bundles')->nullable();
            $table->unsignedInteger('target_sample_notes')->nullable();
            $table->unsignedInteger('bundles_per_box')->default(50);
            $table->unsignedInteger('notes_per_bundle')->default(1000);
            $table->string('status', 50)->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sampling_plans');
    }
};
