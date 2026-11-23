<?php

namespace App\Http\Controllers;

use App\Models\{
    Film,
    Genre,
    Kritik,
    Peran,
};
use Carbon\Carbon;
use Illuminate\Http\Request;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function movies(Request $request)
    {
        $genreFilm = null;
        $search = trim((string) $request->query('search', ''));

        $films = Film::select('id','title', 'poster','year')
                ->when($search !== '', fn ($query) => $query->where('title', 'like', '%' . $search . '%'))
                ->orderByDesc('year')
                ->OrderBy('created_at', 'asc')
                ->paginate(18)
                ->withQueryString();

        return view('components/movies', compact('films', 'genreFilm'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Film $film)
    {
        //
        $filmByGenre    = Film::select('id','title', 'poster','year', 'sinopsis')
                        ->where('genre_id', '=', $film->genre_id)
                        ->OrderBy('created_at', 'asc')
                        ->limit(7)
                        ->get();
        $filmByRelease  = Film::select('id','title', 'poster','year')
                        ->where('year', '=', Carbon::now()->format('Y'))
                        ->OrderBy('created_at', 'asc')
                        ->limit(9)
                        ->get();
        $comments       = Kritik::with('user:id,name')
                        ->where('film_id', '=', $film->id)
                        ->orderBy('created_at', 'desc')
                        ->limit(10)
                        ->get();
        $perans         = Peran::all()->where('film_id', '=', $film->id);
        return view('components.movie-show', compact('film','filmByGenre','filmByRelease','comments', 'perans'));
    }

    public function movieHome()
    {
        $films = Film::select('id','title', 'poster','year')
                ->OrderBy('created_at', 'asc')
                ->limit(9)->get();
        $filmFutured = Film::select('id','title', 'poster','year')
                        ->orderByDesc('year')
                        ->OrderBy('created_at', 'asc')
                        ->limit(6)->get();
        $filmRecentAdded = Film::select('id','title', 'poster','year')
                            ->orderByDesc('created_at', 'asc')
                            ->limit(6)->get();
        $filmSlidey = Film::select('title', 'poster','sinopsis')
                        ->orderByDesc('year')
                        ->OrderBy('created_at', 'asc')
                        ->limit(6)->get();
        return view('components/home', compact('filmSlidey','films','filmFutured','filmRecentAdded'));
    }

    public function moviesByGenre($genre)
    {
        //
        $genreFilm = Genre::where('id', '=', $genre)->first();
        $films = Film::select('id','title', 'poster','year')
                ->where('genre_id', '=', $genre)
                ->orderByDesc('year')
                ->OrderBy('created_at', 'asc')
                ->paginate(18);
        return view('components/movies', compact('films','genreFilm'));
    }
}