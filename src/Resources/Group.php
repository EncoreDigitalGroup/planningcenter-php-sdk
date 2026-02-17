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
class Group
{
    use HasApiMethods;
    use HasAttributes;
    use HasClient;
    use HasQueryParameters;
    use HasRead;
    use HasResponse;

    public const string ENDPOINT = "/groups/v2/groups";

    protected string $endpoint = self::ENDPOINT;

    /** Get memberships for this group (lazy-loaded) */
    private ?Paginator $memberships = null;

    /** Get tags for this group (lazy-loaded) */
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

    public function withContactEmail(?string $value): self
    {
        return $this->setAttribute("contact_email", $value);
    }

    public function withDescription(?string $value): self
    {
        return $this->setAttribute("description", $value);
    }

    public function withEventVisibility(?string $value): self
    {
        return $this->setAttribute("event_visibility", $value);
    }

    public function withLocationTypePreference(?string $value): self
    {
        return $this->setAttribute("location_type_preference", $value);
    }

    public function withName(?string $value): self
    {
        return $this->setAttribute("name", $value);
    }

    public function withSchedule(?string $value): self
    {
        return $this->setAttribute("schedule", $value);
    }

    public function withVirtualLocationUrl(?string $value): self
    {
        return $this->setAttribute("virtual_location_url", $value);
    }

    // Getters
    public function id(): ?string
    {
        return $this->getAttribute("id");
    }

    public function archivedAt(): ?CarbonImmutable
    {
        return $this->getAttribute("archived_at");
    }

    public function contactEmail(): ?string
    {
        return $this->getAttribute("contact_email");
    }

    public function createdAt(): ?CarbonImmutable
    {
        return $this->getAttribute("created_at");
    }

    public function description(): ?string
    {
        return $this->getAttribute("description");
    }

    public function eventVisibility(): ?string
    {
        return $this->getAttribute("event_visibility");
    }

    public function locationTypePreference(): ?string
    {
        return $this->getAttribute("location_type_preference");
    }

    public function membershipsCount(): ?int
    {
        return $this->getAttribute("memberships_count");
    }

    public function name(): ?string
    {
        return $this->getAttribute("name");
    }

    public function publicChurchCenterUrl(): ?string
    {
        return $this->getAttribute("public_church_center_url");
    }

    public function schedule(): ?string
    {
        return $this->getAttribute("schedule");
    }

    public function virtualLocationUrl(): ?string
    {
        return $this->getAttribute("virtual_location_url");
    }

    public function headerImage(): ?string
    {
        return ($this->getAttribute("header_image") ?? [])["original"] ?? null;
    }

    /**
     * Get memberships for this group (lazy-loaded)
     *
     * @param  array<string, mixed>  $query  Optional query parameters
     */
    public function memberships(array $query = []): Paginator
    {
        if (!$this->memberships instanceof Paginator) {
            $groupId = $this->id();
            if ($groupId === null) {
                throw new InvalidArgumentException("Cannot fetch memberships for a group without an ID.");
            }

            $membershipInstance = new GroupMembership($this->clientId, $this->clientSecret);
            $membershipInstance->setAuthType($this->authType);
            $response = $membershipInstance->client()->get(
                $membershipInstance->hostname() . "/groups/v2/groups/{$groupId}/memberships",
                $this->mergeQueryParameters($query)
            );
            $this->memberships = $membershipInstance->buildPaginatorFromResponse($response);
        }

        return $this->memberships;
    }

    /**
     * Get tags for this group (lazy-loaded)
     *
     * @param  array<string, mixed>  $query  Optional query parameters
     */
    public function tags(array $query = []): Paginator
    {
        if (!$this->tags instanceof Paginator) {
            $groupId = $this->id();
            if ($groupId === null) {
                throw new InvalidArgumentException("Cannot fetch tags for a group without an ID.");
            }

            $tagInstance = new GroupTag($this->clientId, $this->clientSecret);
            $tagInstance->setAuthType($this->authType);
            $response = $tagInstance->client()->get(
                $tagInstance->hostname() . "/groups/v2/groups/{$groupId}/tags",
                $this->mergeQueryParameters($query)
            );
            $this->tags = $tagInstance->buildPaginatorFromResponse($response);
        }

        return $this->tags;
    }

    protected function dateAttributes(): array
    {
        return [
            "archived_at",
            "created_at",
        ];
    }

    protected function readOnlyAttributes(): array
    {
        return [
            "id",
            "archived_at",
            "created_at",
            "memberships_count",
            "public_church_center_url",
        ];
    }
}
