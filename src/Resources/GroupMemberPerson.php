<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasApiMethods;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use Illuminate\Support\Collection;

/** @phpstan-consistent-constructor */
class GroupMemberPerson
{
    use HasApiMethods, HasAttributes, HasClient;

    public const string ENDPOINT = "/groups/v2/people";

    protected string $endpoint = self::ENDPOINT;
    protected array $dateAttributes = [];
    protected array $readOnlyAttributes = [
        "id",
        "child",
        "first_name",
        "last_name",
    ];

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

    // Getters
    public function id(): ?string
    {
        return $this->getAttribute("id");
    }

    public function child(): ?bool
    {
        return $this->getAttribute("child");
    }

    public function firstName(): ?string
    {
        return $this->getAttribute("first_name");
    }

    public function lastName(): ?string
    {
        return $this->getAttribute("last_name");
    }
}
