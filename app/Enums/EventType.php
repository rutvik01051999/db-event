<?php

namespace App\Enums;

enum EventType: int
{
    case SINGLE_DAY = 1;
    case ALL_DAY = 2;

    public function isSingleDay(): bool
    {
        return $this === self::SINGLE_DAY;
    }

    public function isAllDay(): bool
    {
        return $this === self::ALL_DAY;
    }

    public function getLabelText(): string
    {
        return match ($this) {
            self::SINGLE_DAY =>  'Single Day',
            self::ALL_DAY =>  'All Day',
        };
    }

    public function getHtmlBadge(): string
    {
        return sprintf('<span class="badge bg-%s">%s</span>', $this->getHtmlBadgeType(), $this->getLabelText());
    }

    public function getHtmlBadgeType(): string
    {
        return match ($this) {
            self::SINGLE_DAY =>  'warning',
            self::ALL_DAY =>  'dark',
        };
    }

    public static function toArray(): array
    {
        return [
            [
                'id' => static::SINGLE_DAY->value,
                'text' => 'Single Day'
            ],
            [
                'id' => static::ALL_DAY->value,
                'text' => 'All Day'
            ],
        ];
    }

    public static function toSelect2($search = null): array
    {
        $statuses = static::toArray();
        if ($search) {
            $statuses = array_filter($statuses, function ($status) use ($search) {
                return str_contains($status['text'], $search);
            });
        }

        return $statuses;
    }


    public static function fromValue(string $value): self
    {
        $value = (int) $value;
        return match ($value) {
            self::SINGLE_DAY->value => self::SINGLE_DAY,
            self::ALL_DAY->value => self::ALL_DAY,
            default => self::SINGLE_DAY
        };
    }
}