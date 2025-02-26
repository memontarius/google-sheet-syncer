<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class SettingsController extends Controller
{
    private const DOCUMENT_URL_KEY = 'document-url';

    public function index(Request $request): View
    {
        $url = Cache::get(self::DOCUMENT_URL_KEY, '');

        return view('settings.index', compact('url'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            self::DOCUMENT_URL_KEY => 'nullable|url',
        ]);

        Cache::forever(self::DOCUMENT_URL_KEY, $validated[self::DOCUMENT_URL_KEY]);

        return redirect()->back();
    }
}
