<?php

namespace App\Repositories;

use App\Models\Country;
use Illuminate\Support\Collection;

interface CountryRepositoryInterface
{
    public function findCountry(string $search): Collection;

    public function getCountryById(int $id): ?Country;

    public function getCountryPopulationRank(int $id): int;
}
