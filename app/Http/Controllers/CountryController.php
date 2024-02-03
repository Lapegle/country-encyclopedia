<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Repositories\CountryRepositoryInterface;
use App\Repositories\FavoriteCountryRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CountryController extends Controller
{
    public function __construct(
        private CountryRepositoryInterface         $countryRepository,
        private FavoriteCountryRepositoryInterface $favoriteCountryRepository
    )
    {
    }

    public function findCountry(Request $request): JsonResponse
    {
        $search = $request->input('search');

        $countries = $this->countryRepository->findCountry($search);

        return response()->json($countries);
    }

    public function show(Request $request): Response
    {
        $country = $this->countryRepository->getCountryById($request->id);
        $country->load(['countryLanguages', 'neighbouringCountries']);
        $populationRank = $this->countryRepository->getCountryPopulationRank($request->id);

        return Inertia::render('Countries/Detail', [
            'country' => $country,
            'rank' => $populationRank,
        ]);
    }

    public function addToFavorites(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $country = $this->countryRepository->getCountryById($request->input('country_id'));
        $this->favoriteCountryRepository->addFavoriteCountry($user, $country);
    }

    public function removeFromFavorites(Request $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $country = $this->countryRepository->getCountryById($request->input('country_id'));
        $this->favoriteCountryRepository->removeFavoriteCountry($user, $country);
    }
}
