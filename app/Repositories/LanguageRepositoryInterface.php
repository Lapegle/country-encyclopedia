<?php

namespace App\Repositories;

use App\Models\Language;

interface LanguageRepositoryInterface
{
    public function getLanguageById(int $id): ?Language;
}
