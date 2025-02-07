<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FilmController extends Controller
{
    public function store(Request $request)
    {
        // Récupérer les données envoyées depuis le formulaire
        $data = $request->all();

        // Envoyer ces données à l’API Spring
        $response = Http::post('http://localhost:8080/toad/film/add', $data);

        // Vérifier si l'API a bien répondu
        if ($response->successful()) {
            return response()->json(['message' => 'Film ajouté avec succès !']);
        } else {
            return response()->json(['message' => 'Erreur lors de l\'ajout du film'], 500);
        }
    }
}
