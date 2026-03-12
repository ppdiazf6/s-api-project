<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Services\WeatherService;
use App\Http\Resources\WeatherResource;

class WeatherController extends Controller
{
	protected $weatherService;

    public function __construct(WeatherService $weatherService)
    {
        $this->weatherService = $weatherService;
    }

    public function showAll(Request $request)
    {
        $city = $request->query('city', 'Bogota');

        try {
            $data = $this->weatherService::getWeatherByCity($city);
            return response()->json([
                'status' => 'success',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            $code = ($e->getCode() >= 400 && $e->getCode() < 600) ? $e->getCode() : 500;
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], $code);
        }
    }
	
	public function show(Request $request)
	{
		$city = $request->query('city', 'Bogota');

		try {
			$data = $this->weatherService->getWeatherByCity($city);
			
			return new WeatherResource($data);
		} catch (\Exception $e) {
			#return response()->json(['error' => $e->getMessage()], 500);
			Log::error("Error de conexión: " . $e->getMessage());
			return response()->json(['error' => 'Error de conexión con la API de clima'], 500);
		}
	}
    //
}
