<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use Carbon\CarbonImmutable;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasApiMethods;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasQueryParameters;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasRead;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasResponse;
use Illuminate\Support\Collection;
use InvalidArgumentException;

/** @phpstan-consistent-constructor */
class CalendarTagGroup
{
    use HasApiMethods;
    use HasAttributes;
    use HasClient;
    use HasQueryParameters;
    use HasRead;
    use HasResponse;

    public const string ENDPOINT = "/calendar/v2/tag_groups";

    protected string $endpoint = self::ENDPOINT;

    /** Get tags for this tag group (lazy-loaded) */
    private ?Paginator $tags = null;

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->attributes = new Collection;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->setApiVersion(PlanningCenterApiVersion::CALENDAR_DEFAULT);
    }

    // Setters (for withId only, as this is read-only)
    public function withId(string $value): self
    {
        return $this->setAttribute("id", $value);
    }

    // Getters
    public function id(): ?string
    {
        return $this->getAttribute("id");
    }

    public function createdAt(): ?CarbonImmutable
    {
        return $this->getAttribute("created_at");
    }

    public function name(): ?string
    {
        return $this->getAttribute("name");
    }

    public function updatedAt(): ?CarbonImmutable
    {
        return $this->getAttribute("updated_at");
    }

    public function required(): ?bool
    {
        return $this->getAttribute("required");
    }

    /**
     * Get tags for this tag group (lazy-loaded)
     *
     * @param  array<string, mixed>  $query  Optional query parameters
     */
    public function tags(array $query = []): Paginator
    {
        if (!$this->tags instanceof Paginator) {
            $tagGroupId = $this->id();
            if ($tagGroupId === null) {
                throw new InvalidArgumentException("Cannot fetch tags for a tag group without an ID.");
            }

            $tagInstance = new CalendarTag($this->clientId, $this->clientSecret);
            $response = $tagInstance->client()->get(
                $tagInstance->hostname() . "/calendar/v2/tag_groups/{$tagGroupId}/tags",
                $this->mergeQueryParameters($query)
            );
            $this->tags = $tagInstance->buildPaginatorFromResponse($response);
        }

        return $this->tags;
    }

    protected function dateAttributes(): array
    {
        return [
            "created_at",
            "updated_at",
        ];
    }

    protected function readOnlyAttributes(): array
    {
        return [
            "id",
            "created_at",
            "name",
            "updated_at",
            "required",
        ];
    }
}
