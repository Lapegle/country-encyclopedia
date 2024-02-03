<?php

namespace App\Http\Controllers;

use App\Repositories\CountryRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CountryController extends Controller
{
    public function __construct(
        private CountryRepositoryInterface $countryRepository
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

        return Inertia::render('Countries/Detail', [
            'country' => $country
        ]);
    }
}
