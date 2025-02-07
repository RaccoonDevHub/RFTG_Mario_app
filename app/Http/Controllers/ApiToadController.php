<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiToadController extends Controller
{
    public function ApiToad($view ='Films') 
    {
        $currentPage = request()->input('page', 1);
        $perPage = 20;
       // Remplace l'URL par celle de ton fichier JSON
        $url = 'http://localhost:8080/toad/film/all'; // ou l'URL de ton API
        $response = Http::withoutVerifying()->get($url);

        // Vérifie si la réponse est correcte
        if ($response->successful()) {
            $jsonData = $response->json();

            $films = collect($jsonData);

            $currentPageItems = $films->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $paginatedFilms = new LengthAwarePaginator(
                $currentPageItems,
                $films->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        if (request()->ajax()) {
            return view('filmsList', ['films' => $paginatedFilms]);
        }
            return view($view, ['films' => $paginatedFilms]);
        } else {
            // dd($response->body());
            return response()->json(['error' => 'Erreur lors de la récupération des données'], $response->status());
        }
    }

    public function ApiToadCatalogue() {
        
    }
}   
