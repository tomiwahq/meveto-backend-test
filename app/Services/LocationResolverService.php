<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LocationResolverService
{
    private string $locUrl = "https://maps.googleapis.com/maps/api/geocode/json";

    /**
     * @param string $cityName
     * @return string[]
     */
    public function getCityCoordinates(string $cityName): array
    {
        if (Cache::has($cityName)) {
            return Cache::get($cityName);
        }
        $coordinates = $this->resolveCity($cityName);
        Cache::put($cityName, $coordinates);
        return $coordinates;
    }

    private function resolveCity(string $cityName)
    {
        $query = http_build_query([
            "address" => $cityName,
            "key" => Config::get("app.google_maps_api_key"),
        ]);
        $response = Http::post($this->locUrl . "?" . $query)->json();
        try {
            return $response["results"][0]["geometry"]["location"];
        } catch (\Exception $exception) {
            Log::error($exception->getMessage(), ["exception" => $exception]);
            return [];
        }
    }
}
