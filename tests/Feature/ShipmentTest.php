<?php

namespace Tests\Feature;

use App\Models\SamplingPlan;
use App\Models\Shipment;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShipmentTest extends TestCase
{
    use RefreshDatabase;

    public function test_shipments_index_is_available_as_an_inertia_page(): void
    {
        $response = $this->get(route('shipments.index'));

        $response->assertOk()
            ->assertInertia(fn ($page) => $page->component('shipments/Index'));
    }

    public function test_shipment_can_be_created_and_viewed(): void
    {
        $shipmentData = [
            'denomination' => '100-Piso',
            'currency_series' => 'eNGC',
            'yearmark' => '2026',
            'supplier_name' => 'Giesecke+Devrient Currency Technology GmbH',
            'delivery_reference' => '6th Delivery',
            'total_boxes' => 1400,
            'total_notes' => 70000000,
            'first_box_code' => '2026-TE-15601',
            'last_box_code' => '2026-TE-17000',
            'documents_received_date' => '2026-01-10',
            'delivery_date' => '2026-01-15',
        ];

        $response = $this->post(route('shipments.store'), $shipmentData);

        $shipment = Shipment::query()->firstOrFail();

        $response->assertRedirect(route('shipments.show', $shipment));
        $this->assertDatabaseHas('shipments', $shipmentData);

        $showResponse = $this->get(route('shipments.show', $shipment));

        $showResponse->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('shipments/Show')
                ->where('shipment.delivery_reference', '6th Delivery')
                ->where('shipment.first_box_code', '2026-TE-15601'));
    }

    public function test_shipment_creation_requires_positive_quantities_and_required_metadata(): void
    {
        $response = $this->post(route('shipments.store'), [
            'total_boxes' => 0,
            'total_notes' => -1,
        ]);

        $response->assertSessionHasErrors([
            'denomination',
            'currency_series',
            'yearmark',
            'supplier_name',
            'delivery_reference',
            'total_boxes',
            'total_notes',
            'first_box_code',
            'last_box_code',
        ]);

        $this->assertDatabaseCount('shipments', 0);
    }

    public function test_shipment_can_be_updated_with_box_codes_preserved_as_strings(): void
    {
        $shipment = Shipment::create([
            'denomination' => '100-Piso',
            'currency_series' => 'eNGC',
            'yearmark' => '2026',
            'supplier_name' => 'Original Supplier',
            'delivery_reference' => '6th Delivery',
            'total_boxes' => 1400,
            'total_notes' => 70000000,
            'first_box_code' => '2026-TE-15601',
            'last_box_code' => '2026-TE-17000',
            'documents_received_date' => '2026-01-10',
            'delivery_date' => '2026-01-15',
        ]);

        $updatedShipment = [
            'denomination' => '50-Piso',
            'currency_series' => 'Polymer',
            'yearmark' => '2027',
            'supplier_name' => 'Updated Supplier',
            'delivery_reference' => '7th Delivery',
            'total_boxes' => 1200,
            'total_notes' => 60000000,
            'first_box_code' => '2027-PM-00001',
            'last_box_code' => '2027-PM-01200',
            'documents_received_date' => '2027-02-10',
            'delivery_date' => '2027-02-15',
        ];

        $response = $this->put(route('shipments.update', $shipment), $updatedShipment);

        $response->assertRedirect(route('shipments.show', $shipment));
        $response->assertSessionHas('success', 'Shipment updated successfully.');
        $this->assertDatabaseHas('shipments', $updatedShipment);
        $this->assertSame('2027-PM-00001', $shipment->refresh()->first_box_code);
        $this->assertSame('2027-PM-01200', $shipment->last_box_code);
    }

    public function test_shipment_update_validates_positive_quantities(): void
    {
        $shipment = Shipment::create([
            'denomination' => '100-Piso',
            'currency_series' => 'eNGC',
            'yearmark' => '2026',
            'supplier_name' => 'Original Supplier',
            'delivery_reference' => '6th Delivery',
            'total_boxes' => 1400,
            'total_notes' => 70000000,
            'first_box_code' => '2026-TE-15601',
            'last_box_code' => '2026-TE-17000',
        ]);

        $response = $this->put(route('shipments.update', $shipment), [
            'total_boxes' => 0,
            'total_notes' => 0,
        ]);

        $response->assertSessionHasErrors([
            'denomination',
            'currency_series',
            'yearmark',
            'supplier_name',
            'delivery_reference',
            'total_boxes',
            'total_notes',
            'first_box_code',
            'last_box_code',
        ]);
        $this->assertSame('6th Delivery', $shipment->refresh()->delivery_reference);
    }

    public function test_sampling_plans_page_displays_the_parent_shipment_and_existing_plan(): void
    {
        $shipment = Shipment::create([
            'denomination' => '100-Piso',
            'currency_series' => 'eNGC',
            'yearmark' => '2026',
            'supplier_name' => 'Original Supplier',
            'delivery_reference' => '6th Delivery',
            'total_boxes' => 1400,
            'total_notes' => 70000000,
            'first_box_code' => '2026-TE-15601',
            'last_box_code' => '2026-TE-17000',
        ]);

        SamplingPlan::create([
            'shipment_id' => $shipment->id,
            'standard_ref' => null,
            'target_sample_boxes' => null,
            'target_sample_bundles' => null,
            'target_sample_notes' => null,
            'bundles_per_box' => 50,
            'notes_per_bundle' => 1000,
            'status' => 'draft',
        ]);

        $response = $this->get(route('shipments.plans.index', $shipment));

        $response->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('sampling-plans/Index')
                ->where('shipment.delivery_reference', '6th Delivery')
                ->has('plans.data', 1)
                ->where('plans.data.0.status', 'draft'));
    }

    public function test_sampling_plans_page_supports_empty_state(): void
    {
        $shipment = Shipment::create([
            'denomination' => '100-Piso',
            'currency_series' => 'eNGC',
            'yearmark' => '2026',
            'supplier_name' => 'Original Supplier',
            'delivery_reference' => '6th Delivery',
            'total_boxes' => 1400,
            'total_notes' => 70000000,
            'first_box_code' => '2026-TE-15601',
            'last_box_code' => '2026-TE-17000',
        ]);

        $response = $this->get(route('shipments.plans.index', $shipment));

        $response->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('sampling-plans/Index')
                ->has('plans.data', 0));
    }

    public function test_sampling_plan_details_page_displays_existing_plan_values(): void
    {
        $shipment = Shipment::create([
            'denomination' => '100-Piso',
            'currency_series' => 'eNGC',
            'yearmark' => '2026',
            'supplier_name' => 'Original Supplier',
            'delivery_reference' => '6th Delivery',
            'total_boxes' => 1400,
            'total_notes' => 70000000,
            'first_box_code' => '2026-TE-15601',
            'last_box_code' => '2026-TE-17000',
        ]);

        $samplingPlan = SamplingPlan::create([
            'shipment_id' => $shipment->id,
            'standard_ref' => null,
            'target_sample_boxes' => 200,
            'target_sample_bundles' => 315,
            'target_sample_notes' => 1250,
            'bundles_per_box' => 50,
            'notes_per_bundle' => 1000,
            'status' => 'draft',
        ]);

        $response = $this->get(route('shipments.plans.show', [$shipment, $samplingPlan]));

        $response->assertOk()
            ->assertInertia(fn ($page) => $page
                ->component('sampling-plans/Show')
                ->where('shipment.total_boxes', 1400)
                ->where('samplingPlan.target_sample_boxes', 200)
                ->where('samplingPlan.target_sample_bundles', 315)
                ->where('samplingPlan.target_sample_notes', 1250));
    }

    public function test_new_sampling_plan_does_not_receive_unapproved_packaging_defaults(): void
    {
        $shipment = Shipment::create([
            'denomination' => '100-Piso',
            'currency_series' => 'eNGC',
            'yearmark' => '2026',
            'supplier_name' => 'Original Supplier',
            'delivery_reference' => '6th Delivery',
            'total_boxes' => 1400,
            'total_notes' => 70000000,
            'first_box_code' => '2026-TE-15601',
            'last_box_code' => '2026-TE-17000',
        ]);

        $samplingPlan = SamplingPlan::create([
            'shipment_id' => $shipment->id,
        ]);

        $this->assertNull($samplingPlan->bundles_per_box);
        $this->assertNull($samplingPlan->notes_per_bundle);
        $this->assertDatabaseHas('sampling_plans', [
            'id' => $samplingPlan->id,
            'bundles_per_box' => null,
            'notes_per_bundle' => null,
        ]);
    }
}
