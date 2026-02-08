<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2025. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\Attributes;

/** @api */
class AvailableEventAttributes
{
    public string $availableEventId = "";
    public ?string $action = null;
    public ?string $app = null;
    public ?string $name = null;
    public ?string $resource = null;
    public ?string $type = null;
    public ?string $version = null;
}
