<?php

namespace EncoreDigitalGroup\PlanningCenter\Helpers;

class PlanningCenterHelper
{
    public static function wasRateLimited($response): bool
    {
        if ($response->sdk->outcome->rate_limited) {
            return true;
        }

        return false;
    }

    public static function wasNoteRateLimited($response): bool
    {
        if (!$response->sdk->outcome->rate_limited) {
            return false;
        }

        return true;
    }
}