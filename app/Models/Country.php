<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $guarded = [];

    public function countryLanguages(): BelongsToMany
    {
        return $this->belongsToMany(Language::class, 'country_languages');
    }

    public function neighbouringCountries(): BelongsToMany
    {
        return $this->belongsToMany(Country::class, 'neighbouring_countries', 'country_id', 'neighbouring_country_id');
    }

    public function countryNames(): HasMany
    {
        return $this->hasMany(CountryName::class);
    }
}
