<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

trait Publishable
{
    protected function initializePublishable(): void
    {
        if (! isset($this->casts[$this->getPublishedAtColumn()])) {
            $this->casts[$this->getPublishedAtColumn()] = 'datetime';
        }
    }

    public function scopePublished(EloquentBuilder $query): EloquentBuilder
    {
        return $query->whereNotNull($this->getPublishedAtColumn());
    }

    public function publish(): bool
    {
        if (!is_null($this->{$this->getPublishedAtColumn()})) return false;

        $this->{$this->getPublishedAtColumn()} = now();

        return $this->save();
    }

    public function published(): bool
    {
        return isset($this->{$this->getPublishedAtColumn()});
    }

    public function getPublishedAtColumn()
    {
        return defined(static::class.'::PUBLISHED_AT') ? static::PUBLISHED_AT : 'published_at';
    }

    public function getQualifiedPublishedAtColumn(): string
    {
        return $this->qualifyColumn($this->getPublishedAtColumn());
    }
}
