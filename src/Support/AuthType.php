<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2025. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Support;

use EncoreDigitalGroup\StdLib\Objects\Support\Traits\HasEnumValue;

/** @experimental This could change. Use with caution. */
enum AuthType: string
{
    use HasEnumValue;

    case Basic = "basic";
    case Token = "token";
}