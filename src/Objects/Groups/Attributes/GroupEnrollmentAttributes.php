<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes;

use Illuminate\Support\Carbon;

class GroupEnrollmentAttributes
{
    public string $groupId;
    public ?bool $autoClosed = null;
    public ?string $autoClosedReason = null;
    public ?Carbon $dateLimit = null;
    public ?bool $dateLimitReached = false;
    public ?int $memberLimit = null;
    public ?bool $memberLimitReached = null;
    public ?string $status = null;
    public ?string $strategy = null;
}