<?php

namespace EncoreDigitalGroup\PlanningCenter\Resources;

use EncoreDigitalGroup\PlanningCenter\Modules\Module;

class People extends Module
{
    public function person(): Person
    {
        return new Person($this->clientId, $this->clientSecret);
    }
}