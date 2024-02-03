<?php

namespace App\Repositories;

use App\Models\Language;

class LanguageRepository implements LanguageRepositoryInterface
{
    public function getLanguageById(int $id): ?Language
    {
        return Language::with(['countries'])
            ->findOrFail($id);
    }
}
