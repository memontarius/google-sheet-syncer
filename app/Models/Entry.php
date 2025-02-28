<?php

namespace App\Models;

use App\Models\Enums\EntryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use  Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class Entry extends Model
{
    use HasFactory;

    protected $guarded = false;

    protected $casts = [
        'status' => EntryStatus::class,
    ];

    public function scopeAllowed(Builder $query): void
    {
        $query->where('status', '=', EntryStatus::Allowed);
    }

    public static function getTableName(): string
    {
        return (new Entry())->getTable();
    }

    public static function getColumns(): int
    {
        $table = static::getTableName();
        return count(DB::getSchemaBuilder()->getColumnListing($table));
    }
}
