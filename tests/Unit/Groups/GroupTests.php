<?php

namespace Tests\Unit\Groups;

use EncoreDigitalGroup\PlanningCenter\PlanningCenter;
use EncoreDigitalGroup\PlanningCenter\Resources\Group;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe("Groups Tests", function (): void {
    test("Groups: Can List All Groups (Read-Only)", function (): void {
        $paginator = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->groups()
            ->all();

        expect($paginator)->toBeInstanceOf(Paginator::class)
            ->and($paginator->items())->toBeInstanceOf(Collection::class)
            ->and($paginator->items()->count())->toBe(1);
    });

    test("Groups: Can Get Group By ID (Read-Only)", function (): void {
        $group = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->groups()
            ->group()
            ->withId(GroupMocks::GROUP_ID)
            ->get();

        expect($group)->toBeInstanceOf(Group::class)
            ->and($group->name())->toBe(GroupMocks::GROUP_NAME)
            ->and($group->id())->toBe(GroupMocks::GROUP_ID);
    });
})->group("groups.group");
