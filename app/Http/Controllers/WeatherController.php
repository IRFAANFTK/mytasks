<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\User;
use App\Services\WeatherService;

class WeatherController extends Controller
{
    protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function forecast()
    {

        $latitude = 20.1609;
        $longitude = 57.5012;

        $data = $this->weatherService->getForecast($latitude, $longitude);

        if (!$data) {
            return response()->json(['error' => 'Unable to fetch weather data'], 500);
        }

        return response()->json($data);
    }
}
