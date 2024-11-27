<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Attributes;

use Illuminate\Support\Carbon;

class EventAttributes
{
    public string $eventId;
    public ?string $approvalStatus;
    public ?Carbon $createdAt;
    public ?string $description;
    public ?bool $featured;
    public ?string $imageUrl;
    public ?string $name;
    public ?int $percentApproved;
    public ?int $percentRejected;
    public ?string $registrationUrl;
    public ?string $summary;
    public ?Carbon $updatedAt;
    public ?bool $visibleInChurchCenter;
}