<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        #return parent::toArray($request);
		return [
			'ciudad'      => $this->resource['name'],
			'temperatura' => $this->resource['main']['temp'] . '°C',
			'sensacion'   => $this->resource['main']['feels_like'] . '°C',
			'descripcion' => ucfirst($this->resource['weather'][0]['description']),
			'humedad'     => $this->resource['main']['humidity'] . '%',
			'viento'      => $this->resource['wind']['speed'] . ' m/s',
		];
    }
}
