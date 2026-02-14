<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasApiMethods;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use Illuminate\Support\Collection;

class GroupMemberPerson
{
    use HasAttributes, HasClient, HasApiMethods;

    protected string $endpoint = '/groups/v2/people';

    protected array $dateAttributes = [];

    protected array $readOnlyAttributes = [
        'id',
        'child',
        'first_name',
        'last_name',
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

    // Getters
    public function id(): ?string
    {
        return $this->getAttribute('id');
    }

    public function child(): ?bool
    {
        return $this->getAttribute('child');
    }

    public function firstName(): ?string
    {
        return $this->getAttribute('first_name');
    }

    public function lastName(): ?string
    {
        return $this->getAttribute('last_name');
    }
}
