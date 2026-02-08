<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2025. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\Attributes;

use Carbon\Carbon;

/** @api */
class EventAttributes
{
    public string $webhookSubscriptionId = "";
    public string $eventId = "";
    public ?Carbon $createdAt = null;
    public ?Carbon $updatedAt = null;
    public ?string $uuid = null;
    public ?string $payload = null;
    public ?string $status = null;
}
