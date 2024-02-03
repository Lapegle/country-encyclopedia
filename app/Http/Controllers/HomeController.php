<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\FavoriteCountryRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __construct(
        private FavoriteCountryRepositoryInterface $favoriteCountryRepository
    )
    {
    }

    public function __invoke(Request $request): Response
    {
        /** @var User $user */
        $user = auth()->user();

        $favoriteCountries = $this->favoriteCountryRepository->getFavouriteCountriesByUser($user);

        return Inertia::render('Home', [
            'favoriteCountries' => $favoriteCountries,
        ]);
    }
}
