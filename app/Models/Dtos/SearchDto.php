<?php

namespace App\Models\Dtos;

use App\Http\Requests\SearchRequest;

/**
 * @property string $q
 * @property array $type
 * @property string|null $market
 * @property int|null $limit
 * @property int|null $offset
 * @property string|null $include_external
 */
class SearchDto
{
    private array $attributes = [];

    public function __construct(SearchRequest $attributes)
    {
        $this->attributes = $attributes->validated();
    }

    public function __get($name)
    {
        if ($name === 'type') {
            return implode(',', $this->attributes[$name]);
        }

        return $this->attributes[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }

    public function __isset($name)
    {
        return isset($this->attributes[$name]);
    }

    public function toArray(): array
    {
        return [
            ...$this->attributes,
            'type' => implode(',', $this->attributes['type']),
        ];
    }
}
