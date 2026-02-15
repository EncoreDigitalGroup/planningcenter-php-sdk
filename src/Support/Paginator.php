<?php

namespace EncoreDigitalGroup\PlanningCenter\Support;

use Illuminate\Support\Collection;

/** @template TResource */
class Paginator
{
    /** @param Collection<int, TResource> $data */
    public function __construct(
        private Collection $data,
        private ?string $nextUrl,
        private ?string $prevUrl,
        private int $totalCount,
        private int $perPage
    ) {}

    /**
     * Get the items in the current page
     *
     * @return Collection<int, TResource>
     */
    public function items(): Collection
    {
        return $this->data;
    }

    /** Check if there are more pages */
    public function hasMore(): bool
    {
        return $this->nextUrl !== null;
    }

    /** Check if there is a previous page */
    public function hasPrevious(): bool
    {
        return $this->prevUrl !== null;
    }

    /** Get the total count of items across all pages */
    public function totalCount(): int
    {
        return $this->totalCount;
    }

    /** Get the number of items per page */
    public function perPage(): int
    {
        return $this->perPage;
    }

    /** Get the next page URL */
    public function nextUrl(): ?string
    {
        return $this->nextUrl;
    }

    /** Get the previous page URL */
    public function prevUrl(): ?string
    {
        return $this->prevUrl;
    }
}
