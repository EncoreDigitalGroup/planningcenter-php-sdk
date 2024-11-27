<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace Tests\Helpers;

enum ObjectType: string
{
    case Profile = "profile";
    case Email = "email";
    case Event = "event";
    case EventInstance = "eventInstance";
    case TagGroup = "tagGroup";
    case Tag = "tag";
    case Group = "group";
    case GroupMembership = "membership";
    case GroupMembers = "people";
}
