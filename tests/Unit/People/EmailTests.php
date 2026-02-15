<?php

namespace Tests\Unit\People;

use EncoreDigitalGroup\PlanningCenter\PlanningCenter;
use EncoreDigitalGroup\PlanningCenter\Resources\Email;
use EncoreDigitalGroup\PlanningCenter\Support\Paginator;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe("People Email Tests", function (): void {
    test("Email: Can List All Emails for Person", function (): void {
        $emailsPaginator = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->people()
            ->person()
            ->withId(PeopleMocks::PERSON_ID)
            ->emails();

        expect($emailsPaginator)->toBeInstanceOf(Paginator::class)
            ->and($emailsPaginator->items())->toBeInstanceOf(Collection::class)
            ->and($emailsPaginator->items()->count())->toBe(1);
    });

    test("Email: Can Get Email By ID", function (): void {
        $email = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->people()
            ->email()
            ->withId(PeopleMocks::EMAIL_ID)
            ->get();

        expect($email)->toBeInstanceOf(Email::class)
            ->and($email->address())->toBe(PeopleMocks::EMAIL_ADDRESS)
            ->and($email->id())->toBe(PeopleMocks::EMAIL_ID);
    });

    test("Email: Can Create Email for Person", function (): void {
        $email = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->people()
            ->email()
            ->withAddress("new@example.com")
            ->withLocation("home")
            ->withPrimary(true)
            ->save();

        expect($email)->toBeInstanceOf(Email::class)
            ->and($email->id())->not()->toBeNull();
    });

    test("Email: Can Update Email", function (): void {
        $email = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->people()
            ->email()
            ->withId(PeopleMocks::EMAIL_ID)
            ->withAddress("updated@example.com")
            ->save();

        expect($email)->toBeInstanceOf(Email::class)
            ->and($email->id())->toBe(PeopleMocks::EMAIL_ID);
    });

    test("Email: Can Delete Email", function (): void {
        $email = PlanningCenter::make()
            ->withBasicAuth(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET)
            ->people()
            ->email()
            ->withId(PeopleMocks::EMAIL_ID);

        $result = $email->delete();

        expect($result)->toBeTrue();
    });
})->group("people.email");
