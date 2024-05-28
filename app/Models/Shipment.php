<?php

namespace App\Models;

use App\Services\UpsApiService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;

class Shipment extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function getRouteKeyName(): string
    {
        return 'tracking_number';
    }

    public function scopeTracking(Builder $builder, string $trackingNumber): void
    {
        $builder->where('tracking_number', $trackingNumber);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function fetchFromUps(): array
    {
        if (! $this->tracking_number) {
            return [];
        }

        /** @var Response $response */
        $response = app(UpsApiService::class)
            ->get("/api/track/v1/details/{$this->tracking_number}");

        if ($response->failed()) {
            return [];
        }

        return $response->json();
    }

    public function cacheFromUps(): static
    {
        $data = $this->fetchFromUps();

        if (empty($data)) {
            return $this;
        }

        $package = Arr::get($data, 'trackResponse.shipment.0.package.0');
        $addresses = Arr::get($package, 'packageAddress', []);
        $origin = collect($addresses)
            ->firstWhere('type', 'ORIGIN') ?? [];
        $destination = collect($addresses)
            ->firstWhere('type', 'DESTINATION') ?? [];

        $this->update([
            'status' => Arr::get($package, 'currentStatus.description'),
            'weight' => Arr::get($package, 'weight.weight'),
            'origin' => $this->parseAddress($origin),
            'destination' => $this->parseAddress($destination),
        ]);

        return $this;
    }

    public function parseAddress(array $address): ?string
    {
        if (! isset($address['city']) && ! isset($address['country'])) {
            return null;
        }

        if (! isset($address['country'])) {
            return $address['city'];
        }

        return "{$address['city']}, {$address['country']}";
    }

    public function getActivity(): array
    {
        return Arr::get($this->fetchFromUps(), 'trackResponse.shipment.0.package.0.activity', []);
    }
}
