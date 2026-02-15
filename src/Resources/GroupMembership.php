<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use Carbon\CarbonImmutable;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasApiMethods;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use Illuminate\Support\Collection;

/** @phpstan-consistent-constructor */
class GroupMembership
{
    use HasApiMethods, HasAttributes, HasClient;

    public const string ENDPOINT = "/groups/v2/memberships";

    protected string $endpoint = self::ENDPOINT;
    protected array $readOnlyAttributes = [
        "id",
    ];

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->attributes = new Collection;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->setApiVersion(PlanningCenterApiVersion::GROUPS_DEFAULT);
    }

    /** Get all memberships for a specific group */
    public static function forGroup(
        string $clientId,
        string $clientSecret,
        string $groupId
    ): Paginator
    {
        $instance = new static($clientId, $clientSecret);

        $response = $instance->client()->get(
            $instance->hostname() . "/groups/v2/groups/{$groupId}/memberships"
        );

        return static::buildPaginatorFromResponse($response, $clientId, $clientSecret);
    }

    // Setters
    public function withId(string $value): self
    {
        return $this->setAttribute("id", $value);
    }

    public function withJoinedAt(?CarbonImmutable $value): self
    {
        return $this->setAttribute("joined_at", $value);
    }

    public function withRole(?string $value): self
    {
        return $this->setAttribute("role", $value);
    }

    // Getters
    public function id(): ?string
    {
        return $this->getAttribute("id");
    }

    public function joinedAt(): ?CarbonImmutable
    {
        return $this->getAttribute("joined_at");
    }

    public function role(): ?string
    {
        return $this->getAttribute("role");
    }
}
