<?php

namespace Tests\Unit;

use App\Services\LocationResolverService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class LocationResolverServiceTest extends TestCase
{
    public function test_city_coords_resolve()
    {
        $url = Config::get("app.google_maps_api_url");
        $cityName = "Warner, NH";
        $query = http_build_query([
            "address" => $cityName,
            "key" => Config::get("app.google_maps_api_key"),
        ]);
        Http::fake([
            $url . "?" . $query =>
                Http::response([
                    "results" => [
                        0 => [
                            "geometry" => [
                                "location" => [
                                    "lat" => 43.2556568,
                                    "lng" => -71.8334145
                                ]
                            ]
                        ]
                    ]
                ])
        ]);
        $result = (new LocationResolverService())->getCityCoordinates($cityName);
        $this->assertEquals([
            "lat" => 43.2556568,
            "lng" => -71.8334145,
        ], $result);
    }

    public function test_result_is_cached()
    {
        $url = Config::get("app.google_maps_api_url");
        $cityName = "Warner, NH";
        $query = http_build_query([
            "address" => $cityName,
            "key" => Config::get("app.google_maps_api_key"),
        ]);
        Http::fake([
            $url . "?" . $query =>
                Http::response([
                    "results" => [
                        0 => [
                            "geometry" => [
                                "location" => [
                                    "lat" => 43.2556568,
                                    "lng" => -71.8334145
                                ]
                            ]
                        ]
                    ]
                ])
        ]);
        (new LocationResolverService())->getCityCoordinates($cityName);
        $this->assertEquals([
            "lat" => 43.2556568,
            "lng" => -71.8334145,
        ], Cache::get($cityName));
        $result = (new LocationResolverService())->getCityCoordinates($cityName);
        $this->assertEquals(Cache::get($cityName), $result);
    }

    public function test_unresolved_address_is_caught()
    {
        $url = Config::get("app.google_maps_api_url");
        $cityName = "Spring City, MS";
        $query = http_build_query([
            "address" => $cityName,
            "key" => Config::get("app.google_maps_api_key"),
        ]);
        Http::fake([
            $url . "?" . $query =>
                Http::response([])
        ]);
        $result = (new LocationResolverService())->getCityCoordinates($cityName);
        $this->assertEquals([], $result);
    }
}
