<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace Tests\Unit\Groups;

use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Group;
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\TagGroup;
use EncoreDigitalGroup\PlanningCenter\Support\Traits\HasClient;
use PHPGenesis\Http\HttpClient;
use Tests\Helpers\BaseMock;
use Tests\Helpers\ObjectType;
use Tests\Unit\People\PeopleMocks;

class GroupMocks extends BaseMock
{
    use HasClient;

    public const string GROUP_ID = "1";
    public const string GROUP_NAME = "Demo Group";
    public const string MEMBERSHIP_ID = "1";
    public const string MEMBERSHIP_ROLE = "leader";
    public const string MEMBER_PROFILE_ID = "1";
    public const string MEMBER_FIRST_NAME = "John";
    public const string MEMBER_LAST_NAME = "Smith";
    public const string TAG_ID = "1";
    public const string TAG_NAME = "Demo Tag";
    public const int TAG_POSITION = 1;
    public const string TAG_GROUP_ID = "1";
    public const string TAG_GROUP_NAME = "Demo Tag Group";
    public const int ENROLLMENT_MEMBER_LIMIT = 1;
    public const bool ENROLLMENT_MEMBER_LIMIT_REACHED = true;

    public static function setup(): void
    {
        self::useGroupCollection();
        self::useSpecificGroup();
        self::useMembershipCollection();
        self::useGroupMemberPersonCollection();
        self::useGroupTagRelationshipCollection();
        self::useEnrollmentCollection();
        self::useTagGroupCollection();
    }

    protected static function useGroupCollection(): void
    {
        HttpClient::fake([
            self::HOSTNAME . Group::GROUPS_ENDPOINT => function ($request) {
                return match ($request->method()) {
                    "GET" => HttpClient::response(self::useCollectionResponse(ObjectType::Group)),
                    default => HttpClient::response([], 405),
                };
            },
        ]);

        HttpClient::fake([
            self::HOSTNAME . Group::GROUPS_ENDPOINT . "?filter=my_groups" => function ($request) {
                return match ($request->method()) {
                    "GET" => HttpClient::response(self::useCollectionResponse(ObjectType::Group)),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    protected static function useSpecificGroup(): void
    {
        HttpClient::fake([
            self::HOSTNAME . Group::GROUPS_ENDPOINT . "/1" => function ($request) {
                return match ($request->method()) {
                    "GET" => HttpClient::response(self::useSingleResponse(ObjectType::Group)),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    protected static function useMembershipCollection(): void
    {
        HttpClient::fake([
            self::HOSTNAME . Group::GROUPS_ENDPOINT . "/1/memberships" => function ($request) {
                return match ($request->method()) {
                    "GET" => HttpClient::response(self::useCollectionResponse(ObjectType::GroupMembership)),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    protected static function useGroupMemberPersonCollection(): void
    {
        HttpClient::fake([
            self::HOSTNAME . Group::GROUPS_ENDPOINT . "/1/people" => function ($request) {
                return match ($request->method()) {
                    "GET" => HttpClient::response(self::useCollectionResponse(ObjectType::GroupMembers)),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    protected static function useGroupTagRelationshipCollection(): void
    {
        HttpClient::fake([
            self::HOSTNAME . Group::GROUPS_ENDPOINT . "/1/tags" => function ($request) {
                return match ($request->method()) {
                    "GET" => HttpClient::response(self::useCollectionResponse(ObjectType::Tag)),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    protected static function useEnrollmentCollection(): void
    {
        HttpClient::fake([
            self::HOSTNAME . Group::GROUPS_ENDPOINT . "/1/enrollment" => function ($request) {
                return match ($request->method()) {
                    "GET" => HttpClient::response(self::useCollectionResponse(ObjectType::Enrollment)),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    protected static function useTagGroupCollection(): void
    {
        HttpClient::fake([
            self::HOSTNAME . TagGroup::TAG_GROUP_ENDPOINT => function ($request) {
                return match ($request->method()) {
                    "GET" => HttpClient::response(self::useCollectionResponse(ObjectType::TagGroup)),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    protected static function group(): array
    {
        return [
            "type" => "Group",
            "id" => self::GROUP_ID,
            "attributes" => [
                "archived_at" => "2000-01-01T12:00:00Z",
                "can_create_conversation" => true,
                "contact_email" => "string",
                "created_at" => "2000-01-01T12:00:00Z",
                "description" => "string",
                "events_visibility" => "value",
                "header_image" => [],
                "leaders_can_search_people_database" => true,
                "location_type_preference" => "value",
                "memberships_count" => 1,
                "name" => self::GROUP_NAME,
                "public_church_center_web_url" => "string",
                "schedule" => "string",
                "virtual_location_url" => "string",
                "widget_status" => [],
            ],
            "relationships" => [
                "group_type" => [
                    "data" => [
                        "type" => "GroupType",
                        "id" => "1",
                    ],
                ],
                "location" => [
                    "data" => [
                        "type" => "Location",
                        "id" => "1",
                    ],
                ],
            ],
        ];
    }

    protected static function membership(): array
    {
        return [
            "type" => "Membership",
            "id" => self::MEMBERSHIP_ID,
            "attributes" => [
                "joined_at" => "2000-01-01T12:00:00Z",
                "role" => self::MEMBERSHIP_ROLE,
            ],
            "relationships" => [
                "group" => [
                    "data" => [
                        "type" => "Group",
                        "id" => self::GROUP_ID,
                    ],
                ],
                "person" => [
                    "data" => [
                        "type" => "Person",
                        "id" => PeopleMocks::PERSON_ID,
                    ],
                ],
            ],
        ];
    }

    protected static function people(): array
    {
        return [
            "type" => "Person",
            "id" => self::MEMBER_PROFILE_ID,
            "attributes" => [
                "addresses" => [],
                "avatar_url" => "string",
                "child" => true,
                "created_at" => "2000-01-01T12:00:00Z",
                "email_addresses" => [],
                "first_name" => self::MEMBER_FIRST_NAME,
                "last_name" => self::MEMBER_LAST_NAME,
                "permissions" => "string",
                "phone_numbers" => [],
            ],
            "relationships" => [],
        ];
    }

    protected static function tag(): array
    {
        return [
            "type" => "Tag",
            "id" => self::TAG_ID,
            "attributes" => [
                "name" => self::TAG_NAME,
                "position" => self::TAG_POSITION,
            ],
            "relationships" => [
                "tag_group" => [
                    "data" => [
                        "type" => "TagGroup",
                        "id" => "1",
                    ],
                ],
            ],
        ];
    }

    protected static function enrollment(): array
    {
        return [
            "type" => "Enrollment",
            "id" => "1",
            "attributes" => [
                "auto_closed" => true,
                "auto_closed_reason" => "string",
                "date_limit" => "string",
                "date_limit_reached" => true,
                "member_limit" => self::ENROLLMENT_MEMBER_LIMIT,
                "member_limit_reached" => self::ENROLLMENT_MEMBER_LIMIT_REACHED,
                "status" => "string",
                "strategy" => "string",
            ],
            "relationships" => [
                "group" => [
                    "data" => [
                        "type" => "Group",
                        "id" => "1",
                    ],
                ],
            ],
        ];
    }

    protected static function tagGroup(): array
    {
        return [
            "type" => "TagGroup",
            "id" => self::TAG_GROUP_ID,
            "attributes" => [
                "display_publicly" => true,
                "multiple_options_enabled" => true,
                "name" => self::TAG_GROUP_NAME,
                "position" => 1,
            ],
            "relationships" => [],
        ];
    }
}