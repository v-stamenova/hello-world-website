<?php

namespace App\Enums;

readonly class EnumHelper
{
    /**
     * @return array<int, array{display: string, value: string}>
     */
    public static function getStatuses(): array
    {
        return array_map(
            fn ($case) => [
                'display' => ucfirst($case->value),
                'value' => $case->value,
            ],
            Status::cases()
        );
    }
}
