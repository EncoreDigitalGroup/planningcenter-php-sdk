<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Support;

enum PlanningCenterWebhookEvent: string
{
    case PeoplePersonCreated = "people.v2.events.person.created";
    case PeoplePersonUpdated = "people.v2.events.person.updated";
    case PeoplePersonMergerCreated = "people.v2.events.person_merger.created";
    case GroupsGroupCreated = "groups.v2.events.group.created";
    case GroupsGroupUpdated = "groups.v2.events.group.updated";
    case GroupsGroupDestroyed = "groups.v2.events.group.destroyed";
    case GroupsMembershipCreated = "groups.v2.events.membership.created";
    case GroupsMembershipUpdated = "groups.v2.events.membership.updated";
    case GroupsMembershipDestroyed = "groups.v2.events.membership.destroyed";
}
