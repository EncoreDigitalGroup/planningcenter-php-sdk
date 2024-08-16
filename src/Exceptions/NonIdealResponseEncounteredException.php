<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Exceptions;

use Exception;

/** @api */
class NonIdealResponseEncounteredException extends Exception
{
    public function __construct()
    {
        parent::__construct('Non-Ideal Planning Center Response Encountered');
    }
}
