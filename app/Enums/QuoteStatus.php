<?php

namespace App\Enums;

enum QuoteStatus: string
{
    case Draft = 'draft';
    case Sent = 'sent';
    case Viewed = 'viewed';
    case Approved = 'approved';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Sent => 'Sent',
            self::Viewed => 'Viewed',
            self::Approved => 'Approved',
            self::Rejected => 'Rejected',
        };
    }

    public function canTransitionTo(self $status): bool
    {
        return match ($this) {
            self::Draft => in_array($status, [self::Sent, self::Rejected]),
            self::Sent => in_array($status, [self::Viewed, self::Rejected]),
            self::Viewed => in_array($status, [self::Approved, self::Rejected]),
            self::Approved, self::Rejected => false,
        };
    }
}
