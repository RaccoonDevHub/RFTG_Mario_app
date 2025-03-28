<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use PhpParser\Node\Expr\AssignOp\Concat;
use PhpParser\Node\Expr\BinaryOp\Concat as BinaryOpConcat;

class FilmController extends Controller
{
    public function store(Request $request)
    {
        // Récupérer les données envoyées depuis le formulaire
        $data = $request->all();
        $adress = env('TOAD_SERVER');
        $port = env('TOAD_PORT');
        $endpointAddFilm ='/toad/film/add';
        $servRequest = $adress.$port;
        $lastUpdate = Carbon::now()->format('Y-m-d H:i:s'); // Format attendu : 'YYYY-MM-DD HH:MM:SS'
    
        $data['lastUpdate'] = $lastUpdate;
        // Envoyer ces données à l’API Spring
        $response = Http::asForm()->post($servRequest.$endpointAddFilm,$data);
        Log::info('Données envoyées à l\'API :', $data);
        Log::info('Réponse de l\'API : ' . $response->body());

        // Vérifier si l'API a bien répondu
        if ($response->successful()) {
            return response()->json(['message' => 'Film ajouté avec succès !']);
        } else {
            return response()->json(['message' => 'Erreur lors de l\'ajout du film'], 500);
        }
    }

    public function deleteFilm(Request $request)
    {
        $adress = env('TOAD_SERVER');
        $port = env('TOAD_PORT');
        $servRequest = $adress.$port;
        $filmIds = $request->input('filmIds');

    if (!is_array($filmIds) || empty($filmIds)) {
        return response()->json(['success' => false, 'message' => 'Aucun film sélectionné.']);
    }

    $endpointDeleteFilm = '/toad/film/delete/'. implode(',', $filmIds);;

    // Appel à l'API Java
    $response = Http::delete($servRequest.$endpointDeleteFilm);
    Log::info('URL finale : ' . $servRequest.$endpointDeleteFilm);
    Log::info('Film IDs : ', ['filmIds' => $filmIds]);
    Log::info('Réponse de l’API : ' . $response->body());

    if ($response->successful()) {
        return response()->json(['success' => true, 'message' => 'Films supprimés avec succès.']);
    } else {
        return response()->json(['success' => false, 'message' => 'Erreur lors de la suppression.']);
    }
    }

    public function updateFilm(Request $request)
    {
        $adress = env('TOAD_SERVER');
        $port = env('TOAD_PORT');
        $servRequest = $adress.$port;
        
    }
}   

