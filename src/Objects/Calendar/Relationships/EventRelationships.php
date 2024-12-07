<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Relationships;

use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Tag;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\Relationships\BasicRelationship;
use Illuminate\Support\Collection;

class EventRelationships
{
    /** @var Collection<Tag> */
    public Collection $tags;

    public function __construct(public ?BasicRelationship $owner = null)
    {
        $this->owner = $owner ?? new BasicRelationship;
        $this->tags = new Collection;
    }
}