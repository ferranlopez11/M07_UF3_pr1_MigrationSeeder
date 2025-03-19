<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class FilmController extends Controller
{

    /**
     * Read films from storage
     */
    public static function readFilms(): array {
        /*$films = Storage::json('/public/films.json');
        return $films;*/

        $filmsFromJson = Storage::exists('/public/films.json')
            ? Storage::json('/public/films.json')
            : [];
 
        $filmsFromDB = DB::table('films')->get()->map(function ($film) {
            return (array) $film;
        })->toArray();
 
        return array_merge($filmsFromJson, $filmsFromDB);
    }
    /**
     * List films older than input year 
     * if year is not infomed 2000 year will be used as criteria
     */
    public function listOldFilms($year = null)
    {        
        $old_films = [];
        if (is_null($year))
        $year = 2000;
    
        $title = "Listado de Pelis Antiguas (Antes de $year)";    
        $films = FilmController::readFilms();

        foreach ($films as $film) {
        //foreach ($this->datasource as $film) {
            if ($film['year'] < $year)
                $old_films[] = $film;
        }
        return view('films.list', ["films" => $old_films, "title" => $title]);
    }
    /**
     * List films younger than input year
     * if year is not infomed 2000 year will be used as criteria
     */
    public function listNewFilms($year = null)
    {
        $new_films = [];
        if (is_null($year))
            $year = 2000;

        $title = "Listado de Pelis Nuevas (Después de $year)";
        $films = FilmController::readFilms();

        foreach ($films as $film) {
            if ($film['year'] >= $year)
                $new_films[] = $film;
        }
        return view('films.list', ["films" => $new_films, "title" => $title]);
    }
    /**
     * Lista TODAS las películas o filtra x año o categoría.
     */
    public function listFilms($year = null, $genre = null)
    {
        $films_filtered = [];

        $title = "Listado de todas las pelis";
        $films = FilmController::readFilms();

        //if year and genre are null
        if (is_null($year) && is_null($genre))
            return view('films.list', ["films" => $films, "title" => $title]);

        //list based on year or genre informed
        foreach ($films as $film) {
            if ((!is_null($year) && is_null($genre)) && $film['year'] == $year){
                $title = "Listado de todas las pelis filtrado x año";
                $films_filtered[] = $film;
            }else if((is_null($year) && !is_null($genre)) && strtolower($film['genre']) == strtolower($genre)){
                $title = "Listado de todas las pelis filtrado x categoria";
                $films_filtered[] = $film;
            }else if(!is_null($year) && !is_null($genre) && strtolower($film['genre']) == strtolower($genre) && $film['year'] == $year){
                $title = "Listado de todas las pelis filtrado x categoria y año";
                $films_filtered[] = $film;
            }
        }
        return view("films.list", ["films" => $films_filtered, "title" => $title]);
    }

    //Función contar películas
    public function countFilms()
    {
        //$films = json_decode(Storage::get('films.json'), true);
        $films = self::readFilms();
        $totalFilms = count($films);
        return view('counter', ['totalFilms' => $totalFilms]);
    }

    //Función ordenar películas (de nuevas a antiguas)
    public function sortFilms()
    {
        $films = self::readFilms();
        usort($films, function ($a, $b) {
            return $b['year'] <=> $a['year'];
        });
    
        $title = "Listado de Pelis Ordenadas por Año (Nuevas a antiguas)";
    
        return view('films.list', ["films" => $films, "title" => $title]);
    }

    //Función ordenar películas por género y año
    public function listFilmsByYear($year)
    {
        $filmsByYear = [];
        $films = self::readFilms();
        
        foreach ($films as $film) {
            if ($film['year'] == $year) {
                $filmsByYear[] = $film;
            }
        }
        $title = "Listado de Pelis del Año $year";
        return view('films.list', ["films" => $filmsByYear, "title" => $title]);
    }
    
    public function listFilmsByGenre($genre)
    {
        $filmsByGenre = [];
        $films = self::readFilms();
        
        foreach ($films as $film) {
            if (strtolower($film['genre']) == strtolower($genre)) {
                $filmsByGenre[] = $film;
            }
        }
        
        $title = "Listado de Pelis del Género $genre";
        return view('films.list', ["films" => $filmsByGenre, "title" => $title]);
    }

    //Crear película
    public function createFilm(Request $request)
    {
        if (self::isFilm($request->input('name'))) {
            return redirect()->back()
                ->withErrors(['name' => 'El nombre de la película ya existe.'])
                ->withInput(); // <-- Mantener los datos del formulario
        }

        $films = FilmController::readFilms();

        $newFilm = array(
            'name' => $request->input('name'),
            'year' => $request->input('year'),
            'genre' => $request->input('genre'),
            'country' => $request->input('country'),
            'duration' => $request->input('duration'),
            'img_url' => $request->input('img_url')
        );

        if(!FilmController::isFilm($newFilm['name'])){
            $films[] = $newFilm;
            $status = Storage::put('/public/films.json', json_encode($films));
            
            if ($status) {
                return redirect()->action('App\Http\Controllers\FilmController@listFilms');
            } else {
                return redirect()->back()
                ->with("status", "Error al añadir película")
                ->withInput();
            }
        } else {
            return redirect()->back()
            ->withErrors(['name' => 'La película ya existe'])
            ->withInput();
        }
    }
    
    private static function isFilm($filmName): bool
    {

        $films = self::readFilms();
        foreach ($films as $film) {
            if (strtolower($film['name']) === strtolower($filmName)) {
                return true;
            }
        }
        return false;
    }


}
