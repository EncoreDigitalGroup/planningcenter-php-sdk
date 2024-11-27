<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes;

class GroupMemberPersonAttributes
{
    public string $personId;
    public ?bool $child = null;
    public ?string $firstName = null;
    public ?string $lastName = null;
}