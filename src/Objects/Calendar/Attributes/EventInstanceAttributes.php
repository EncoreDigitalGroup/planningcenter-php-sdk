<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Attributes;

use Illuminate\Support\Carbon;

class EventInstanceAttributes
{
    public string $eventInstanceId;
    public ?bool $allDayEvent;
    public ?string $compactRecurrenceDescription;
    public ?Carbon $createdAt;
    public ?Carbon $endsAt;
    public ?string $location;
    public ?string $recurrence;
    public ?string $recurrenceDescription;
    public ?Carbon $startsAt;
    public ?Carbon $updatedAt;
    public ?string $churchCenterUrl;
    public ?string $publishedStartAt;
    public ?string $publishedEndsAt;
}