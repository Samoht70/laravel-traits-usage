<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait SearchableWithCustomMapping
{
    public function mappableAs(): array
    {
        return [];
    }

    public function indexSettings(): array
    {
        return [
            'max_ngram_diff' => 19,
            'analysis' => [
                'filter' => [
                    'letter_filter' => [
                        'type' => 'ngram',
                        'min_gram' => 2,
                        'max_gram' => 20,
                    ],
                ],
                'analyzer' => [
                    'index_analyzer' => [
                        'type' => 'custom',
                        'tokenizer' => 'standard',
                        'filter' => ['lowercase', 'asciifolding', 'letter_filter'],
                    ],
                    'search_analyzer' => [
                        'type' => 'custom',
                        'tokenizer' => 'standard',
                        'filter' => ['lowercase', 'asciifolding'],
                    ],
                ],
            ],
        ];
    }

    public function toSearchableArray(): array
    {
        return [];
    }

    protected function makeAllSearchableUsing(Builder $query): Builder
    {
        return $query->with($this->getSearchableWith());
    }

    public function getSearchableMapping(): array
    {
        return $this->searchableMapping;
    }

    protected function getSearchableWith(): array
    {
        return $this->searchableWith ?? [];
    }

    public function getSearchableFields(): array
    {
        return array_keys($this->searchableMapping);
    }
}
