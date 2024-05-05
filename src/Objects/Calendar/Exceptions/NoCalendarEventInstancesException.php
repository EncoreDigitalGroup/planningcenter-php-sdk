<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Exceptions;

use Exception;

class NoCalendarEventInstancesException extends Exception
{
    public function __construct()
    {
        parent::__construct('Calendar Event Has No Event Instances');
    }
}
