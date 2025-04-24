<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;
use PhpParser\Node\Expr\AssignOp\Concat;
use PhpParser\Node\Expr\BinaryOp\Concat as BinaryOpConcat;
use App\Models\Film;
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



    public function edit(Request $request)
    {
        // 1. On valide qu'on a bien un ID numérique
        $request->validate([
            'id' => 'required|integer',
        ]);

        // 2. On construit l’URL de votre API (TOAD_SERVER + TOAD_PORT)
        $base = config('app.TOAD_SERVER') . ':' . config('app.TOAD_PORT');

        // 3. On appelle l’endpoint pour récupérer 1 film
        $respEdit = Http::get("{$base}/api/films/{$request->id}");
        if ($respEdit->failed()) {
            abort(404, 'Film introuvable');
        }

        // 4. On decode en objet PHP
        $editFilm = json_decode($respEdit->body());

        // 5. (Optionnel) on récupère aussi toute la liste pour l’affichage
        $respList = Http::get("{$base}/api/films");
        if ($respList->failed()) {
            abort(500, 'Impossible de charger la liste des films');
        }
        // ici on récupère un tableau d’objets
        $films = json_decode($respList->body());

        // 6. On renvoie la même vue, avec les deux variables
        return view('films.index', compact('films','editFilm'));
    }

    public function updateFilm(Request $request)
    {
        $data = $request->validate([
            'id'                => 'required|integer',
            'title'             => 'required|string',
            'description'       => 'required|string',
            'releaseYear'       => 'required|integer',
            'languageId'        => 'required|integer',
            'originalLanguageId'=> 'nullable|integer',
            'rentalDuration'    => 'required|integer',
            'rentalRate'        => 'required|numeric',
            'length'            => 'nullable|integer',
            'replacementCost'   => 'required|numeric',
            'rating'            => 'required|string',
            'lastUpdate'        => 'required|date',
            'idDirector'        => 'required|integer',
        ]);

        $base = config('app.TOAD_SERVER') . ':' . config('app.TOAD_PORT');

        // On envoie en POST ou PUT selon votre API
        $resp = Http::asJson()->post("{$base}/api/films/update", $data);

        if ($resp->failed()) {
            return back()->withErrors('Échec de la mise à jour');
        }

        return back()->with('success','Film mis à jour !');
    }
} 

