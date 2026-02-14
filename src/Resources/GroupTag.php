<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasApiMethods;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use Illuminate\Support\Collection;

class GroupTag
{
    use HasAttributes, HasClient, HasApiMethods;

    protected string $endpoint = '/groups/v2/tags';

    protected array $dateAttributes = [];

    protected array $readOnlyAttributes = [
        'id',
    ];

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->attributes = new Collection();
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->setApiVersion(PlanningCenterApiVersion::GROUPS_DEFAULT);
    }

    // Setters
    public function withId(string $value): self
    {
        return $this->setAttribute('id', $value);
    }

    public function withName(?string $value): self
    {
        return $this->setAttribute('name', $value);
    }

    public function withPosition(?int $value): self
    {
        return $this->setAttribute('position', $value);
    }

    // Getters
    public function id(): ?string
    {
        return $this->getAttribute('id');
    }

    public function name(): ?string
    {
        return $this->getAttribute('name');
    }

    public function position(): ?int
    {
        return $this->getAttribute('position');
    }
}
