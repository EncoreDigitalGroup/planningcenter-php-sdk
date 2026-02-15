<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasApiMethods;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasRead;
use Illuminate\Support\Collection;

/** @phpstan-consistent-constructor */
class GroupTag
{
    use HasApiMethods, HasAttributes, HasClient, HasRead;

    public const string ENDPOINT = "/groups/v2/tags";

    protected string $endpoint = self::ENDPOINT;

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

    public function name(): ?string
    {
        return $this->getAttribute("name");
    }

    public function position(): ?int
    {
        return $this->getAttribute("position");
    }

    protected function readOnlyAttributes(): array
    {
        return ["id"];
    }
}
