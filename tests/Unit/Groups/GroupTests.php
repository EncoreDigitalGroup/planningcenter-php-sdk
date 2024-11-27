<?php

namespace Tests\Unit\Groups;

use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\GroupAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\GroupMembershipAttributes;
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

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1);
    })->todo("Create Group Person Relationship Object", enum(TaskAssignee::MarcBeinder));
})->group('groups.group');