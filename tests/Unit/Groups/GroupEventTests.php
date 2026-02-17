<?php

namespace Tests\Unit\Groups;

use EncoreDigitalGroup\PlanningCenter\PlanningCenter;
use EncoreDigitalGroup\PlanningCenter\Resources\GroupEvent;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe("Groups Event Tests", function (): void {
    test("GroupEvent: Can List All Group Events (Read-Only)", function (): void {
        $paginator = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->groups()
            ->groupEvent()
            ->all(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        expect($paginator)->toBeInstanceOf(Paginator::class)
            ->and($paginator->items())->toBeInstanceOf(Collection::class)
            ->and($paginator->items()->count())->toBe(1);
    });

    test("GroupEvent: Can Get Group Event By ID (Read-Only)", function (): void {
        $event = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->groups()
            ->groupEvent()
            ->withId(GroupMocks::GROUP_EVENT_ID)
            ->get();

        expect($event)->toBeInstanceOf(GroupEvent::class)
            ->and($event->id())->toBe(GroupMocks::GROUP_EVENT_ID)
            ->and($event->name())->toBe(GroupMocks::GROUP_EVENT_NAME);
    });

    test("GroupEvent: groupId() Returns Related Group ID From Relationships", function (): void {
        $event = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->groups()
            ->groupEvent()
            ->withId(GroupMocks::GROUP_EVENT_ID)
            ->get();

        expect($event->groupId())->toBe(GroupMocks::GROUP_ID);
    });

    test("GroupEvent: Relationship Keys Are Normalized To Lowercase", function (): void {
        GroupMocks::useGroupEventWithMixedCaseRelationship();

        $event = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->groups()
            ->groupEvent()
            ->withId("99")
            ->get();

        // "Group" (capital G) in the API response should normalize to "group_id"
        expect($event->groupId())->toBe(GroupMocks::GROUP_ID);
    });
})->group("groups.event");