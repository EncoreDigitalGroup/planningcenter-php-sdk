<?php

namespace EncoreDigitalGroup\PlanningCenter\Modules;

use EncoreDigitalGroup\PlanningCenter\Resources\Email;
use EncoreDigitalGroup\PlanningCenter\Resources\Person;
use EncoreDigitalGroup\PlanningCenter\Resources\PersonMerger;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;

class PeopleModule extends Module
{
    public function __construct(string $clientId, string $clientSecret)
    {
        parent::__construct($clientId, $clientSecret);
        $this->setApiVersion(PlanningCenterApiVersion::PEOPLE_DEFAULT);
    }

    /** Create a new Person resource */
    public function person(): Person
    {
        $resource = new Person($this->clientId, $this->clientSecret);
        $resource->setAuthType($this->authType);

        return $resource;
    }

    /** Create a new Email resource */
    public function email(): Email
    {
        $resource = new Email($this->clientId, $this->clientSecret);
        $resource->setAuthType($this->authType);

        return $resource;
    }

    /** Create a new PersonMerger resource */
    public function personMerger(): PersonMerger
    {
        $resource = new PersonMerger($this->clientId, $this->clientSecret);
        $resource->setAuthType($this->authType);

        return $resource;
    }

    /** List all people with pagination */
    public function all(array $query = []): Paginator
    {
        return Person::all($this->clientId, $this->clientSecret, $query, $this->authType);
    }
}
