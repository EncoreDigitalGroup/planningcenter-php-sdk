<?php

namespace EncoreDigitalGroup\PlanningCenter;

use EncoreDigitalGroup\PlanningCenter\Modules\CalendarModule;
use EncoreDigitalGroup\PlanningCenter\Modules\GroupsModule;
use EncoreDigitalGroup\PlanningCenter\Modules\PeopleModule;
use EncoreDigitalGroup\PlanningCenter\Modules\WebhooksModule;
use EncoreDigitalGroup\PlanningCenter\Support\AuthType;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;

class PlanningCenter
{
    use HasClient;

    private static ?self $instance = null;
    private static bool $credentialsSet = false;

    public static function make(): static
    {
        if (!isset(static::$instance)) {
            static::$instance = new self;
        }

        return static::$instance;
    }

    /**
     * Set credentials using Basic Auth and reset singleton
     */
    public function withBasicAuth(string $clientId, string $clientSecret): static
    {
        static::reset();
        static::$instance = new self;
        static::$instance->clientId = $clientId;
        static::$instance->clientSecret = $clientSecret;
        static::$instance->setAuthType(AuthType::Basic);
        static::$credentialsSet = true;

        return static::$instance;
    }

    /**
     * Set credentials using OAuth token and reset singleton
     */
    public function withToken(string $token): static
    {
        static::reset();
        static::$instance = new self;
        static::$instance->clientId = $token;
        static::$instance->clientSecret = '';
        static::$instance->setAuthType(AuthType::Token);
        static::$credentialsSet = true;

        return static::$instance;
    }

    /**
     * Reset the singleton instance
     */
    public static function reset(): void
    {
        static::$instance = null;
        static::$credentialsSet = false;
    }

    /**
     * Get the People module
     */
    public function people(): PeopleModule
    {
        $this->ensureCredentialsSet();
        return new PeopleModule($this->clientId, $this->clientSecret);
    }

    /**
     * Get the Groups module
     */
    public function groups(): GroupsModule
    {
        $this->ensureCredentialsSet();
        return new GroupsModule($this->clientId, $this->clientSecret);
    }

    /**
     * Get the Calendar module
     */
    public function calendar(): CalendarModule
    {
        $this->ensureCredentialsSet();
        return new CalendarModule($this->clientId, $this->clientSecret);
    }

    /**
     * Get the Webhooks module
     */
    public function webhooks(): WebhooksModule
    {
        $this->ensureCredentialsSet();
        return new WebhooksModule($this->clientId, $this->clientSecret);
    }

    /**
     * Ensure credentials have been set before accessing modules
     */
    private function ensureCredentialsSet(): void
    {
        if (!static::$credentialsSet) {
            throw new \RuntimeException(
                'Credentials not set. Use withBasicAuth() before accessing modules.'
            );
        }
    }
}