<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2025. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\Relationships;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\Relationships\BasicRelationship;
use Illuminate\Support\Collection;

/** @api */
class EventRelationships
{
    public BasicRelationship $subscription;
    public BasicRelationship $person;
    public Collection $deliveries;

    public function __construct()
    {
        $this->subscription = new BasicRelationship;
        $this->person = new BasicRelationship;
        $this->deliveries = new Collection;
    }
}
