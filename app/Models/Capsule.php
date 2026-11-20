<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Capsule extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     *
     * @var list<string>
     */
    protected $fillable = [
        'user_id',
        'title',
        'description',
        'message',
        'image',
        'open_at',
        'opened_at',
        'is_archived',
    ];

    /**
     * Attributes casting.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'open_at' => 'datetime',
            'opened_at' => 'datetime',
            'is_archived' => 'boolean',
        ];
    }

    /**
     * Relationship: Capsule owner.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Check if capsule is ready to open (open_at <= now).
     */
    public function isReadyToOpen(): bool
    {
        return $this->open_at->isPast();
    }

    /**
     * Check if capsule is still locked/closed (open_at > now).
     */
    public function isClosed(): bool
    {
        return $this->open_at->isFuture();
    }

    /**
     * Check if user has officially opened and revealed the capsule.
     */
    public function isOpened(): bool
    {
        return !is_null($this->opened_at);
    }

    /**
     * Get computed status code.
     */
    public function getStatusCodeAttribute(): string
    {
        if ($this->isClosed()) {
            return 'closed';
        }

        if ($this->isOpened()) {
            return 'opened';
        }

        return 'ready';
    }

    /**
     * Get Arabic label for status.
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status_code) {
            'closed' => 'مغلقة ومحمية',
            'ready' => 'متاحة للفتح الآن',
            'opened' => 'مفتوحة ومقروءة',
            default => 'غير محددة',
        };
    }

    /**
     * Get image URL if exists.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return null;
        }

        return Storage::disk('public')->url($this->image);
    }

    /**
     * Once created, a capsule is permanently sealed and cannot be edited.
     */
    public function canBeEdited(): bool
    {
        return false;
    }

    /**
     * Whether the capsule can be deleted (only while closed/unopened).
     */
    public function canBeDeleted(): bool
    {
        return !$this->isOpened();
    }

    /**
     * Scope for closed capsules (open_at in the future).
     */
    public function scopeClosed(Builder $query): Builder
    {
        return $query->where('open_at', '>', now())->where('is_archived', false);
    }

    /**
     * Scope for ready to open capsules (open_at in past, not yet opened).
     */
    public function scopeReadyToOpen(Builder $query): Builder
    {
        return $query->where('open_at', '<=', now())
            ->whereNull('opened_at')
            ->where('is_archived', false);
    }

    /**
     * Scope for opened capsules.
     */
    public function scopeOpened(Builder $query): Builder
    {
        return $query->whereNotNull('opened_at')->where('is_archived', false);
    }

    /**
     * Scope for active (non-archived) capsules.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_archived', false);
    }
}
