<?php

namespace App\Repositories;

use App\Models\Country;
use App\Models\User;

interface FavoriteCountryRepositoryInterface
{
    public function addFavoriteCountry(User $user, Country $country): void;

    public function removeFavoriteCountry(User $user, Country $country): void;
}
