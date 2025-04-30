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



    public function getFilmData($id)
    {
        // (valider $id si vous voulez)
        $adress = env('TOAD_SERVER');
        $port = env('TOAD_PORT');
        $servRequest = $adress.$port;
        $endpointGetFilm="/toad/film/getById?id=";
        $query=['id'=>$id];
        $url=$servRequest.$endpointGetFilm;

        Log::info('→ HTTP GET vers remote API', [
            'url'   => $url,
            'query' => $query,
        ]);
        

        // Appel à l’API distante
        $resp = Http::get($url,$query);
        Log::info('← Réponse remote API', [
            'status'   => $resp->status(),
            'response' => $resp->body(),
        ]);
        
        if ($resp->failed()) {
            Log::error('getFilmData a retourné une erreur', [
                'url'      => $url,
                'query'    => $query,
                'status'   => $resp->status(),
                'response' => $resp->body(),
              ]);
            return response()->json(['error'=>'Film introuvable'], 404);
        }

        // On renvoie directement le JSON côté front
        return response()->json($resp->json());
    }

    public function updateFilm(Request $request)
    {
        // 1) Validation des données
        $data = $request->validate([
            'id'                => 'required|integer',
            'title'             => 'required|string|max:255',
            'description'       => 'required|string',
            'releaseYear'       => 'required|integer',
            'languageId'        => 'required|integer',
            'originalLanguageId'=> 'nullable|integer',
            'rentalDuration'    => 'required|integer',
            'rentalRate'        => 'required|numeric',
            'length'            => 'nullable|integer',
            'replacementCost'   => 'required|numeric',
            'rating'            => 'required|string|max:10',
        ]);
        $payload = [
            'title'             => $data['title'],
            'description'       => $data['description'],
            'releaseYear'       => $data['releaseYear'],
            'languageId'        =>$data['languageId'],
            'originalLanguageId'=> $data['originalLanguageId'] ?? 0,
            'rentalDuration'    => $data['rentalDuration'],
            'rentalRate'        => $data['rentalRate'],
            'length'            => $data['length'] ?? 0,
            'replacementCost'   => $data['replacementCost'],
            'rating'            => $data['rating'],
            // lastUpdate attendu
            'lastUpdate'        => now()->toDateTimeString(),
          ];

        // 2) Construction de l'URL de l'API distante
        $adress = env('TOAD_SERVER');
        $port = env('TOAD_PORT');
        $servRequest = $adress.$port;
        $id       = $data['id'];
        $endpointUpdateFilm="/toad/film/update/{$id}";
        $url=$servRequest.$endpointUpdateFilm;
        
        Log::info('→ Remote updateFilm request', [
            'url'  => $url,
            'data' => $data,
        ]);

        // 3) Envoi de la requête PUT ou POST à l'API (ici POST JSON)
        $response = Http::asForm()->put($url, $payload);

        Log::info('Remote updateFilm response', [
            'status'   => $response->status(),
            'response' => $response->body(),
          ]);
      

        // 4) Gestion du retour
        if ($response->failed()) {
            $message = $response->json('message') 
                 ?? 'Échec de la mise à jour';
        // Toujours renvoyer du JSON avec un code erreur
        return response()->json([
            'success' => false,
            'message' => $message,
        ], 400);
        }

        // 5) En cas de succès, flash message et retour
        return response()->json([
            'success' => true,
            'message' => 'Film mis à jour avec succès !',
        ]);
    }
}


