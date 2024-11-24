<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Relationships;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\Relationships\BasicRelationship;

class EventRelationships
{
    public function __construct(public ?BasicRelationship $owner = null)
    {
        $this->owner = $owner ?? new BasicRelationship;
    }

}