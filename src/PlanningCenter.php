<?php

namespace EncoreDigitalGroup\PlanningCenter;

use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;

class PlanningCenter
{
    use HasClient;

    private static self $instance;

    public static function make(): static
    {
        if (!isset(static::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }
}