<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Attributes;

use Illuminate\Support\Carbon;

class TagGroupAttributes
{
    public string $tagGroupId;
    public ?Carbon $createdAt;
    public ?string $name;
    public ?Carbon $updatedAt;
    public ?bool $required;
}