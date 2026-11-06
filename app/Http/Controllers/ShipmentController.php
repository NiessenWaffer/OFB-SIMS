<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreShipmentRequest;
use App\Http\Requests\UpdateShipmentRequest;
use App\Models\Shipment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): Response
    {
        $search = $request->string('search')->trim()->toString();

        return Inertia::render('shipments/Index', [
            'shipments' => Shipment::query()
                ->when($search !== '', function ($query) use ($search): void {
                    $query->where(function ($query) use ($search): void {
                        $query->where('delivery_reference', 'like', "%{$search}%")
                            ->orWhere('denomination', 'like', "%{$search}%")
                            ->orWhere('supplier_name', 'like', "%{$search}%");
                    });
                })
                ->latest()
                ->paginate(15)
                ->withQueryString(),
            'search' => $search,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        return Inertia::render('shipments/Create');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shipment $shipment): Response
    {
        return Inertia::render('shipments/Edit', [
            'shipment' => $shipment,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreShipmentRequest $request): RedirectResponse
    {
        $shipment = Shipment::create($request->validated());

        return to_route('shipments.show', $shipment)
            ->with('success', 'Shipment created successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateShipmentRequest $request, Shipment $shipment): RedirectResponse
    {
        $shipment->update($request->validated());

        return to_route('shipments.show', $shipment)
            ->with('success', 'Shipment updated successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shipment $shipment): Response
    {
        return Inertia::render('shipments/Show', [
            'shipment' => $shipment,
        ]);
    }
}
