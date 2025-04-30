<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Carbon;

class inventoryController extends Controller
{
    public function getInventory($view='inventory')
    {
        $currentPage = request()->input('page', 1);
        $perPage = 20;
        $adress = env('TOAD_SERVER');
        $port = env('TOAD_PORT');
        $servRequest = $adress.$port;
       // Remplace l'URL par celle de ton fichier JSON
        $url = $servRequest.'/toad/inventory/stockFilm';

        $resp = http::get($url);

        if (! $resp->ok()) {
            abort(502, "Impossible de charger l'inventaire ({$resp->status()})");
        }

        // 2) On récupère le JSON sous forme de tableau associatif
        $stock = $resp->json();

        $data = collect($stock);

            $currentPageItems = $data->slice(($currentPage - 1) * $perPage, $perPage)->values();

            $paginatedInventory = new LengthAwarePaginator(
                $currentPageItems,
                $data->count(),
                $perPage,
                $currentPage,
                ['path' => request()->url(), 'query' => request()->query()]
            );
        if (request()->ajax()) {
            return view('inventory.List', ['inventory' => $paginatedInventory]);
        }
            return view('inventory', ['stock' => $paginatedInventory]);
   
    }
    public function storeInventory(Request $request)
    {
        // 1) Valide les champs envoyés par le formulaire (IDs en camelCase côté Blade)
        $validated = $request->validate([
            'filmId'  => 'required|integer',
            'storeId' => 'required|integer',
            // si tu veux gérer quantity :
            'quantity'=> 'sometimes|integer|min:1',
        ]);

        // 2) Prépare le payload pour Spring (snake_case et bon format pour last_update)
        $payload = [
            'film_id'     => $validated['filmId'],
            'store_id'    => $validated['storeId'],
            'last_update' => Carbon::now()->format('Y-m-d H:i:s'),
            // 'quantity' => $validated['quantity'], // enlève si Spring ne gère pas
        ];

        // 3) Envoi en application/x-www-form-urlencoded
        $address   = env('TOAD_SERVER') . env('TOAD_PORT');
        $endpoint  = '/toad/inventory/add';
        $response  = Http::asForm()->post($address . $endpoint, $payload);

        // 4) Logs debug
        Log::info('→ POST addInventory', ['payload' => $payload]);
        Log::info('← Spring response', [
            'status' => $response->status(),
            'body'   => $response->body()
        ]);

        // 5) Retourne du JSON
        if ($response->successful()) {
            return response()->json(['message' => 'Exemplaire ajouté au stock !']);
        }

        return response()->json([
            'message' => 'Erreur API : ' . $response->body()
        ], 500);
    }

     public function deleteInventory(Request $request)
    {
        $adress = env('TOAD_SERVER');
        $port = env('TOAD_PORT');
        $servRequest = $adress.$port;
        $filmIds = $request->input('filmIds');

    if (!is_array($filmIds) || empty($filmIds)) {
        return response()->json(['success' => false, 'message' => 'Aucun film sélectionné.']);
    }

    $endpointDeleteFilm = '/toad/inventory/delete/'. implode(',', $filmIds);;

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

}