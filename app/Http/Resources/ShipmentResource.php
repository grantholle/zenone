<?php

namespace App\Http\Resources;

use App\Models\Shipment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @property-read Shipment $resource */
class ShipmentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->resource->id,
            'tracking_number' => $this->resource->tracking_number,
            'status' => $this->resource->status,
            'weight' => $this->resource->weight,
            'origin' => $this->resource->origin,
            'destination' => $this->resource->destination,
        ];
    }
}
