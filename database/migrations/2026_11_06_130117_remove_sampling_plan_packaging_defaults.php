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
        Schema::table('sampling_plans', function (Blueprint $table) {
            $table->unsignedInteger('bundles_per_box')->nullable()->default(null)->change();
            $table->unsignedInteger('notes_per_bundle')->nullable()->default(null)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('sampling_plans', function (Blueprint $table) {
            $table->unsignedInteger('bundles_per_box')->default(50)->change();
            $table->unsignedInteger('notes_per_bundle')->default(1000)->change();
        });
    }
};
