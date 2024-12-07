<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes;

use Illuminate\Support\Carbon;

class GroupMembershipAttributes
{
    public ?Carbon $joinedAt = null;
    public ?string $role = null;
}