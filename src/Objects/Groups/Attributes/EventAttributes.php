<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes;

use Illuminate\Support\Carbon;

class EventAttributes
{
    public string $eventId;
    public ?bool $attendanceRequestsEnabled;
    public ?bool $automatedReminderEnabled;
    public ?bool $canceled;
    public ?Carbon $canceledAt;
    public ?string $description;
    public ?Carbon $endsAt;
    public ?string $locationTypePreference;
    public ?bool $multiDay;
    public ?string $name;
    public ?bool $remindersSent;
    public ?Carbon $remindersSentAt;
    public ?bool $repeating;
    public ?Carbon $startsAt;
    public ?string $virtualLocationUrl;
    public ?int $visitorsCount;

}