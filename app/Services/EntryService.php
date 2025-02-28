<?php

namespace App\Services;

use App\Models\Entry;
use App\Models\Enums\EntryStatus;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class EntryService
{
    private const LAST_MODIFIED_TIME_CACHE_KEY = 'entry_last_modified_time';

    public function generate(int $count, array $fakeTexts): void
    {
        $data = [];

        for ($i = 0; $i < $count; $i++) {
            $data[] = [
                'status' => (rand(0, 1) == 1) ? EntryStatus::Allowed : EntryStatus::Prohibited,
                'text' => $fakeTexts[rand(0, count($fakeTexts) - 1)],
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        $tableName = (new Entry)->getTable();
        DB::table($tableName)->insert($data);
        $this->refreshLastModifiedTime();
    }

    public function update(Entry $entry, array $attributes): void
    {
        $entry->update($attributes);
        $this->refreshLastModifiedTime();
    }

    public function store(array $attributes): void
    {
        Entry::create($attributes);
        $this->refreshLastModifiedTime();
    }

    public function destroy(Entry $entry): void
    {
        $entry->delete();
        $this->refreshLastModifiedTime();
    }

    public function clearAll(): void
    {
        Entry::truncate();
        $this->refreshLastModifiedTime();
    }

    private function refreshLastModifiedTime(): void
    {
        Cache::forever(self::LAST_MODIFIED_TIME_CACHE_KEY, now()->toDateTimeString());
    }

    public function getLastModifiedTime(): Carbon
    {
        $time = Cache::get(self::LAST_MODIFIED_TIME_CACHE_KEY, '00-00-0000');
        return Carbon::parse($time);
    }
}
