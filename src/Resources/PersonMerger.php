<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use Carbon\CarbonImmutable;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasApiMethods;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasQueryParameters;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasRead;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasResponse;
use Illuminate\Support\Collection;

/** @phpstan-consistent-constructor */
class PersonMerger
{
    use HasApiMethods;
    use HasAttributes;
    use HasClient;
    use HasQueryParameters;
    use HasRead;
    use HasResponse;

    public const string ENDPOINT = "/people/v2/person_mergers";

    protected string $endpoint = self::ENDPOINT;

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->attributes = new Collection;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->setApiVersion(PlanningCenterApiVersion::PEOPLE_DEFAULT);
    }

    // Setters
    public function withId(string $value): self
    {
        return $this->setAttribute("id", $value);
    }

    public function withPersonToKeepId(?int $value): self
    {
        return $this->setAttribute("person_to_keep_id", $value);
    }

    public function withPersonToRemoveId(?int $value): self
    {
        return $this->setAttribute("person_to_remove_id", $value);
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

    public function personToKeepId(): ?int
    {
        return $this->getAttribute("person_to_keep_id");
    }

    public function personToRemoveId(): ?int
    {
        return $this->getAttribute("person_to_remove_id");
    }

    protected function dateAttributes(): array
    {
        return [
            "created_at",
        ];
    }

    protected function readOnlyAttributes(): array
    {
        return [
            "id",
            "created_at",
            "person_to_keep_id",
            "person_to_remove_id",
        ];
    }
}
