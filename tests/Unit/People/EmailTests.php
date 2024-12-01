<?php

namespace Tests\Unit\People;

use EncoreDigitalGroup\PlanningCenter\Objects\People\Email;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe("People Email Tests", function (): void {
    test("Email: Can Get Email By ID", function (): void {
        $email = Email::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $email
            ->forEmailAddressId("1")
            ->get();

        /** @var Email $emailAddress */
        $emailAddress = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($emailAddress->attributes->address)->toBe(PeopleMocks::EMAIL_ADDRESS)
            ->and($emailAddress->attributes->emailAddressId)->toBe(PeopleMocks::EMAIL_ID);
    });

    test("Email: Can List All Emails For Person", function (): void {
        $email = Email::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $email
            ->forPersonId("1")
            ->person();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1);
    });

    test("Email: Can Update Email", function (): void {
        $email = Email::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $email->attributes->address = "john.smith@example.com";

        $response = $email
            ->forEmailAddressId("1")
            ->update();

        /** @var Email $emailAddress */
        $emailAddress = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($emailAddress->attributes->address)->toBe(PeopleMocks::EMAIL_ADDRESS)
            ->and($emailAddress->attributes->emailAddressId)->toBe(PeopleMocks::EMAIL_ID);
    });
})->group("people.email");

