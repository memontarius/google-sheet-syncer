<?php

namespace App\Console\Commands;

use App\Models\Entry;
use App\Services\SheetsSettingsService;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Revolution\Google\Sheets\Facades\Sheets;

class PrintEntryCommentFromGoogleSheet extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:print-entry-comment-from-google-sheet {--count=0} {--web}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Print entry id and comments from google sheet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $settingsService = app()->make(SheetsSettingsService::class);

        $documentName = $settingsService->get(SheetsSettingsService::DOCUMENT_NAME_KEY);
        $documentId = $settingsService->getDocumentId();
        $attributeCount = Entry::getColumns();

        if ($settingsService->isValidDocument()) {
            $optionCount = $this->option('count');
            $optionToWeb = $this->option('web');

            try {
                $sheet = Sheets::spreadsheet($documentId)->sheet($documentName);
                $rows = $sheet->get();

            }
            catch (\Exception $e) {
                Log::error($e->getMessage());
                $this->error('Error with accessing to document');
                return;
            }

            if ($optionCount != 0) {
                $rows = $rows->slice(0, $optionCount);
            }

            $progressBar = $optionToWeb
                ? null
                : $this->output->createProgressBar(count($rows));

            $progressBar?->start(startAt: 1);
            $printFunc = $optionToWeb ? 'printFormatAsOneLine' : 'printFormatAsTable';

            foreach ($rows as $row) {
                $progressBar?->display();

                $comments = count($row) > $attributeCount
                    ? array_slice($row, $attributeCount)
                    : [];

                $this->$printFunc($row, $comments);

                if ($optionToWeb) {
                    continue;
                }

                if ($progressBar->getProgress() == $progressBar->getMaxSteps()
                    || !$this->confirm('Continue?', true)) {
                    break;
                }

                $progressBar->advance();
            }
        } else {
            $this->error('Document not found');
        }
    }

    private function printFormatAsOneLine(array $row, array $comments): void
    {
        $this->line(sprintf("%d %s", $row[0], implode(' | ', $comments)));
    }

    private function printFormatAsTable(array $row, array $comments): void
    {
        $this->newLine();
        $this->table(['ID'], [[$row[0], ...$comments]]);
    }
}
