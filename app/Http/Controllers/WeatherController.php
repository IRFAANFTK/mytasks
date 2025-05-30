<?php

namespace App\Http\Controllers;

use App\Services\WeatherService;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Http;

class WeatherController extends Controller

{

    protected $weatherService;

    public function __construct(WeatherService $weatherService)

    {

        $this->weatherService = $weatherService;

    }

    public function forecast(Request $request)

    {

        $lat = $request->query('lat');

        $lon = $request->query('lon');

        if (!$lat || !$lon) {

            return response()->json(['error' => 'Missing coordinates!'], 400);

        }


        $weather = $this->weatherService->getForecast($lat, $lon);



        $locationName = 'Votre position';

        $geoRes = Http::get("https://api.opencagedata.com/geocode/v1/json", [
            'q' => "$lat,$lon",
            'key' => env('OPENCAGE_API_KEY'),
            'language' => 'en',
            'pretty' => 1,
            'no_annotations' => 1
        ]);

        if ($geoRes->successful()) {
            $geoData = $geoRes->json();
            $locationName = $geoData['results'][0]['components']['city'] ??
                $geoData['results'][0]['components']['town'] ??
                $geoData['results'][0]['components']['village'] ??
                $geoData['results'][0]['components']['suburb'] ??
                $geoData['results'][0]['components']['neighbourhood'] ??
                $geoData['results'][0]['components']['county'] ??
                $geoData['results'][0]['components']['state'] ??
                'Votre position';
        }

        return response()->json([

            'weather' => $weather,

            'location' => $locationName

        ]);

    }

}

