<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    protected const string ENGLISH_LANGUAGE_CODE = 'eng';

    public function findCountry(Request $request): JsonResponse
    {
        $search = $request->input('search');

        $countries = Country::whereHas('countryNames', function ($query) use ($search) {
            $query->where('name', 'like', "%{$search}%");
        })->with(['countryNames' => function ($query) {
            $query->with('language')->whereHas('language', function ($query) {
                $query->where('code', self::ENGLISH_LANGUAGE_CODE);
            });
        }])->get();

        return response()->json($countries);
    }
}
