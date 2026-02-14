<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use Carbon\CarbonImmutable;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasApiMethods;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class WebhookSubscription
{
    use HasApiMethods, HasAttributes, HasClient;

    public const string ENDPOINT = "/webhooks/v2/webhook_subscriptions";

    protected string $endpoint = "/webhooks/v2/webhook_subscriptions";
    protected array $dateAttributes = [
        "created_at",
        "updated_at",
    ];
    protected array $readOnlyAttributes = [
        "id",
        "application_id",
        "authenticity_secret",
        "created_at",
        "updated_at",
    ];

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->attributes = new Collection;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->setApiVersion(PlanningCenterApiVersion::WEBHOOKS_DEFAULT);
    }

    /** Static factory method for backward compatibility with tests */
    public static function make(string $clientId, string $clientSecret): self
    {
        return new self($clientId, $clientSecret);
    }

    // Setters
    public function withId(string $value): self
    {
        return $this->setAttribute("id", $value);
    }

    public function withActive(?bool $value): self
    {
        return $this->setAttribute("active", $value);
    }

    public function withName(?string $value): self
    {
        return $this->setAttribute("name", $value);
    }

    public function withUrl(?string $value): self
    {
        return $this->setAttribute("url", $value);
    }

    // Getters
    public function id(): ?string
    {
        return $this->getAttribute("id");
    }

    public function active(): ?bool
    {
        return $this->getAttribute("active");
    }

    public function applicationId(): ?string
    {
        return $this->getAttribute("application_id");
    }

    public function authenticitySecret(): ?string
    {
        return $this->getAttribute("authenticity_secret");
    }

    public function createdAt(): ?CarbonImmutable
    {
        return $this->getAttribute("created_at");
    }

    public function name(): ?string
    {
        return $this->getAttribute("name");
    }

    public function updatedAt(): ?CarbonImmutable
    {
        return $this->getAttribute("updated_at");
    }

    public function url(): ?string
    {
        return $this->getAttribute("url");
    }

    /** Rotate the authenticity secret for this webhook subscription */
    public function rotateSecret(): bool
    {
        if (!$this->getAttribute("id")) {
            throw new InvalidArgumentException("Cannot rotate secret without an ID. Use withId() first or save the webhook subscription.");
        }

        $response = $this->client()->post(
            $this->hostname() . $this->endpoint . "/" . $this->getAttribute("id") . "/rotate_secret",
            []
        );

        // Refresh the webhook subscription to get the new secret
        if ($response->successful()) {
            $this->get();
        }

        return $response->successful();
    }

    /**
     * Override update method to handle webhook-specific update logic
     * On update, only 'active' can be changed (name and url are read-only after creation)
     */
    protected function update(): self
    {
        $response = $this->client()->patch(
            $this->hostname() . $this->endpoint . "/" . $this->getAttribute("id"),
            [
                "data" => [
                    "attributes" => array_filter([
                        "active" => $this->getAttribute("active"),
                    ], fn ($v): bool => $v !== null),
                ],
            ]
        );

        $this->hydrateFromResponse($response);

        return $this;
    }
}
