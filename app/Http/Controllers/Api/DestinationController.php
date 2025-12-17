<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Destination;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class DestinationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Destination::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // RÈGLES DE VALIDATION (basées sur le schéma de la table)
            $validated = $request->validate([
                'title' => 'required|string|max:100',
                'region' => 'required|string|max:50',
                'description' => 'required|string',
                'bestPeriod' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
                // 'pointsOfInterest' est un tableau/JSON, nous validons qu'il est JSON ou non-présent
                'pointsOfInterest' => 'nullable|json',
            ]);

            $path = null;
            if ($request->hasFile('image')) {
                // Stockage de l'image dans 'destinations' sous le disque 'public'
                $path = $request->file('image')->store('destinations', 'public');
            }

            // CRÉATION DE LA DESTINATION
            $destination = Destination::create([
                'title' => $validated['title'],
                'region' => $validated['region'],
                'description' => $validated['description'],
                'bestPeriod' => $validated['bestPeriod'] ?? null,
                'image' => $path,
                // Le cast 'array' dans le modèle Destination gère le JSON ici.
                'pointsOfInterest' => $validated['pointsOfInterest'] ?? null,
            ]);


            return response()->json([
                'message' => 'Destination créée avec succès',
                'data' => $destination
            ], 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Erreur de validation',
                'errors' => $e->errors(),
            ], 422);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Une erreur est survenue lors de la création de la destination',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $destination = Destination::find($id);

        if (!$destination) {
            return response()->json(['message' => 'Destination non trouvée'], 404);
        }

        return response()->json($destination);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $destination = Destination::find($id);

        if (!$destination) {
            return response()->json(['message' => 'Destination non trouvée'], 404);
        }

        try {
            // RÈGLES DE VALIDATION 'sometimes' pour la mise à jour partielle (PATCH)
            $validated = $request->validate([
                'title' => 'sometimes|required|string|max:100',
                'region' => 'sometimes|required|string|max:50',
                'description' => 'sometimes|required|string',
                'bestPeriod' => 'nullable|string|max:255',
                'image' => 'nullable|image|mimes:jpg,jpeg,png,gif,webp|max:2048',
                'pointsOfInterest' => 'nullable|json',
            ], $request->all());


            if ($request->hasFile('image')) {
                // Suppression de l'ancienne image si elle existe
                if ($destination->image && Storage::disk('public')->exists($destination->image)) {
                    Storage::disk('public')->delete($destination->image);
                }
                $validated['image'] = $request->file('image')->store('destinations', 'public');
            }

            // Mise à jour de tous les champs validés
            $destination->update($validated);

            return response()->json([
                'message' => 'Destination mise à jour avec succès',
                'data' => $destination
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
        $destination = Destination::find($id);

        if (!$destination) {
            return response()->json(['message' => 'Destination non trouvée'], 404);
        }

        try {
            // Suppression de l'image associée avant la suppression de l'enregistrement
            if ($destination->image && Storage::disk('public')->exists($destination->image)) {
                Storage::disk('public')->delete($destination->image);
            }

            $destination->delete();

            return response()->json([
                'message' => 'Destination supprimée avec succès'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Erreur lors de la suppression de la destination',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
