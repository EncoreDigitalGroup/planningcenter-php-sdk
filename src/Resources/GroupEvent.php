<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use Carbon\CarbonImmutable;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasApiMethods;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use Illuminate\Support\Collection;

/** @phpstan-consistent-constructor */
class GroupEvent
{
    use HasApiMethods, HasAttributes, HasClient;

    public const string ENDPOINT = "/groups/v2/events";

    protected string $endpoint = self::ENDPOINT;
    protected array $readOnlyAttributes = [
        "id",
        "canceled_at",
        "reminders_sent",
        "reminders_sent_at",
        "visitors_count",
    ];

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->attributes = new Collection;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->setApiVersion(PlanningCenterApiVersion::GROUPS_DEFAULT);
    }

    protected function dateAttributes(): array
    {
        return [
            'canceled_at',
            'ends_at',
            'reminders_sent_at',
            'starts_at',
        ];
    }

    // Setters
    public function withId(string $value): self
    {
        return $this->setAttribute("id", $value);
    }

    public function withAttendanceRequestsEnabled(?bool $value): self
    {
        return $this->setAttribute("attendance_requests_enabled", $value);
    }

    public function withAutomatedReminderEnabled(?bool $value): self
    {
        return $this->setAttribute("automated_reminder_enabled", $value);
    }

    public function withCanceled(?bool $value): self
    {
        return $this->setAttribute("canceled", $value);
    }

    public function withDescription(?string $value): self
    {
        return $this->setAttribute("description", $value);
    }

    public function withEndsAt(?CarbonImmutable $value): self
    {
        return $this->setAttribute("ends_at", $value);
    }

    public function withLocationTypePreference(?string $value): self
    {
        return $this->setAttribute("location_type_preference", $value);
    }

    public function withMultiDay(?bool $value): self
    {
        return $this->setAttribute("multi_day", $value);
    }

    public function withName(?string $value): self
    {
        return $this->setAttribute("name", $value);
    }

    public function withRepeating(?bool $value): self
    {
        return $this->setAttribute("repeating", $value);
    }

    public function withStartsAt(?CarbonImmutable $value): self
    {
        return $this->setAttribute("starts_at", $value);
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

    public function attendanceRequestsEnabled(): ?bool
    {
        return $this->getAttribute("attendance_requests_enabled");
    }

    public function automatedReminderEnabled(): ?bool
    {
        return $this->getAttribute("automated_reminder_enabled");
    }

    public function canceled(): ?bool
    {
        return $this->getAttribute("canceled");
    }

    public function canceledAt(): ?CarbonImmutable
    {
        return $this->getAttribute("canceled_at");
    }

    public function description(): ?string
    {
        return $this->getAttribute("description");
    }

    public function endsAt(): ?CarbonImmutable
    {
        return $this->getAttribute("ends_at");
    }

    public function locationTypePreference(): ?string
    {
        return $this->getAttribute("location_type_preference");
    }

    public function multiDay(): ?bool
    {
        return $this->getAttribute("multi_day");
    }

    public function name(): ?string
    {
        return $this->getAttribute("name");
    }

    public function remindersSent(): ?bool
    {
        return $this->getAttribute("reminders_sent");
    }

    public function remindersSentAt(): ?CarbonImmutable
    {
        return $this->getAttribute("reminders_sent_at");
    }

    public function repeating(): ?bool
    {
        return $this->getAttribute("repeating");
    }

    public function startsAt(): ?CarbonImmutable
    {
        return $this->getAttribute("starts_at");
    }

    public function virtualLocationUrl(): ?string
    {
        return $this->getAttribute("virtual_location_url");
    }

    public function visitorsCount(): ?int
    {
        return $this->getAttribute("visitors_count");
    }
}
