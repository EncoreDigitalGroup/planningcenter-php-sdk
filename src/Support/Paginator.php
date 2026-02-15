<?php

namespace EncoreDigitalGroup\PlanningCenter\Support;

use Illuminate\Http\Client\Response;
use Illuminate\Support\Collection;

/** @template TResource */
readonly class Paginator
{
    /** @param Collection<int, TResource> $data */
    public function __construct(
        private Response   $response,
        private Collection $data,
        private ?string    $nextUrl,
        private ?string    $prevUrl,
        private int        $totalCount,
        private int        $perPage
    ) {}

    /**
     * @return Collection<int, TResource>
     */
    public function items(): Collection
    {
        return $this->data;
    }

    public function hasMore(): bool
    {
        return $this->nextUrl !== null;
    }

    public function hasPrevious(): bool
    {
        return $this->prevUrl !== null;
    }

    public function totalCount(): int
    {
        return $this->totalCount;
    }

    public function perPage(): int
    {
        return $this->perPage;
    }

    public function nextUrl(): ?string
    {
        return $this->nextUrl;
    }

    public function prevUrl(): ?string
    {
        return $this->prevUrl;
    }

    public function response(): Response
    {
        return $this->response;
    }
}
