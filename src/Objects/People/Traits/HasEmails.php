<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People\Traits;

use EncoreDigitalGroup\PlanningCenter\Objects\People\Email;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;

trait HasEmails
{
    protected bool $withEmails = false;

    public function withEmails(bool $include = true): static
    {
        $this->withEmails = $include;

        return $this;
    }

    public function email(): ClientResponse
    {
        $email = new Email($this->client);
        $email->attributes->personId = $this->id;

        return $email->forPerson();
    }
}