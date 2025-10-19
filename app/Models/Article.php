<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use HasUlids, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'published_at',
        'author_id',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function scopePublished(EloquentBuilder $query): EloquentBuilder
    {
        return $query->whereNotNull('published_at');
    }

    public function publish(): bool
    {
        if (!is_null($this->published_at)) return false;

        $this->published_at = now();

        return $this->save();
    }

    public function published(): bool
    {
        return isset($this->published_at);
    }

    public function getCommentsCount(): int
    {
        return $this->comments()->count();
    }
}
