<?php

namespace Tests\Unit\Groups;

use EncoreDigitalGroup\PlanningCenter\PlanningCenter;
use EncoreDigitalGroup\PlanningCenter\Resources\GroupEnrollment;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe("Groups Enrollment Tests", function (): void {
    test("GroupEnrollment: Can List All Group Enrollments (Read-Only)", function (): void {
        $paginator = GroupEnrollment::all(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        expect($paginator)->toBeInstanceOf(Paginator::class)
            ->and($paginator->items())->toBeInstanceOf(Collection::class)
            ->and($paginator->items()->count())->toBe(1);
    });

    test("GroupEnrollment: Can Get Group Enrollment By ID (Read-Only)", function (): void {
        $enrollment = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->groups()
            ->groupEnrollment()
            ->withId(GroupMocks::GROUP_ENROLLMENT_ID)
            ->get();

        expect($enrollment)->toBeInstanceOf(GroupEnrollment::class)
            ->and($enrollment->id())->toBe(GroupMocks::GROUP_ENROLLMENT_ID);
    });

    test("GroupEnrollment: groupId() Returns Related Group ID From Relationships", function (): void {
        $enrollment = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->groups()
            ->groupEnrollment()
            ->withId(GroupMocks::GROUP_ENROLLMENT_ID)
            ->get();

        expect($enrollment->groupId())->toBe(GroupMocks::GROUP_ID);
    });
})->group("groups.enrollment");