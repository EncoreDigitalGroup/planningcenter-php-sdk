<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes;

use Illuminate\Support\Carbon;

class GroupAttributes
{
    public string $groupId;
    public ?Carbon $archivedAt;
    public ?string $contactEmail;
    public ?Carbon $createdAt;
    public ?string $description;
    public ?string $eventVisibility;
    public ?GroupHeaderImage $headerImage;
    public ?string $locationTypePreference;
    public ?int $membershipsCount;
    public ?string $name;
    public ?string $publicChurchCenterUrl;
    public ?string $schedule;
    public ?string $virtualLocationUrl;

    public function __construct()
    {
        $this->headerImage = new GroupHeaderImage;
    }
}