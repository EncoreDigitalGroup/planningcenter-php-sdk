<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2025. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\Attributes;

use Carbon\Carbon;

/** @api */
class WebhookSubscriptionAttributes
{
    public string $webhookSubscriptionId = "";
    public bool $active = false;
    public string $applicationId = "";
    public string $authenticitySecret = "";
    public ?Carbon $createdAt = null;
    public string $name = "";
    public ?Carbon $updatedAt = null;
    public string $url = "";
}
