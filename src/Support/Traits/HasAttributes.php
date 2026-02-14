<?php

namespace EncoreDigitalGroup\PlanningCenter\Support\Traits;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

trait HasAttributes
{
    protected Collection $attributes;

    public function __construct()
    {
        $this->attributes = new Collection();
    }

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

    public function toArray(): array
    {
        return $this->attributes->toArray();
    }

    protected function parseDate(?string $value): ?CarbonImmutable
    {
        if ($value === null) {
            return null;
        }

        return CarbonImmutable::parse($value);
    }

    protected function hydrateFromArray(array $data): void
    {
        if (isset($data['id'])) {
            $this->setAttribute('id', $data['id']);
        }

        foreach ($data['attributes'] ?? [] as $key => $value) {
            // Parse dates/datetimes if dateAttributes is defined
            if (property_exists($this, 'dateAttributes') && in_array($key, $this->dateAttributes)) {
                $value = $this->parseDate($value);
            }
            $this->setAttribute($key, $value);
        }
    }
}