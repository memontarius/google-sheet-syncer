<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;

class SheetsSettingsService
{
    public const DOCUMENT_URL_KEY = 'url';
    public const DOCUMENT_NAME_KEY = 'documentName';

    private const CACHE_KEY = 'sheets_settings';

    private array $settings;

    public function __construct()
    {
        $this->settings = Cache::get(self::CACHE_KEY, [
            self::DOCUMENT_URL_KEY => '',
            self::DOCUMENT_NAME_KEY => 'Лист1',
        ]);
    }

    public function getAll(array $defaultSettings = null): array
    {
        return $this->settings;
    }

    public function get(string $key): string
    {
        return $this->settings[$key];
    }

    public function getDocumentId(): ?string
    {
        $url = $this->settings[self::DOCUMENT_URL_KEY];
        preg_match('/spreadsheets\/d\/(.*)\//', $url, $matches);
        return $matches[1] ?? null;
    }

    public function isValidDocument(): bool
    {
        $url = $this->settings[self::DOCUMENT_URL_KEY] ?? null;
        $documentName = $this->settings[self::DOCUMENT_NAME_KEY] ?? null;
        return
            !empty($url)
            && !empty($documentName)
            && !empty($this->getDocumentId());
    }

    public function save(array $settings): void
    {
        $this->settings = $settings;
        Cache::forever(self::CACHE_KEY, $settings);
    }
}
