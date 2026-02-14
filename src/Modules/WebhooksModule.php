<?php

namespace EncoreDigitalGroup\PlanningCenter\Modules;

use EncoreDigitalGroup\PlanningCenter\Resources\WebhookSubscription;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;

class WebhooksModule extends Module
{
    public function __construct(string $clientId, string $clientSecret)
    {
        parent::__construct($clientId, $clientSecret);
        $this->setApiVersion(PlanningCenterApiVersion::WEBHOOKS_DEFAULT);
    }

    /** Create a new WebhookSubscription resource */
    public function webhookSubscription(): WebhookSubscription
    {
        return new WebhookSubscription($this->clientId, $this->clientSecret);
    }

    /** List all webhook subscriptions with pagination */
    public function all(array $query = []): Paginator
    {
        return WebhookSubscription::all($this->clientId, $this->clientSecret, $query);
    }
}
