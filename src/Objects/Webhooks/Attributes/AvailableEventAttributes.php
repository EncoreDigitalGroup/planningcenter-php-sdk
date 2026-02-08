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
    public string $action = "";
    public string $app = "";
    public string $name = "";
    public string $resource = "";
    public string $type = "";
    public string $version = "";
}
