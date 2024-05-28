<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class UpsApiService
{
    const CACHE_KEY = 'ups-api-token';

    protected PendingRequest $client;

    public function __construct(protected string $clientId, protected string $clientSecret)
    {
        $this->setClient();
    }

    public function setClient(): static
    {
        $this->client = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
            'transId' => Str::uuid()->toString(),
            'transactionSrc' => 'testing',
        ])->baseUrl(config('services.ups.url'));

        return $this->setToken();
    }

    protected function setToken(): static
    {
        if ($token = Cache::get(self::CACHE_KEY)) {
            $this->client->withToken($token);
            return $this;
        }

        return $this->generateToken();
    }

    public function client(): PendingRequest
    {
        return $this->client;
    }

    protected function generateToken(): static
    {
        $response = Http::withBasicAuth($this->clientId, $this->clientSecret)
            ->asForm()
            ->baseUrl(config('services.ups.url'))
            ->post('/security/v1/oauth/token', [
                'grant_type' => 'client_credentials',
            ]);

        if (! $response->successful()) {
            throw new \Exception('Failed to generate UPS API token: '.$response->body());
        }

        Cache::put(self::CACHE_KEY, $response->json('access_token'), $response->json('expires_in'));

        return $this->setClient();
    }
}
