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
    public ?string $objectUrl = null;
    public ?string $requestBody = null;
    public ?string $requestHeaders = null;
    public ?string $responseBody = null;
    public ?string $responseHeaders = null;
    public ?int $status = null;
    public ?float $timing = null;
}
