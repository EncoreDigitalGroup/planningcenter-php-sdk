<?php

namespace Tests\Unit\People;

use EncoreDigitalGroup\PlanningCenter\Objects\People\Person;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

describe('People Profile Tests', function () {
    test('People: Can Create Person', function () {
        $person = Person::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $person->attributes->firstName = "John";
        $person->attributes->lastName = "Smith";

        $response = $person->create();
        /** @var Person $personProfile */
        $personProfile = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($personProfile->attributes->firstName)->toBe(PeopleMocks::FIRST_NAME)
            ->and($personProfile->attributes->lastName)->toBe(PeopleMocks::LAST_NAME);
    });

    test('People: Can List All', function () {
        $person = Person::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $person->all();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($response->data)->toBeInstanceOf(Collection::class)
            ->and($response->data->count())->toBe(1);
    });

    test('People: Can Get Person By ID', function () {
        $person = Person::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);

        $response = $person->forPersonId("1")->get();
        /** @var Person $personProfile */
        $personProfile = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($personProfile->attributes->firstName)->toBe(PeopleMocks::FIRST_NAME)
            ->and($personProfile->attributes->lastName)->toBe(PeopleMocks::LAST_NAME)
            ->and($personProfile->attributes->personId)->toBe(PeopleMocks::PERSON_ID);
    });

    test('People: Can Update Person Profile', function () {
        $person = Person::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $person->attributes->personId = "1";

        $response = $person->update();
        /** @var Person $personProfile */
        $personProfile = $response->data->first();

        expect($response)->toBeInstanceOf(ClientResponse::class)
            ->and($personProfile->attributes->firstName)->toBe(PeopleMocks::FIRST_NAME)
            ->and($personProfile->attributes->lastName)->toBe(PeopleMocks::LAST_NAME)
            ->and($personProfile->attributes->personId)->toBe(PeopleMocks::PERSON_ID);
    });

    test('People: Can Delete Person Profile', function () {
        $person = Person::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
        $person->attributes->personId = "1";

        $response = $person->delete();

        expect($response->data->isEmpty())->toBeTrue();
    });
})->group('people.profile');

