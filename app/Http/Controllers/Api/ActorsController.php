<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Actor;

class ActorsController extends Controller
{
    public function index()
    {
        $actors = Actor::with('films')->get();
        return response()->json($actors);
    }
}
