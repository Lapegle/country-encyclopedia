<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class LanguageController extends Controller
{
    public function show(Request $request): Response
    {
        $language = Language::with(['countries'])
            ->findOrFail($request->id);

        return Inertia::render('Languages/Detail', [
            'language' => $language
        ]);
    }
}
