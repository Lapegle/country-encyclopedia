<?php

use App\Http\Controllers\CountryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/home', HomeController::class)
        ->name('home');

    Route::get('/countries/find', [CountryController::class, 'findCountry'])
        ->name('countries.find');

    Route::get('/countries/{id}', [CountryController::class, 'show'])
        ->whereNumber('id')
        ->name('countries.show');

    Route::post('/countries/add-to-favorites', [CountryController::class, 'addToFavorites'])
        ->name('countries.add_to_favorites');

    Route::post('/countries/remove-from-favorites', [CountryController::class, 'removeFromFavorites'])
        ->name('countries.remove_from_favorites');

    Route::get('/languages/{id}', [LanguageController::class, 'show'])
        ->whereNumber('id')
        ->name('languages.show');
});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
