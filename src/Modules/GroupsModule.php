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
        return new Group($this->clientId, $this->clientSecret);
    }

    /** Create a new GroupEnrollment resource */
    public function groupEnrollment(): GroupEnrollment
    {
        return new GroupEnrollment($this->clientId, $this->clientSecret);
    }

    /** Create a new GroupEvent resource */
    public function groupEvent(): GroupEvent
    {
        return new GroupEvent($this->clientId, $this->clientSecret);
    }

    /** Create a new GroupMembership resource */
    public function groupMembership(): GroupMembership
    {
        return new GroupMembership($this->clientId, $this->clientSecret);
    }

    /** Create a new GroupMemberPerson resource */
    public function groupMemberPerson(): GroupMemberPerson
    {
        return new GroupMemberPerson($this->clientId, $this->clientSecret);
    }

    /** Create a new GroupTag resource */
    public function groupTag(): GroupTag
    {
        return new GroupTag($this->clientId, $this->clientSecret);
    }

    /** Create a new GroupTagGroup resource */
    public function groupTagGroup(): GroupTagGroup
    {
        return new GroupTagGroup($this->clientId, $this->clientSecret);
    }

    /** List all groups with pagination */
    public function all(array $query = []): Paginator
    {
        return Group::all($this->clientId, $this->clientSecret, $query);
    }
}
