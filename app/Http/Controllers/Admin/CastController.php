<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Cast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CastController extends Controller
{
    private function rules(): array
    {
        return [
            'name' => 'required|string|max:45',
            'age'  => 'required|integer|min:1|max:120',
            'bio'  => 'required|string',
        ];
    }

    public function index(Request $request)
    {
        $search = trim((string) $request->query('search', ''));

        $castList = Cast::withCount('perans')
            ->when($search !== '', fn ($query) => $query->where('name', 'like', '%' . $search . '%'))
            ->orderBy('name')
            ->paginate(15)
            ->withQueryString();

        return view('admin.casts.index', compact('castList'));
    }

    public function create()
    {
        return view('admin.casts.form');
    }

    public function store(Request $request)
    {
        Cast::create($request->validate($this->rules()));

        return redirect()->route('admin.casts.index')->with('success', 'Cast berhasil ditambahkan');
    }

    public function edit(Cast $cast)
    {
        return view('admin.casts.form', ['castItem' => $cast]);
    }

    public function update(Request $request, Cast $cast)
    {
        $cast->update($request->validate($this->rules()));

        return redirect()->route('admin.casts.index')->with('success', 'Cast berhasil diperbarui');
    }

    public function destroy(Cast $cast)
    {
        DB::transaction(function () use ($cast) {
            $cast->perans()->delete();
            $cast->delete();
        });

        return redirect()->route('admin.casts.index')->with('success', 'Cast berhasil dihapus');
    }
}