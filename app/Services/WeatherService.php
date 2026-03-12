<?php 

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class WeatherService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.openweather.key');
        $this->baseUrl = config('services.openweather.url');
    }

    public function getWeatherByCity(string $city)
    {
        // Cache para no saturar la API externa
        return Cache::remember("weather_$city", 600, function () use ($city) {
			//	withoutVerifying para probar en local 
            $response = Http::withoutVerifying()->get("{$this->baseUrl}/weather", [
                'q' => $city,
                'appid' => $this->apiKey,
                'units' => 'metric',
                'lang' => 'es'
            ]);

            if ($response->failed()) {
                Log::error("Error consultando clima para $city", [
                    'status' => $response->status(),
                    'body' => $response->json()
                ]);
                
                throw new \Exception("No se pudo obtener el clima", $response->status());
            }

            return $response->json();
        });
    }
}


?>