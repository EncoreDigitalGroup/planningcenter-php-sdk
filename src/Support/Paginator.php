<?php

namespace EncoreDigitalGroup\PlanningCenter\Support;

use Illuminate\Support\Collection;

class Paginator
{
    public function __construct(
        private Collection $data,
        private ?string $nextUrl,
        private ?string $prevUrl,
        private int $totalCount,
        private int $perPage
    ) {}

    /**
     * Get the items in the current page
     */
    public function items(): Collection
    {
        return $this->data;
    }

    /**
     * Check if there are more pages
     */
    public function hasMore(): bool
    {
        return $this->nextUrl !== null;
    }

    /**
     * Check if there is a previous page
     */
    public function hasPrevious(): bool
    {
        return $this->prevUrl !== null;
    }

    /**
     * Fetch the next page
     */
    public function next(): ?Paginator
    {
        if (!$this->hasMore()) {
            return null;
        }

        // The next page will need to be fetched via the client
        // This is a placeholder - actual implementation will require client access
        throw new \BadMethodCallException(
            'Pagination navigation not yet implemented. Use the query parameters to fetch specific pages.'
        );
    }

    /**
     * Fetch the previous page
     */
    public function prev(): ?Paginator
    {
        if (!$this->hasPrevious()) {
            return null;
        }

        // The prev page will need to be fetched via the client
        // This is a placeholder - actual implementation will require client access
        throw new \BadMethodCallException(
            'Pagination navigation not yet implemented. Use the query parameters to fetch specific pages.'
        );
    }

    /**
     * Get the total count of items across all pages
     */
    public function totalCount(): int
    {
        return $this->totalCount;
    }

    /**
     * Get the number of items per page
     */
    public function perPage(): int
    {
        return $this->perPage;
    }

    /**
     * Get the next page URL
     */
    public function nextUrl(): ?string
    {
        return $this->nextUrl;
    }

    /**
     * Get the previous page URL
     */
    public function prevUrl(): ?string
    {
        return $this->prevUrl;
    }
}
