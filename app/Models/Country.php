<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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

    public function scopeWhereCountryName(Builder $query, string $search): void
    {
        $query->whereHas('countryNames', function (Builder $query) use ($search) {
            $query->where('name', 'like', "%$search%");
        })
            ->orWhere('common_name', 'like', "%$search%")
            ->orWhere('official_name', 'like', "%$search%");
    }
}
