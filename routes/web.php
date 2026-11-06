<?php

use App\Http\Controllers\SamplingPlanController;
use App\Http\Controllers\ShipmentController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return to_route('shipments.index');
});

Route::resource('shipments', ShipmentController::class)
    ->only(['index', 'create', 'store', 'show', 'edit', 'update']);

Route::get('/shipments/{shipment}/plans', [SamplingPlanController::class, 'index'])
    ->name('shipments.plans.index');

Route::get('/shipments/{shipment}/plans/{samplingPlan}', [SamplingPlanController::class, 'show'])
    ->name('shipments.plans.show');
