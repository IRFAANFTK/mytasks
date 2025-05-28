<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    protected $apiKey;
    protected $baseUrl = 'https://api.tomorrow.io/v4/timelines';

    public function __construct()
    {
        $this->apiKey = config('services.tomorrow.api_key');
    }

    public function getForecast(float $latitude, float $longitude): ?array
    {
        $response = Http::withHeaders([
            'accept' => 'application/json',
            'apikey' => $this->apiKey,
        ])->get($this->baseUrl, [
            'location' => "{$latitude},{$longitude}",
            'fields' => 'temperature,humidity', // <-- FIXED HERE
            'units' => 'metric',
            'timesteps' => '1h',
        ]);

        if ($response->successful()) {
            \Log::info('Weather API Success', $response->json());
            return $response->json();
        }

        \Log::error('Weather API Failed', [
            'status' => $response->status(),
            'body' => $response->body(),
        ]);

        return null;
    }
}
