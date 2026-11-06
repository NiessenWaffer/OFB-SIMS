<?php

namespace App\Http\Controllers;

use App\Models\SamplingPlan;
use App\Models\Shipment;
use Inertia\Inertia;
use Inertia\Response;

class SamplingPlanController extends Controller
{
    public function index(Shipment $shipment): Response
    {
        return Inertia::render('sampling-plans/Index', [
            'shipment' => $shipment,
            'plans' => SamplingPlan::query()
                ->whereBelongsTo($shipment)
                ->latest()
                ->paginate(15),
        ]);
    }

    public function show(Shipment $shipment, SamplingPlan $samplingPlan): Response
    {
        $samplingPlan = SamplingPlan::query()
            ->whereBelongsTo($shipment)
            ->findOrFail($samplingPlan->getKey());

        return Inertia::render('sampling-plans/Show', [
            'shipment' => $shipment,
            'samplingPlan' => $samplingPlan,
        ]);
    }
}
