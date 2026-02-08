<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2025. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\Relationships;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\Relationships\BasicRelationship;

/** @api */
class DeliveryRelationships
{
    public BasicRelationship $event;

    public function __construct()
    {
        $this->event = new BasicRelationship;
    }
}
