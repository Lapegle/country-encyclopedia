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

        // create english so that english common and official name can be added
        $englishLanguage = Language::create([
           'code' => 'eng',
           'name' => 'English',
        ]);

        $data->each(function (stdClass $item) use ($englishLanguage) {
            $country = Country::create([
                'country_code' => Str::lower($item->cca3),
                'population' => $item->population,
                'flag_url' => $item->flags->png,
                'area' => $item->area,
            ]);

            $spokenLanguages = collect($item->languages);
            $spokenLanguages->each(function (string $name, string $key) {
                Language::updateOrInsert(
                    ['code' => $key],
                    ['name' => $name]
                );
            });

            $languages = Language::whereIn('code', $spokenLanguages->keys())->get();
            $country->countryLanguages()->attach($languages);

            $translations = collect($item->translations);
            $nativeNames = collect($item->name->nativeName);
            $names = $translations->merge($nativeNames);
            $names->each(function (stdClass $item, string $key) use ($country) {
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

            foreach (CountryNameType::cases() as $nameType) {
                CountryName::create([
                    'country_id' => $country->id,
                    'language_id' => $englishLanguage->id,
                    'name_type' => $nameType,
                    'name' => $item->name->{$nameType->value},
                ]);
            }
        });

        // iterating over second time to have all countries available to attach to neighbouring countries
        $data->each(function (stdClass $item) {
            $country = Country::where('country_code', Str::lower($item->cca3))->first();

            $borderingCountries = collect($item->borders)->map(fn ($code) => Str::lower($code));
            $countries = Country::whereIn('country_code', $borderingCountries)->get();
            $country->neighbouringCountries()->attach($countries);
        });
    }
}
