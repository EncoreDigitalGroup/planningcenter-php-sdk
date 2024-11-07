<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People\Attributes;

use DateTime;
use Illuminate\Support\Carbon;

class EmailAttributes
{
    public string|int|null $personId;
    public ?string $emailAddressId;
    public ?string $address;
    public ?string $location;
    public ?bool $primary;
    public ?Carbon $createdAt;
    public ?Carbon $updatedAt;
    public mixed $blocked;
}
