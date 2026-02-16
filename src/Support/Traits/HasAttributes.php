<?php

namespace EncoreDigitalGroup\PlanningCenter\Support\Traits;

use Carbon\CarbonImmutable;
use Exception;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

trait HasAttributes
{
    protected Collection $attributes;

    public function __construct()
    {
        $this->attributes = new Collection;
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

    public function getAttributeDate(string $key, ?CarbonImmutable $default = null): ?CarbonImmutable
    {
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

    /**
     * Get the list of read-only attributes that should not be sent to the API.
     * Override this method in your class to specify additional read-only attributes.
     *
     * @return array<int, string>
     */
    protected function readOnlyAttributes(): array
    {
        return ["id", "created_at", "updated_at"];
    }

    /**
     * Get the list of date attributes that should use date-only format (Y-m-d).
     * Override this method in your class to specify date-only attributes.
     * Other date attributes will use full ISO8601 datetime format.
     * Note: These are automatically included in dateAttributes() for parsing.
     *
     * @return array<int, string>
     */
    protected function dateOnlyAttributes(): array
    {
        return [];
    }

    protected function parseDate(?string $value): ?CarbonImmutable
    {
        if ($value === null || $value === "") {
            return null;
        }

        try {
            return CarbonImmutable::parse($value);
        } catch (Exception $e) {
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
            // Parse dates/datetimes if specified in dateAttributes or dateOnlyAttributes
            if (in_array($key, $this->getAllDateAttributes(), strict: true)) {
                $value = $this->parseDate($value);
            }
            $this->setAttribute($key, $value);
        }
    }

    /** Hydrate attributes from API response */
    protected function hydrateFromResponse(Response $response): void
    {
        $data = $response->json("data");

        if (is_null($data)) {
            return;
        }

        // Handle array responses (list endpoints)
        if (is_array($data) && isset($data[0])) {
            $data = $data[0];
        }

        $this->hydrateFromArray($data);
    }

    /** Convert attributes to Planning Center API format */
    protected function mapToPco(): array
    {
        // Exclude read-only attributes
        $attributes = $this->attributes
            ->except($this->readOnlyAttributes())
            ->toArray();

        // Convert CarbonImmutable to strings
        foreach ($attributes as $key => $value) {
            if ($value instanceof CarbonImmutable) {
                // Use date-only format for specified fields, datetime for others
                $attributes[$key] = in_array($key, $this->dateOnlyAttributes(), strict: true)
                    ? $value->toDateString()
                    : $value->toIso8601String();
            }
        }

        return [
            "data" => [
                "attributes" => array_filter($attributes, fn ($v): bool => $v !== null),
            ],
        ];
    }

    /**
     * Get all date attributes including date-only attributes.
     * This ensures dateOnlyAttributes are always parsed as dates.
     *
     * @return array<int, string>
     */
    private function getAllDateAttributes(): array
    {
        return array_unique(array_merge($this->dateAttributes(), $this->dateOnlyAttributes()));
    }
}