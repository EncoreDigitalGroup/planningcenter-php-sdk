<?php

namespace EncoreDigitalGroup\PlanningCenter\Support\Traits;

trait HasQueryParameters
{
    /** @var array<string, mixed> */
    protected array $queryParameters = [];

    /**
     * Add include parameters for sideloading relationships
     *
     * @param  string  ...$includes  One or more relationship names to include
     */
    public function withInclude(string ...$includes): self
    {
        $existing = $this->queryParameters['include'] ?? '';
        $existingArray = $existing ? explode(',', $existing) : [];
        $merged = array_unique([...$existingArray, ...$includes]);
        $this->queryParameters['include'] = implode(',', $merged);

        return $this;
    }

    /**
     * Add a filter parameter
     *
     * @param  string  $key  The filter key (e.g., 'status', 'name')
     * @param  mixed  $value  The filter value
     */
    public function withFilter(string $key, mixed $value): self
    {
        if (!isset($this->queryParameters['where'])) {
            $this->queryParameters['where'] = [];
        }

        $this->queryParameters['where'][$key] = $value;

        return $this;
    }

    /**
     * Set the order parameter
     *
     * @param  string  $field  The field to order by (prefix with '-' for descending)
     */
    public function withOrder(string $field): self
    {
        $this->queryParameters['order'] = $field;

        return $this;
    }

    /**
     * Set the per_page parameter for pagination
     *
     * @param  int  $perPage  Number of items per page
     */
    public function withPerPage(int $perPage): self
    {
        $this->queryParameters['per_page'] = $perPage;

        return $this;
    }

    /**
     * Set the offset parameter for pagination
     *
     * @param  int  $offset  Number of items to skip
     */
    public function withOffset(int $offset): self
    {
        $this->queryParameters['offset'] = $offset;

        return $this;
    }

    /**
     * Get the accumulated query parameters
     *
     * @return array<string, mixed>
     */
    protected function getQueryParameters(): array
    {
        return $this->queryParameters;
    }

    /**
     * Clear all query parameters
     */
    public function clearQueryParameters(): self
    {
        $this->queryParameters = [];

        return $this;
    }

    /**
     * Merge explicit query array with accumulated query parameters
     *
     * Explicit parameters take precedence over accumulated ones.
     *
     * @param  array<string, mixed>  $explicitQuery
     * @return array<string, mixed>
     */
    protected function mergeQueryParameters(array $explicitQuery = []): array
    {
        return array_merge($this->getQueryParameters(), $explicitQuery);
    }
}