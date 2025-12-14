<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Hebergement;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException; // Utilisation du namespace correct

class HebergementController extends Controller
{
    /**
     * Display a listing of the resource.
     * OK - Méthode index laissée telle quelle, elle retourne toutes les données.
     */
    public function index()
    {
        return response()->json(Hebergement::all());
    }

    /**
     * Store a newly created resource in storage.
     * CORRIGÉ: Ajout de 'rating', 'features' et correction de 'type'.
     */
    public function store(Request $request)
    {
        try {
            // RÈGLES DE VALIDATION MISES À JOUR
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'rating' => 'nullable|numeric|min:0|max:5', // Utilisation de numeric pour la note
                'description' => 'nullable|string',
                'price' => 'nullable|string|max:50', // string pour inclure FCFA/nuit
                // CORRECTION: Suppression des espaces inutiles dans la règle 'in'
                'type' => 'nullable|in:Hôtels,Lodges Écologiques,Auberges,Stations balnéaires',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
                'features' => 'nullable|json', // NOUVEAU: Valide que les caractéristiques sont envoyées en JSON
            ]);

            $path = null;
            if ($request->hasFile('image')) {
                // S'assure que l'image est stockée
                $path = $request->file('image')->store('hebergements', 'public');
            }

            // CRÉATION DE L'HÉBERGEMENT - UTILISE TOUS LES CHAMPS VALIDÉS
            $hebergement = Hebergement::create([
                'title' => $validated['title'],
                'location' => $validated['location'],
                'rating' => $validated['rating'] ?? null,
                'description' => $validated['description'],
                'price' => $validated['price'],
                'type' => $validated['type'] ?? 'Hôtels', // Défaut à 'Hôtels' si non fourni
                'image' => $path,
                'features' => $validated['features'] ?? null, // AJOUT: Intègre les caractéristiques
            ]);


            return response()->json([
                'message' => 'Hébergement créé avec succès',
                'data' => $hebergement
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la création de l\'hébergement',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $hebergement = Hebergement::find($id);
        if (!$hebergement) {
            return response()->json(['message' => 'Hébergement non trouvée'], 404);
        }
        return response()->json($hebergement);
    }

    /**
     * Update the specified resource in storage.
     * CORRIGÉ: Ajout de 'rating', 'features' et correction de 'type'.
     */
    public function update(Request $request, string $id)
    {
        $hebergement = Hebergement::find($id);

        if (!$hebergement) {
            return response()->json([
                'message' => 'Hébergement non trouvé'
            ], 404);
        }

        try {
            // RÈGLES DE VALIDATION MISES À JOUR
            $validated = $request->validate([
                'title' => 'sometimes|required|string|max:255',
                'location' => 'sometimes|required|string|max:255',
                'rating' => 'nullable|numeric|min:0|max:5', // Validation pour la note
                'description' => 'nullable|string',
                'price' => 'nullable|string|max:50',
                // CORRECTION: Suppression des espaces inutiles dans la règle 'in'
                'type' => 'nullable|in:Hôtels,Lodges Écologiques,Auberges,Stations balnéaires',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
                'features' => 'nullable|json', // NOUVEAU: Valide que les caractéristiques sont envoyées en JSON
            ], $request->all());


            if ($request->hasFile('image')) {
                // Suppression de l'ancienne image si elle existe
                if ($hebergement->image && Storage::disk('public')->exists($hebergement->image)) {
                    Storage::disk('public')->delete($hebergement->image);
                }
                $validated['image'] = $request->file('image')->store('hebergements', 'public');
            }

            // Mise à jour de tous les champs validés (y compris 'features')
            $hebergement->update($validated);

            return response()->json([
                'message' => 'Hébergement mis à jour avec succès',
                'data' => $hebergement
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation lors de la mise à jour',
                'errors' => $e->errors(),
            ], 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $hebergement = Hebergement::find($id);

        if (!$hebergement) {
            return response()->json([
                'message' => 'Hébergement non trouvé'
            ], 404);
        }

        // Suppression de l'image associée avant la suppression de l'enregistrement
        if ($hebergement->image && Storage::disk('public')->exists($hebergement->image)) {
            Storage::disk('public')->delete($hebergement->image);
        }

        $hebergement->delete();

        return response()->json([
            'message' => 'Hébergement supprimé avec succès'
        ]);
    }
}
