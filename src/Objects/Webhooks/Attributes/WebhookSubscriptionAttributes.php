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
    public ?bool $active = null;
    public ?string $applicationId = null;
    public ?string $authenticitySecret = null;
    public ?Carbon $createdAt = null;
    public ?string $name = null;
    public ?Carbon $updatedAt = null;
    public ?string $url = null;

    /**
     * Array of event type names to subscribe to (e.g., "people.v2.events.person.created").
     * This is sent to the API as "event_types" when creating/updating a subscription.
     * Use the helper methods on WebhookSubscription to manage this array.
     *
     * @var array<string>
     */
    public array $eventTypes = [];
}
