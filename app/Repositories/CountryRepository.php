<?php

namespace App\Repositories;

use App\Models\Country;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class CountryRepository implements CountryRepositoryInterface
{
    public function findCountry(string $search): Collection
    {
        return Country::whereCountryName($search)
            ->limit(10)
            ->get();
    }

    public function getCountryById(int $id): ?Country
    {
        return Country::find($id);
    }

    public function getCountryPopulationRank(int $id): int
    {
        $countries = Cache::rememberForever('countries_population', function () {
            return Country::orderBy('population', 'desc')->get();
        });

        return $countries->pluck('id')->search($id) + 1;
    }
}
