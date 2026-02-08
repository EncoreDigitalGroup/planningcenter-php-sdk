<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2025. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\Attributes;

use Carbon\Carbon;

/** @api */
class DeliveryAttributes
{
    public string $webhookSubscriptionId = "";
    public string $eventId = "";
    public string $deliveryId = "";
    public ?Carbon $createdAt = null;
    public ?Carbon $updatedAt = null;
    public string $objectUrl = "";
    public string $requestBody = "";
    public string $requestHeaders = "";
    public string $responseBody = "";
    public string $responseHeaders = "";
    public int $status = 0;
    public float $timing = 0.0;
}
