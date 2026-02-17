<?php

namespace Tests\Unit\Groups;

use EncoreDigitalGroup\PlanningCenter\PlanningCenter;
use EncoreDigitalGroup\PlanningCenter\Resources\GroupTag;
use EncoreDigitalGroup\PlanningCenter\Resources\GroupTagGroup;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe("Groups TagGroup Tests", function (): void {
    test("TagGroup: Can List All Tag Groups (Read-Only)", function (): void {
        $paginator = GroupTagGroup::all(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        expect($paginator)->toBeInstanceOf(Paginator::class)
            ->and($paginator->items())->toBeInstanceOf(Collection::class);
    });

    test("TagGroup: Can Get Tag Group By ID (Read-Only)", function (): void {
        $tagGroup = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->groups()
            ->groupTagGroup()
            ->withId(GroupMocks::TAG_GROUP_ID)
            ->get();

        expect($tagGroup)->toBeInstanceOf(GroupTagGroup::class)
            ->and($tagGroup->id())->toBe(GroupMocks::TAG_GROUP_ID);
    });

    test("TagGroup: Can Get Tags For Tag Group", function (): void {
        $tagGroup = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->groups()
            ->groupTagGroup()
            ->withId(GroupMocks::TAG_GROUP_ID)
            ->get();

        $tags = $tagGroup->tags();

        expect($tags)->toBeInstanceOf(Paginator::class)
            ->and($tags->items())->toBeInstanceOf(Collection::class)
            ->and($tags->items()->first())->toBeInstanceOf(GroupTag::class)
            ->and($tags->items()->first()->id())->toBe(GroupMocks::TAG_ID)
            ->and($tags->items()->first()->name())->toBe(GroupMocks::TAG_NAME)
            ->and($tags->response())->not->toBeNull();
    });
})->group("groups.taggroup");
