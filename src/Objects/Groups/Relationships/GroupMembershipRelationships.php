<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups\Relationships;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\Relationships\BasicRelationship;

class GroupMembershipRelationships
{
    public function __construct(
        public ?BasicRelationship $group = null,
        public ?BasicRelationship $person = null
    )
    {
        $this->group = $group ?? new BasicRelationship;
        $this->person = $person ?? new BasicRelationship;
    }
}