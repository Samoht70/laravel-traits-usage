<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasUlids, SoftDeletes;

    protected $fillable = [
        'creator_id',
        'name',
        'description',
        'price',
        'released_at',
        'stock',
    ];

    protected $casts = [
        'released_at' => 'datetime',
        'price' => 'decimal:2',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function scopePublished(EloquentBuilder $query): EloquentBuilder
    {
        return $query->whereNotNull('released_at');
    }

    public function publish(): bool
    {
        if (!is_null($this->released_at)) return false;

        $this->released_at = now();

        return $this->save();
    }

    public function published(): bool
    {
        return isset($this->released_at);
    }

    public function getCommentsCount(): int
    {
        return $this->comments()->count();
    }

    public function isAvailable(): bool
    {
        return $this->stock > 0;
    }

    public function decrementStock(int $quantity = 1): bool
    {
        if ($this->stock < $quantity) {
            return false;
        }

        $this->decrement('stock', $quantity);

        return true;
    }
}
