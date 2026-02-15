<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use Carbon\CarbonImmutable;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasApiMethods;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasAttributes;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use Illuminate\Support\Collection;

/** @phpstan-consistent-constructor */
class Email
{
    use HasApiMethods, HasAttributes, HasClient;

    public const string ENDPOINT = "/people/v2/emails";

    protected string $endpoint = self::ENDPOINT;
    protected array $readOnlyAttributes = [
        "id",
        "created_at",
        "updated_at",
        "blocked",
    ];

    public function __construct(string $clientId, string $clientSecret)
    {
        $this->attributes = new Collection;
        $this->clientId = $clientId;
        $this->clientSecret = $clientSecret;
        $this->setApiVersion(PlanningCenterApiVersion::PEOPLE_DEFAULT);
    }

    protected function dateAttributes(): array
    {
        return [
            'created_at',
            'updated_at',
        ];
    }

    /** Static factory method for backward compatibility with tests */
    public static function make(string $clientId, string $clientSecret): self
    {
        return new self($clientId, $clientSecret);
    }

    /** Get all emails for a specific person */
    public static function forPerson(
        string $clientId,
        string $clientSecret,
        string $personId
    ): Paginator
    {
        $instance = new static($clientId, $clientSecret);

        $response = $instance->client()->get(
            $instance->hostname() . "/people/v2/people/{$personId}/emails"
        );

        return static::buildPaginatorFromResponse($response, $clientId, $clientSecret);
    }

    // Setters
    public function withId(string $value): self
    {
        return $this->setAttribute("id", $value);
    }

    public function withAddress(?string $value): self
    {
        return $this->setAttribute("address", $value);
    }

    public function withLocation(?string $value): self
    {
        return $this->setAttribute("location", $value);
    }

    public function withPrimary(?bool $value): self
    {
        return $this->setAttribute("primary", $value);
    }

    // Getters
    public function id(): ?string
    {
        return $this->getAttribute("id");
    }

    public function address(): ?string
    {
        return $this->getAttribute("address");
    }

    public function location(): ?string
    {
        return $this->getAttribute("location");
    }

    public function primary(): ?bool
    {
        return $this->getAttribute("primary");
    }

    public function blocked(): mixed
    {
        return $this->getAttribute("blocked");
    }

    public function createdAt(): ?CarbonImmutable
    {
        return $this->getAttribute("created_at");
    }

    public function updatedAt(): ?CarbonImmutable
    {
        return $this->getAttribute("updated_at");
    }
}
