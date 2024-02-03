<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
}
