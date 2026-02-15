<?php

namespace EncoreDigitalGroup\PlanningCenter;

use EncoreDigitalGroup\PlanningCenter\Modules\CalendarModule;
use EncoreDigitalGroup\PlanningCenter\Modules\GroupsModule;
use EncoreDigitalGroup\PlanningCenter\Modules\PeopleModule;
use EncoreDigitalGroup\PlanningCenter\Modules\WebhooksModule;
use EncoreDigitalGroup\PlanningCenter\Support\AuthType;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use RuntimeException;

class PlanningCenter
{
    use HasClient;

    private static ?self $instance = null;
    private static bool $credentialsSet = false;

    public static function make(): self
    {
        if (!isset(self::$instance)) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /** Reset the singleton instance */
    public static function reset(): void
    {
        self::$instance = null;
        self::$credentialsSet = false;
    }

    /** Set credentials using Basic Auth and reset singleton */
    public function withBasicAuth(string $clientId, string $clientSecret): self
    {
        static::reset();
        self::$instance = new self;
        self::$instance->clientId = $clientId;
        self::$instance->clientSecret = $clientSecret;
        self::$instance->setAuthType(AuthType::Basic);

        self::$credentialsSet = true;

        return self::$instance;
    }

    /** Set credentials using OAuth token and reset singleton */
    public function withToken(string $token): self
    {
        static::reset();
        self::$instance = new self;
        self::$instance->clientId = $token;
        self::$instance->clientSecret = "";
        self::$instance->setAuthType(AuthType::Token);

        self::$credentialsSet = true;

        return self::$instance;
    }

    /** Get the People module */
    public function people(): PeopleModule
    {
        $this->ensureCredentialsSet();

        $module = new PeopleModule($this->clientId, $this->clientSecret);
        $module->setAuthType($this->authType);

        return $module;
    }

    /** Get the Groups module */
    public function groups(): GroupsModule
    {
        $this->ensureCredentialsSet();

        $module = new GroupsModule($this->clientId, $this->clientSecret);
        $module->setAuthType($this->authType);

        return $module;
    }

    /** Get the Calendar module */
    public function calendar(): CalendarModule
    {
        $this->ensureCredentialsSet();

        $module = new CalendarModule($this->clientId, $this->clientSecret);
        $module->setAuthType($this->authType);

        return $module;
    }

    /** Get the Webhooks module */
    public function webhooks(): WebhooksModule
    {
        $this->ensureCredentialsSet();

        $module = new WebhooksModule($this->clientId, $this->clientSecret);
        $module->setAuthType($this->authType);

        return $module;
    }

    /** Ensure credentials have been set before accessing modules */
    private function ensureCredentialsSet(): void
    {
        if (!self::$credentialsSet) {
            throw new RuntimeException(
                "Credentials not set. Use withBasicAuth() or withToken() before accessing modules."
            );
        }
    }
}