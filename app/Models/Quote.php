<?php

namespace App\Models;

use App\Enums\QuoteStatus;
use Database\Factories\QuoteFactory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

/**
 * @property int $id
 * @property int $user_id
 * @property string $client_name
 * @property string $client_email
 * @property string $status
 * @property float $total
 * @property Carbon|null $expires_at
 * @property int $view_count
 * @property Carbon|null $viewed_at
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read User $user
 * @property-read Collection|QuoteItem[] $items
 */
class Quote extends Model
{
    /** @use HasFactory<QuoteFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_name',
        'client_email',
        'status',
        'total',
        'expires_at',
    ];

    protected function casts(): array
    {
        return [
            'status' => QuoteStatus::class,
            'total' => 'decimal:2',
            'expires_at' => 'datetime',
            'view_count' => 'integer',
            'viewed_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getRouteKeyName(): string
    {
        return 'share_token';
    }

    protected static function booted(): void
    {
        static::creating(function (Quote $quote) {
            $quote->uuid = (string) Str::uuid();
            $quote->share_token = Str::random(32);
        });

        static::updating(function (Quote $quote) {
            if ($quote->isDirty('status')) {
                $originalStatus = $quote->getOriginal('status');
                $newStatus = $quote->status;

                if ($originalStatus && ! $originalStatus->canTransitionTo($newStatus)) {
                    throw new \InvalidArgumentException("Cannot transition from {$originalStatus->value} to {$newStatus->value}.");
                }
            }
        });
    }

    public function items(): HasMany
    {
        return $this->hasMany(QuoteItem::class);
    }
}
