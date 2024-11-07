<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People\PersonMerger;

use DateTime;
use Illuminate\Support\Carbon;

class PersonMergerAttributes
{
    public Carbon $createdAt;
    public int $personToKeepId;
    public int $personToRemoveId;
}
