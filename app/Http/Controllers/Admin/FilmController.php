<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreFilmRequest;
use App\Http\Requests\UpdateFilmRequest;
use App\Models\Film;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class FilmController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $filmList = Film::with('genre')
            ->when($search !== '', fn ($query) => $query->where('title', 'like', '%' . $search . '%'))
            ->orderBy('title')
            ->paginate(15)
            ->withQueryString();

        return view('admin.films.index', compact('filmList'));
    }

    public function create()
    {
        $genreOptions = Genre::orderBy('name')->get();

        return view('admin.films.form', compact('genreOptions'));
    }

    public function store(StoreFilmRequest $request)
    {
        $filmData = $request->validated();
        $posterPath = $request->file('poster')->store('images', 'public');

        if ($posterPath === false) {
            throw new RuntimeException('Poster film gagal disimpan.');
        }

        $filmData['poster'] = 'storage/' . $posterPath;
        Film::create($filmData);

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil ditambahkan');
    }

    public function edit(Film $film)
    {
        $genreOptions = Genre::orderBy('name')->get();

        return view('admin.films.form', compact('film', 'genreOptions'));
    }

    public function update(UpdateFilmRequest $request, Film $film)
    {
        $filmData = $request->validated();

        if ($request->hasFile('poster')) {
            $posterPath = $request->file('poster')->store('images', 'public');

            if ($posterPath === false) {
                throw new RuntimeException('Poster film gagal disimpan.');
            }

            $filmData['poster'] = 'storage/' . $posterPath;
        }

        $film->update($filmData);

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil diperbarui');
    }

    public function destroy(Film $film)
    {
        DB::transaction(function () use ($film): void {
            $film->kritiks()->delete();
            $film->perans()->delete();
            $film->delete();
        });

        return redirect()->route('admin.films.index')->with('success', 'Film berhasil dihapus');
    }
}
