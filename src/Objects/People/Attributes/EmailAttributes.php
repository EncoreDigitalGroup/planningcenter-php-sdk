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
    public function __construct(
        public string|int|null $personId = null,
        public ?string         $emailAddressId = null,
        public ?string         $address = null,
        public ?string         $location = null,
        public ?bool           $primary = null,
        public ?Carbon         $createdAt = null,
        public ?Carbon         $updatedAt = null,
        public mixed           $blocked = null,

    )
    {
    }

}
