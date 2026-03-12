<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class MovieController extends Controller
{
	private $apiKey = 'a42394b';
	
	
	public function index(Request $request)
    {

        $request->validate([
            'search' => 'required|string|min:2|max:100'
        ]);
		
		$page = $request->get('page', 1);

        $response = Http::get('http://www.omdbapi.com/', [
            'apikey' => $this->apiKey,
            's' => $request->search,
			'page' => $page
        ]);

        if ($response->failed()) {
            return response()->json([
                'message' => 'Error consumiendo API externa'
            ], 500);
        }

        $data = $response->json();

        if (!isset($data['Search'])) {
            return response()->json([
                'message' => 'Película no encontrada'
            ], 404);
        }

        return response()->json([
			'page' => $page,
            'total_results' => $data['totalResults'],
            'movies' => $data['Search']
        ], 200);
    }
	
	//	Ver película 
	public function show($title)
    {
        $response = Http::get('http://www.omdbapi.com/', [
            'apikey' => $this->apiKey,
            't' => $title
        ]);

        if ($response->failed()) {
            return response()->json([
                'message' => 'Error consumiendo API externa'
            ], 500);
        }

        $data = $response->json();

        if (isset($data['Error'])) {
            return response()->json([
                'message' => 'No se pudo encontrar película '
            ], 404);
        }

        return response()->json($data, 200);
    }
}
