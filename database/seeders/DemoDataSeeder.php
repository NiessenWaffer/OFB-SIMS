<?php

namespace Database\Seeders;

use App\Models\SamplingPlan;
use App\Models\Shipment;
use Illuminate\Database\Seeder;

class DemoDataSeeder extends Seeder
{
    public function run(): void
    {
        $shipment = Shipment::firstOrCreate(
            ['delivery_reference' => 'DEMO - 6th Delivery'],
            [
                'denomination' => '100-Piso',
                'currency_series' => 'eNGC',
                'yearmark' => '2026',
                'supplier_name' => 'Demonstration Supplier',
                'total_boxes' => 1400,
                'total_notes' => 70000000,
                'first_box_code' => '2026-TE-15601',
                'last_box_code' => '2026-TE-17000',
                'documents_received_date' => '2026-01-22',
                'delivery_date' => '2026-01-25',
            ],
        );

        SamplingPlan::firstOrCreate(
            [
                'shipment_id' => $shipment->id,
                'status' => 'draft',
            ],
            [
                'standard_ref' => null,
                'target_sample_boxes' => 200,
                'target_sample_bundles' => 315,
                'target_sample_notes' => 1250,
                'bundles_per_box' => 50,
                'notes_per_bundle' => 1000,
            ],
        );
    }
}
