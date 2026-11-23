<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    FilmController,
    AuthController,
    KritikController,
    ProfileController,
};
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\GenreController as AdminGenreController;
use App\Http\Controllers\Admin\FilmController as AdminFilmController;
use App\Http\Controllers\Admin\CastController as AdminCastController;
use App\Http\Controllers\Admin\PeranController as AdminPeranController;
use App\Models\Cast;
use App\Models\Film;
use App\Models\Genre;
use App\Models\Peran;
use App\Models\User;

Route::get('/', [FilmController::class, 'movieHome'])->name('home');
Route::get('/movies', [FilmController::class, 'movies'])->name('movies');
Route::get('/movies/{film}', [FilmController::class, 'show'])->name('movies.show');
Route::get('/movies/genre/{genre}', [FilmController::class, 'moviesByGenre'])->name('genre');

// Login lewat modal, jadi /login diarahkan ke home (dibutuhkan middleware auth)
Route::get('/login', fn () => redirect()->route('home'))->name('login');

Route::middleware('guest')->group(function () {
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/register', [AuthController::class, 'register'])->name('register');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::middleware(['auth', 'role:user'])->group(function () {
    Route::post('/movies/{film}/kritik', [KritikController::class, 'store'])->name('kritik.store');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', function () {
        $counts = [
            'users' => User::count(),
            'genres' => Genre::count(),
            'films' => Film::count(),
            'casts' => Cast::count(),
            'perans' => Peran::count(),
        ];

        return view('admin.dashboard', compact('counts'));
    })->name('dashboard');
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');

    Route::resource('genres', AdminGenreController::class)->except('show');
    Route::resource('films', AdminFilmController::class)->except('show');
    Route::resource('casts', AdminCastController::class)->except('show');
    Route::resource('perans', AdminPeranController::class)->except('show');
});