<?php

namespace EncoreDigitalGroup\PlanningCenter\Modules;

use EncoreDigitalGroup\PlanningCenter\Resources\Group;
use EncoreDigitalGroup\PlanningCenter\Resources\GroupEnrollment;
use EncoreDigitalGroup\PlanningCenter\Resources\GroupEvent;
use EncoreDigitalGroup\PlanningCenter\Resources\GroupMemberPerson;
use EncoreDigitalGroup\PlanningCenter\Resources\GroupMembership;
use EncoreDigitalGroup\PlanningCenter\Resources\GroupTag;
use EncoreDigitalGroup\PlanningCenter\Resources\GroupTagGroup;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use EncoreDigitalGroup\PlanningCenter\Support\PlanningCenterApiVersion;

class GroupsModule extends Module
{
    public function __construct(string $clientId, string $clientSecret)
    {
        parent::__construct($clientId, $clientSecret);
        $this->setApiVersion(PlanningCenterApiVersion::GROUPS_DEFAULT);
    }

    /** Create a new Group resource */
    public function group(): Group
    {
        $resource = new Group($this->clientId, $this->clientSecret);
        $resource->setAuthType($this->authType);

        return $resource;
    }

    /** Create a new GroupEnrollment resource */
    public function groupEnrollment(): GroupEnrollment
    {
        $resource = new GroupEnrollment($this->clientId, $this->clientSecret);
        $resource->setAuthType($this->authType);

        return $resource;
    }

    /** Create a new GroupEvent resource */
    public function groupEvent(): GroupEvent
    {
        $resource = new GroupEvent($this->clientId, $this->clientSecret);
        $resource->setAuthType($this->authType);

        return $resource;
    }

    /** Create a new GroupMembership resource */
    public function groupMembership(): GroupMembership
    {
        $resource = new GroupMembership($this->clientId, $this->clientSecret);
        $resource->setAuthType($this->authType);

        return $resource;
    }

    /** Create a new GroupMemberPerson resource */
    public function groupMemberPerson(): GroupMemberPerson
    {
        $resource = new GroupMemberPerson($this->clientId, $this->clientSecret);
        $resource->setAuthType($this->authType);

        return $resource;
    }

    /** Create a new GroupTag resource */
    public function groupTag(): GroupTag
    {
        $resource = new GroupTag($this->clientId, $this->clientSecret);
        $resource->setAuthType($this->authType);

        return $resource;
    }

    /** Create a new GroupTagGroup resource */
    public function groupTagGroup(): GroupTagGroup
    {
        $resource = new GroupTagGroup($this->clientId, $this->clientSecret);
        $resource->setAuthType($this->authType);

        return $resource;
    }

    /** List all groups with pagination */
    public function all(array $query = []): Paginator
    {
        return Group::all($this->clientId, $this->clientSecret, $query, $this->authType);
    }
}
