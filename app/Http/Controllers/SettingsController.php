<?php

namespace App\Http\Controllers;

use App\Services\SheetsSettingsService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingsController extends Controller
{
    private const DOCUMENT_URL = 'document-url';
    private const DOCUMENT_NAME = 'document-name';

    public function __construct(
        private readonly SheetsSettingsService $sheetsSettings
    )
    {
    }

    public function index(Request $request): View
    {
        $settings = $this->sheetsSettings->getAll();

        $url = $settings[SheetsSettingsService::DOCUMENT_URL_KEY];
        $documentName = $settings[SheetsSettingsService::DOCUMENT_NAME_KEY];

        return view('settings.index', compact('url', 'documentName'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            self::DOCUMENT_URL => 'nullable|url',
            self::DOCUMENT_NAME => 'nullable|string',
        ]);

        $this->sheetsSettings->save([
            SheetsSettingsService::DOCUMENT_URL_KEY => $validated[self::DOCUMENT_URL],
            SheetsSettingsService::DOCUMENT_NAME_KEY => $validated[self::DOCUMENT_NAME]
        ]);

        return redirect()->back();
    }
}
