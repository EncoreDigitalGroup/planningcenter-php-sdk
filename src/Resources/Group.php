<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use Carbon\CarbonImmutable;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasApiMethods;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use Illuminate\Support\Collection;

/**
 * @phpstan-consistent-constructor
 */
class Group
{
    use HasApiMethods, HasAttributes, HasClient;

    public const string GROUPS_ENDPOINT = "/groups/v2/groups";

    protected string $endpoint = "/groups/v2/groups";
    protected array $readOnlyAttributes = [
        "id",
        "archived_at",
        "created_at",
        "memberships_count",
        "public_church_center_url",
    ];

    /** Get memberships for this group (lazy-loaded) */
    private ?Collection $memberships = null;

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->attributes = new Collection;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->setApiVersion(PlanningCenterApiVersion::GROUPS_DEFAULT);
    }

    /** Static factory method for backward compatibility with tests */
    public static function make(string $clientId, string $clientSecret): self
    {
        return new self($clientId, $clientSecret);
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

    public function memberships(): Collection
    {
        if (!$this->memberships instanceof Collection) {
            $this->memberships = GroupMembership::forGroup(
                $this->clientId,
                $this->clientSecret,
                $this->getAttribute("id")
            )->items();
        }

        return $this->memberships;
    }
}
