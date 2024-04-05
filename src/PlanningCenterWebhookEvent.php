<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter;

enum PlanningCenterWebhookEvent: string
{
    case PEOPLE_PERSON_UPDATED = 'people.v2.events.person.updates';
    case GROUPS_GROUP_CREATED = 'groups.v2.events.group.created';
    case GROUPS_GROUP_UPDATED = 'groups.v2.events.group.updated';
    case GROUPS_GROUP_DESTROYED = 'groups.v2.events.group.destroyed';
    case GROUPS_MEMBERSHIP_CREATED = 'groups.v2.events.membership.created';
    case GROUPS_MEMBERSHIP_UPDATED = 'groups.v2.events.membership.updated';
    case GROUPS_MEMBERSHIP_DESTROYED = 'groups.v2.events.membership.destroyed';

    public function toString(): string
    {
        return (string) $this->value;
    }
}
