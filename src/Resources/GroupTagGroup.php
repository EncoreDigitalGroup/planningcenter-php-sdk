<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

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
class GroupTagGroup
{
    use HasApiMethods;
    use HasAttributes;
    use HasClient;
    use HasQueryParameters;
    use HasRead;
    use HasResponse;

    public const string ENDPOINT = "/groups/v2/tag_groups";

    protected string $endpoint = self::ENDPOINT;

    /** Get tags for this tag group (lazy-loaded) */
    private ?Paginator $tags = null;

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->attributes = new Collection;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->setApiVersion(PlanningCenterApiVersion::GROUPS_DEFAULT);
    }

    // Setters
    public function withId(string $value): self
    {
        return $this->setAttribute("id", $value);
    }

    public function withDisplayPublicly(?bool $value): self
    {
        return $this->setAttribute("display_publicly", $value);
    }

    public function withMultipleOptionsEnabled(?bool $value): self
    {
        return $this->setAttribute("multiple_options_enabled", $value);
    }

    public function withName(?string $value): self
    {
        return $this->setAttribute("name", $value);
    }

    public function withPosition(?int $value): self
    {
        return $this->setAttribute("position", $value);
    }

    // Getters
    public function id(): ?string
    {
        return $this->getAttribute("id");
    }

    public function displayPublicly(): ?bool
    {
        return $this->getAttribute("display_publicly");
    }

    public function multipleOptionsEnabled(): ?bool
    {
        return $this->getAttribute("multiple_options_enabled");
    }

    public function name(): ?string
    {
        return $this->getAttribute("name");
    }

    public function position(): ?int
    {
        return $this->getAttribute("position");
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

            $tagInstance = new GroupTag($this->clientId, $this->clientSecret);
            $response = $tagInstance->client()->get(
                $tagInstance->hostname() . "/groups/v2/tag_groups/{$tagGroupId}/tags",
                $this->mergeQueryParameters($query)
            );
            $this->tags = $tagInstance->buildPaginatorFromResponse($response);
        }

        return $this->tags;
    }

    protected function readOnlyAttributes(): array
    {
        return ["id"];
    }
}
