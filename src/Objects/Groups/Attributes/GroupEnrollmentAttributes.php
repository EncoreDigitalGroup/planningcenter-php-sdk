<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes;

use DateTime;
use Illuminate\Support\Carbon;

class GroupEnrollmentAttributes
{
    public string|int|null $groupId;
    public ?bool $autoClosed = false;
    public ?string $autoClosedReason;
    public DateTime|Carbon|null $dateLimit;
    public ?bool $dateLimitReached = false;
    public ?int $memberLimit;
    public ?bool $memberLimitReached = false;
    public ?string $status;
    public ?string $strategy;
}