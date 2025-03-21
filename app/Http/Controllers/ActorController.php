<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Actor;

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

        $actors = Actor::whereBetween('birthdate', ["$startYear-01-01", "$endYear-12-31"])->get();

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


}
