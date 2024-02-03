<?php

namespace App\Http\Controllers;

use App\Repositories\LanguageRepositoryInterface;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LanguageController extends Controller
{
    public function __construct(
        private LanguageRepositoryInterface $languageRepository
    )
    {
    }

    public function show(Request $request): Response
    {
        $language = $this->languageRepository->getLanguageById($request->id);

        return Inertia::render('Languages/Detail', [
            'language' => $language
        ]);
    }
}
