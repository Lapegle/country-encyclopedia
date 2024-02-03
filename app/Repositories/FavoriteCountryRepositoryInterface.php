<?php

namespace App\Repositories;

use App\Models\Country;
use App\Models\User;
use Illuminate\Support\Collection;

interface FavoriteCountryRepositoryInterface
{
    public function addFavoriteCountry(User $user, Country $country): void;

    public function removeFavoriteCountry(User $user, Country $country): void;

    public function isFavoritedByUser(User $user, Country $country): bool;

    public function getFavouriteCountriesByUser(User $user): Collection;
}
