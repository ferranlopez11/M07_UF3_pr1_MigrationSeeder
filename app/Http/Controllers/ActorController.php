<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actor;
use Illuminate\Http\JsonResponse;

class ActorController extends Controller
{
    public function listActors()
    {
        $actors = Actor::all();
        return view('actors.index', [
            'actors' => $actors,
            'title' => 'Listado de todos los actores'
        ]);
    }

    public function listActorsByDecade($year)
    {
        $startYear = (int) $year;
        $endYear = $startYear + 9;

        $actors = Actor::whereYear('birthdate', '>=', $startYear)
                       ->whereYear('birthdate', '<=', $endYear)
                       ->get();

        return view('actors.index', [
            'title' => "Actores nacidos en la década de $startYear",
            'actors' => $actors
        ]);
    }

    public function countActors()
    {
        $actorCount = Actor::count();
        return view('actors.count', compact('actorCount'));
    }

    public function destroy($id): JsonResponse
    {
        $actor = Actor::find($id);

        if (!$actor) {
            return response()->json([
                'action' => 'delete',
                'status' => false,
                'message' => 'Actor not found'
            ], 404);
        }

        $actor->delete();

        return response()->json([
            'action' => 'delete',
            'status' => true,
            'message' => 'Actor deleted successfully'
        ], 200);
    }

}
