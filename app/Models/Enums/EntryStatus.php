<?php

namespace App\Models\Enums;

enum EntryStatus: string
{
    case Allowed = 'Allowed';
    case Prohibited = 'Prohibited';

    public static function toArray(): array
    {
        return array_column(EntryStatus::cases(), 'value');
    }
}
