<?php

namespace Tests\Unit\Groups;

use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\GroupAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\GroupMemberPersonAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Group;
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\GroupMembership;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use Illuminate\Support\Collection;
use Tests\Helpers\TaskAssignee;
use Tests\Helpers\TestConstants;
use Tests\Unit\People\PeopleMocks;

describe('Group Tests', function () {
    test('Group: Can List All Groups', function () {
        $group = Group::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $group->all();

        /** @var GroupAttributes $groupAttributes */
        $groupAttributes = $response->data->first()->attributes;

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1)
            ->and($groupAttributes->groupId)->toBe(GroupMocks::GROUP_ID);
    });

    test('Group: Can Get Group By ID', function () {
        $group = Group::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $group->attributes->groupId = "1";

        $response = $group->get();
        /** @var GroupAttributes $groupAttributes */
        $groupAttributes = $response->data->first()->attributes;

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($groupAttributes->name)->toBe(GroupMocks::GROUP_NAME)
            ->and($groupAttributes->groupId)->toBe(GroupMocks::GROUP_ID);
    });

    test('Group: Can List My Groups', function () {
        $group = Group::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $group->mine();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1);
    });

    test('Group: Can List Group Memberships', function () {
        $group = Group::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $group->attributes->groupId = "1";

        $response = $group->membership();

        /** @var GroupMembership $membership */
        $membership = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1)
            ->and($membership->attributes->role)->toBe(GroupMocks::MEMBERSHIP_ROLE)
            ->and($membership->relationships->group->data->id)->toBe(GroupMocks::GROUP_ID)
            ->and($membership->relationships->person->data->id)->toBe(PeopleMocks::PERSON_ID);
    });

    test('Group: Can List Group People', function () {
        $group = Group::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $group->attributes->groupId = "1";

        $response = $group->people();

        /** @var GroupMemberPersonAttributes $groupMember */
        $groupMember = $response->data->first()->attributes;

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1)
            ->and($groupMember->personId)->toBe(GroupMocks::MEMBER_PROFILE_ID)
            ->and($groupMember->firstName)->toBe(GroupMocks::MEMBER_FIRST_NAME)
            ->and($groupMember->lastName)->toBe(GroupMocks::MEMBER_LAST_NAME);
    });

    test("Group: Can List Tags Assigned to Group", function () {
        // Test Content Goes Here.
    })->todo("Write test that lists the tags assigned to a group", enum(TaskAssignee::MarcBeinder));

    test("Group: Can Get Group Enrollment Details", function () {
        // Test Content Goes Here.
    })->todo("Write test gets group enrollment details", enum(TaskAssignee::MarcBeinder));
})->group('groups.group');