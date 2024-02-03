<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CountryController extends Controller
{
    public function findCountry(Request $request): JsonResponse
    {
        $search = $request->input('search');

        $countries = Country::whereCountryName($search)
            ->limit(10)
            ->get();

        return response()->json($countries);
    }

    public function show(Request $request): Response
    {
        $country = Country::findOrFail($request->id);

        return Inertia::render('Countries/Detail', [
            'country' => $country
        ]);
    }
}
