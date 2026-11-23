<?php

namespace App\Http\Controllers;

use App\Models\Film;
use App\Models\Kritik;
use App\Http\Requests\StoreKritikRequest;

class KritikController extends Controller
{
    public function store(StoreKritikRequest $request, Film $film)
    {
        Kritik::create([
            'comment' => $request->comment,
            'rating'  => $request->rating,
            'film_id' => $film->id,
            'user_id' => $request->user()->id,
        ]);

        return back()->with('success', 'Komentar berhasil dikirim');
    }
}