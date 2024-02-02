<?php

namespace App\Console\Commands;

use App\Enums\CountryNameType;
use App\Models\Country;
use App\Models\CountryName;
use App\Models\Language;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use stdClass;

class PopulateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:populate-database';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $response = Http::get('https://restcountries.com/v3.1/all', [
            'fields' => 'name,cca3,population,flags,area,borders,languages,translations',
        ]);
        $data = collect(json_decode($response->body()));

        $data->each(function (stdClass $item) {
            Country::create([
                'country_code' => Str::lower($item->cca3),
                'population' => $item->population,
                'flag_url' => $item->flags->png,
                'area' => $item->area,
            ]);

            collect($item->languages)->each(function (string $name, string $key) {
                Language::updateOrInsert(
                    ['code' => $key],
                    ['name' => $name]
                );
            });
        });

        // iterating over twice so that I have countries and languages to attach in relationships
        $data->each(function (stdClass $item) {
            $country = Country::where('country_code', Str::lower($item->cca3))->first();

            $spokenLanguages = collect($item->languages)->keys();
            $languages = Language::whereIn('code', $spokenLanguages)->get();
            $country->countryLanguages()->attach($languages);

            $borderingCountries = collect($item->borders)->map(fn ($code) => Str::lower($code));
            $countries = Country::whereIn('country_code', $borderingCountries)->get();
            $country->neighbouringCountries()->attach($countries);

            $translations = collect($item->translations);
            $translations->each(function (stdClass $item, string $key) use ($country) {
                // some of the languages inside country name translations weren't attached to any country spoken languages
                $language = Language::firstOrCreate(
                    ['code' => $key],
                    ['name' => ucfirst($key)]
                );

                foreach (CountryNameType::cases() as $nameType) {
                    CountryName::create([
                        'country_id' => $country->id,
                        'language_id' => $language->id,
                        'name_type' => $nameType,
                        'name' => $item->{$nameType->value},
                    ]);
                }
            });
        });
    }
}
