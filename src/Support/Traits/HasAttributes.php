<?php

namespace EncoreDigitalGroup\PlanningCenter\Support\Traits;

use Carbon\CarbonImmutable;
use Illuminate\Support\Collection;

trait HasAttributes
{
    protected Collection $attributes;

    public function __construct()
    {
        $this->attributes = new Collection;
    }

    /**
     * Get the list of attributes that should be parsed as dates.
     * Override this method in your class to specify date attributes.
     *
     * @return array<int, string>
     */
    protected function dateAttributes(): array
    {
        return [];
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

    public function getAttributeDate(string $key, ?CarbonImmutable $default = null): CarbonImmutable
    {
        if (is_null($default)) {
            $default = CarbonImmutable::now();
        }

        $attribute = $this->getAttribute($key);

        if (!$attribute instanceof CarbonImmutable) {
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
        if ($value === null || $value === '') {
            return null;
        }

        try {
            return CarbonImmutable::parse($value);
        } catch (\Exception $e) {
            // If parsing fails, return null instead of throwing
            return null;
        }
    }

    protected function hydrateFromArray(array $data): void
    {
        if (isset($data["id"])) {
            $this->setAttribute("id", $data["id"]);
        }

        foreach ($data["attributes"] ?? [] as $key => $value) {
            // Parse dates/datetimes if specified in dateAttributes
            if (in_array($key, $this->dateAttributes(), strict: true)) {
                $value = $this->parseDate($value);
            }
            $this->setAttribute($key, $value);
        }
    }
}