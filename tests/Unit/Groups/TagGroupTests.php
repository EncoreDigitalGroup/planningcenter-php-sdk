<?php

namespace Tests\Unit\Groups;

use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\GroupAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\GroupEnrollmentAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\GroupMemberPersonAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Attributes\TagGroupAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Group;
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\GroupMembership;
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Tag;
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\TagGroup;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use Illuminate\Support\Collection;
use Tests\Helpers\TaskAssignee;
use Tests\Helpers\TestConstants;
use Tests\Unit\People\PeopleMocks;

describe("Group TagGroup Tests", function (): void {
    test("Group TagGroup: Can List All TagGroups", function (): void {
        $tagGroup = TagGroup::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $tagGroup->all();

        /** @var TagGroupAttributes $tagGroupAttributes */
        $tagGroupAttributes = $response->data->first()->attributes;

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1)
            ->and($tagGroupAttributes->tagGroupId)->toBe(GroupMocks::TAG_GROUP_ID)
            ->and($tagGroupAttributes->name)->toBe(GroupMocks::TAG_GROUP_NAME);
    });
})->group("groups.tagGroup");