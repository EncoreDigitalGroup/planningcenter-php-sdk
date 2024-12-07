<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Attributes;

use Illuminate\Support\Carbon;

class TagAttributes
{
    public string $tagId;
    public ?bool $churchCenterCategory = null;
    public ?string $color = null;
    public ?Carbon $createdAt = null;
    public ?string $name = null;
    public ?int $position = null;
    public ?Carbon $updatedAt = null;
}