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
        Schema::create('shipments', function (Blueprint $table) {
            $table->id();
            $table->string('denomination', 50);
            $table->string('currency_series', 100);
            $table->string('yearmark', 20);
            $table->string('supplier_name');
            $table->string('delivery_reference', 100);
            $table->unsignedInteger('total_boxes');
            $table->unsignedBigInteger('total_notes');
            $table->string('first_box_code', 100);
            $table->string('last_box_code', 100);
            $table->date('documents_received_date')->nullable();
            $table->date('delivery_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipments');
    }
};
