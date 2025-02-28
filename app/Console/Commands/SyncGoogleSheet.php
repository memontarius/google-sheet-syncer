<?php

namespace App\Console\Commands;

use App\Models\Entry;
use App\Services\EntryService;
use App\Services\SheetsSettingsService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Revolution\Google\Sheets\Facades\Sheets;

class SyncGoogleSheet extends Command
{
    private const LAST_EXPORTED_TIME_CACHE_KEY = 'last_exported_time';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-google-sheet';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Export to Google Sheet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $settingsService = app()->make(SheetsSettingsService::class);
        $entryService = app()->make(EntryService::class);

        $lastModified = $entryService->getLastModifiedTime();
        $lastExported = Carbon::parse(Cache::get(self::LAST_EXPORTED_TIME_CACHE_KEY, '00-00-0000'));

        if ($lastModified < $lastExported) {
            return;
        }

        $settings = $settingsService->getAll();
        $documentName = $settings[SheetsSettingsService::DOCUMENT_NAME_KEY];

        if ($settingsService->isValidDocument()) {
            Cache::forever(self::LAST_EXPORTED_TIME_CACHE_KEY, now()->toDateTimeString());

            try {
                /** @var Sheets $sheets */
                $sheet = Sheets::spreadsheet($settingsService->getDocumentId())
                    ->sheet($documentName);
            }
            catch (\Exception $e) {
                Log::error($e->getMessage());
                return;
            }

            $rows = $sheet->get()->keyBy(0)->toArray();
            $sheet->clear();
            $attributeCount =

            Entry::allowed()->orderBy('id')->chunk(500, function ($entries) use ($rows, $sheet) {

                $exportData = $entries
                    ->map(function ($entry) use ($rows) {
                        $values = array_values($entry->getAttributes());
                        $attributeCount = count($values);
                        $sheetValues = $rows[$entry->id] ?? null;

                        if ($sheetValues && count($sheetValues) > $attributeCount) {
                            $values = array_merge($values, array_slice($sheetValues, $attributeCount));
                        }
                        return $values;
                    })
                    ->toArray();

                $sheet->append($exportData);
            });
        }
    }
}
