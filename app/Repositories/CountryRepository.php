<?php

namespace App\Repositories;

use App\Models\Country;
use Illuminate\Support\Collection;

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
        return Country::with(['countryLanguages', 'neighbouringCountries'])
            ->where('id', $id)
            ->first();
    }
}
