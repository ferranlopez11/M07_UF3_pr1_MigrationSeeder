<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class FilmController extends Controller
{

    /**
     * Read films from storage
     */
    /*public static function readFilms(): array {
        $jsonPath = 'public/films.json';
        $filmsFromJson = Storage::exists($jsonPath) ? Storage::json($jsonPath) : [];
        $filmsFromDB = Film::all()->toArray();
 
        return array_merge($filmsFromJson, $filmsFromDB);
    }*/
    /**
     * List films older than input year 
     * if year is not infomed 2000 year will be used as criteria
     */
    public function listOldFilms($year = 2000)
    {        
        $films = Film::where('year', '<', $year)->get();

        return view('films.list', [
            'title' => "Listado de Pelis Antiguas (Antes de $year)",
            'films' => $films
        ]);
    }
    /**
     * List films younger than input year
     * if year is not infomed 2000 year will be used as criteria
     */
    public function listNewFilms($year = 2000)
    {
        $films = Film::where('year', '>=', $year)->get();

        return view('films.list', [
            'title' => "Listado de Pelis Nuevas (Después de $year)",
            'films' => $films
        ]);
    }
    /**
     * Lista TODAS las películas o filtra x año o categoría.
     */
    public function listFilms($year = null, $genre = null)
    {
        $query = Film::query();

        if ($year) {
            $query->where('year', $year);
        }

        if ($genre) {
            $query->whereRaw('LOWER(genre) = ?', [strtolower($genre)]);
        }

        return view('films.list', [
            'title' => 'Listado de Películas',
            'films' => $query->get(),
        ]);
        
    }

    public function countFilms()
    {
        $totalFilms = Film::count();

        return view('counter', ['totalFilms' => $totalFilms]);
    }

    //Función ordenar películas (de nuevas a antiguas)
    public function sortFilms()
    {
        $films = Film::orderByDesc('year')->get();

        return view('films.list', [
            "films" => $films,
            "title" => "Listado de Pelis Ordenadas por Año (Nuevas a antiguas)"
        ]);
    }

    //Función ordenar películas por género y año
    public function listFilmsByYear($year)
    {
        $films = Film::where('year', $year)->get();

        return view('films.list', [
            "films" => $films,
            "title" => "Listado de Pelis del Año $year"
        ]);
    }
    
    public function listFilmsByGenre($genre)
    {
        $films = Film::whereRaw('LOWER(genre) = ?', [strtolower($genre)])->get();

        return view('films.list', [
            "films" => $films,
            "title" => "Listado de Pelis del Género $genre"
        ]);
    }

    //Crear película
    public function createFilm(Request $request)
    {

        $request->validate([
            'name' => 'required|string|unique:films,name',
            'year' => 'required|integer',
            'genre' => 'required|string',
            'country' => 'required|string',
            'duration' => 'required|integer',
            'img_url' => 'required|url',
        ]);

        Film::create($request->only(['name', 'year', 'genre', 'country', 'duration', 'img_url']));

        return redirect()->action([FilmController::class, 'listFilms']);

    }
    
    private function isFilm($filmName): bool
    {
        $films = self::readFilms();
        return collect($films)->contains(fn ($film) => strtolower($film['name']) === strtolower($filmName));
    }


}
