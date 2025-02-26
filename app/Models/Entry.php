<?php

namespace App\Models;

use App\Models\Enums\EntryStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entry extends Model
{
    use HasFactory;

    protected $guarded = false;

    protected $casts = [
        'status' => EntryStatus::class,
    ];
}
