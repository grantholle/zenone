<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ShipmentResource;
use App\Models\Shipment;
use Illuminate\Http\Request;

class ShipmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        $shipments = $user->shipments()
            ->orderBy('created_at', 'desc')
            ->paginate();

        return ShipmentResource::collection($shipments);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'tracking_number' => ['required', 'string', 'unique:shipments,tracking_number'],
        ]);

        $user = $request->user();
        $shipment = $user->shipments()->create($data);
        $shipment->cacheFromUps();

        return new ShipmentResource($shipment);
    }

    /**
     * Display the specified resource.
     */
    public function show(Shipment $shipment)
    {
        return (new ShipmentResource($shipment))
            ->additional(['activity' => $shipment->getActivity()]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Shipment $shipment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Shipment $shipment)
    {
        //
    }
}
