<?php

namespace Tests\Unit\People;

use EncoreDigitalGroup\PlanningCenter\Objects\People\Email;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe("People Email Tests", function (): void {
    test("Email: Can Get Email By ID", function (): void {
        $email = Email::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $email->attributes->emailAddressId = "1";

        $response = $email->get();
        /** @var Email $emailAddress */
        $emailAddress = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($emailAddress->attributes->address)->toBe(PeopleMocks::EMAIL_ADDRESS)
            ->and($emailAddress->attributes->emailAddressId)->toBe(PeopleMocks::EMAIL_ID);
    });

    test("Email: Can List All Emails For Person", function (): void {
        $email = Email::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $email->attributes->personId = "1";

        $response = $email->forPerson();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1);
    });

    test("Email: Can Update Email", function (): void {
        $email = Email::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $email->attributes->emailAddressId = "1";
        $email->attributes->address = "john.smith@example.com";

        $response = $email->update();
        /** @var Email $emailAddress */
        $emailAddress = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($emailAddress->attributes->address)->toBe(PeopleMocks::EMAIL_ADDRESS)
            ->and($emailAddress->attributes->emailAddressId)->toBe(PeopleMocks::EMAIL_ID);
    });
})->group("people.email");

