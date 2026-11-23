<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use App\Models\Film;
use App\Models\Peran;
use Illuminate\Http\Request;

class PeranController extends Controller
{
    private function rules(): array
    {
        return [
            'film_id' => 'required|exists:films,id',
            'cast_id' => 'required|exists:casts,id',
            'actor'   => 'required|string|max:255',
        ];
    }

    private function options(): array
    {
        return [
            'filmOptions' => Film::orderBy('title')->get(['id', 'title']),
            'castOptions' => Cast::orderBy('name')->get(['id', 'name']),
        ];
    }

    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $peranList = Peran::with(['film:id,title', 'cast:id,name'])
            ->where(function ($query) use ($search) {
                if ($search !== '') {
                    $query->where('actor', 'like', '%' . $search . '%')
                        ->orWhereHas('film', function ($filmQuery) use ($search) {
                            $filmQuery->where('title', 'like', '%' . $search . '%');
                        })
                        ->orWhereHas('cast', function ($castQuery) use ($search) {
                            $castQuery->where('name', 'like', '%' . $search . '%');
                        });
                }
            })
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('admin.perans.index', compact('peranList'));
    }

    public function create()
    {
        return view('admin.perans.form', $this->options());
    }

    public function store(Request $request)
    {
        Peran::create($request->validate($this->rules()));

        return redirect()->route('admin.perans.index')->with('success', 'Peran berhasil ditambahkan');
    }

    public function edit(Peran $peran)
    {
        return view('admin.perans.form', $this->options() + ['peranItem' => $peran]);
    }

    public function update(Request $request, Peran $peran)
    {
        $peran->update($request->validate($this->rules()));

        return redirect()->route('admin.perans.index')->with('success', 'Peran berhasil diperbarui');
    }

    public function destroy(Peran $peran)
    {
        $peran->delete();

        return redirect()->route('admin.perans.index')->with('success', 'Peran berhasil dihapus');
    }
}