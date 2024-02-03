<?php

namespace App\Repositories;

use App\Models\Country;
use App\Models\User;

class FavoriteCountryRepository implements FavoriteCountryRepositoryInterface
{

    public function addFavoriteCountry(User $user, Country $country): void
    {
        User::favoriteCountries()->attach($country);
    }

    public function removeFavoriteCountry(User $user, Country $country): void
    {
        User::favoriteCountries()->detach($country);
    }
}
