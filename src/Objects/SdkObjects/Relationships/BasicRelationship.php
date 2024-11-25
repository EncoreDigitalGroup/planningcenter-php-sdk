<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\Relationships;

class BasicRelationship
{
    public function __construct(public ?BasicRelationshipData $data = null)
    {
        $this->data = $data ?? new BasicRelationshipData;
    }
}