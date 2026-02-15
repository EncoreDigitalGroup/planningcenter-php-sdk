<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use Carbon\CarbonImmutable;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasApiMethods;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasRead;
use Illuminate\Support\Collection;

/** @phpstan-consistent-constructor */
class CalendarTag
{
    use HasApiMethods, HasAttributes, HasClient, HasRead;

    public const string ENDPOINT = "/calendar/v2/tags";

    protected string $endpoint = self::ENDPOINT;

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

    public function churchCenterCategory(): ?bool
    {
        return $this->getAttribute("church_center_category");
    }

    public function color(): ?string
    {
        return $this->getAttribute("color");
    }

    public function createdAt(): ?CarbonImmutable
    {
        return $this->getAttribute("created_at");
    }

    public function name(): ?string
    {
        return $this->getAttribute("name");
    }

    public function position(): ?int
    {
        return $this->getAttribute("position");
    }

    public function updatedAt(): ?CarbonImmutable
    {
        return $this->getAttribute("updated_at");
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
            "church_center_category",
            "color",
            "created_at",
            "name",
            "position",
            "updated_at",
        ];
    }
}
