<?php

namespace App\Repositories;

use App\Models\Country;
use App\Models\User;

class FavoriteCountryRepository implements FavoriteCountryRepositoryInterface
{

    public function addFavoriteCountry(User $user, Country $country): void
    {
        $user->favoriteCountries()->syncWithoutDetaching($country);
    }

    public function removeFavoriteCountry(User $user, Country $country): void
    {
        $user->favoriteCountries()->detach($country);
    }

    public function isFavoritedByUser(User $user, Country $country): bool
    {
        return $user->favoriteCountries->contains($country);
    }
}
