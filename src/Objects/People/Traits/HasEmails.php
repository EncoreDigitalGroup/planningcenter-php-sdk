<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People\Traits;

use EncoreDigitalGroup\PlanningCenter\Objects\People\Email;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;

trait HasEmails
{
    use HasPlanningCenterClient;

    protected bool $withEmails = false;

    public function withEmails(bool $include = true): static
    {
        $this->withEmails = $include;

        return $this;
    }

    public function email(): ClientResponse
    {
        $email = Email::make($this->clientId, $this->clientSecret);
        $email->attributes->personId = $this->attributes->personId;

        return $email->forPerson();
    }
}