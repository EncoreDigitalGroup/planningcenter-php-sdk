<?php

namespace EncoreDigitalGroup\PlanningCenter\Support\Traits;

use Illuminate\Support\Collection;

trait HasAttributes
{
    protected Collection $attributes;

    public function setAttribute(string $key, mixed $value): self
    {
        $this->attributes->put($key, $value);

        return $this;
    }

    public function getAttribute(string $key, mixed $default = null): mixed
    {
        return $this->attributes->get($key, $default);
    }

    public function getAttributeString(string $key, string $default = ""): string
    {
        $attribute = $this->getAttribute($key, $default);

        if (!is_string($attribute)) {
            return $default;
        }

        return $attribute;
    }

    public function getAttributeInt(string $key, int $default = 0): int
    {
        $attribute = $this->getAttribute($key, $default);

        if (!is_int($attribute)) {
            return $default;
        }

        return $attribute;
    }
}