<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use Carbon\CarbonImmutable;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasApiMethods;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasRead;
use Illuminate\Support\Collection;

/** @phpstan-consistent-constructor */
class GroupEnrollment
{
    use HasApiMethods, HasAttributes, HasClient, HasRead;

    public const string ENDPOINT = "/groups/v2/group_enrollments";

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

    public function withDateLimit(?CarbonImmutable $value): self
    {
        return $this->setAttribute("date_limit", $value);
    }

    public function withMemberLimit(?int $value): self
    {
        return $this->setAttribute("member_limit", $value);
    }

    public function withStatus(?string $value): self
    {
        return $this->setAttribute("status", $value);
    }

    public function withStrategy(?string $value): self
    {
        return $this->setAttribute("strategy", $value);
    }

    // Getters
    public function id(): ?string
    {
        return $this->getAttribute("id");
    }

    public function autoClosed(): ?bool
    {
        return $this->getAttribute("auto_closed");
    }

    public function autoClosedReason(): ?string
    {
        return $this->getAttribute("auto_closed_reason");
    }

    public function dateLimit(): ?CarbonImmutable
    {
        return $this->getAttribute("date_limit");
    }

    public function dateLimitReached(): ?bool
    {
        return $this->getAttribute("date_limit_reached");
    }

    public function memberLimit(): ?int
    {
        return $this->getAttribute("member_limit");
    }

    public function memberLimitReached(): ?bool
    {
        return $this->getAttribute("member_limit_reached");
    }

    public function status(): ?string
    {
        return $this->getAttribute("status");
    }

    public function strategy(): ?string
    {
        return $this->getAttribute("strategy");
    }

    protected function dateAttributes(): array
    {
        return [
            "date_limit",
        ];
    }

    protected function readOnlyAttributes(): array
    {
        return [
            "id",
            "auto_closed",
            "auto_closed_reason",
            "date_limit_reached",
            "member_limit_reached",
        ];
    }
}
