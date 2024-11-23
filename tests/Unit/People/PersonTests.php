<?php

namespace Tests\Unit\People;

use EncoreDigitalGroup\PlanningCenter\Objects\People\Person;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use Illuminate\Support\Collection;
use Tests\Helpers\TestConstants;

test('People: Can Create Person', function () {
    PeopleMocks::useCreatePerson();
    $person = Person::make(TestConstants::CLIENT_ID, TestConstants::CLIENT_SECRET);
    $person->attributes->firstName = "John";
    $person->attributes->lastName = "Smith";

    $response = $person->create();

    expect($response)->toBeInstanceOf(ClientResponse::class);
})->only();

test('People: Can List All', function () {
    $response = $this->person->all();

    expect($response)->toBeInstanceOf(ClientResponse::class);
    expect($response->data)->toBeInstanceOf(Collection::class);
});

test('People: Can Get Person By ID', function () {
    $this->person->attributes->personId = 'person_id';

    $response = $this->person->get();

    expect($response)->toBeInstanceOf(ClientResponse::class);
});

test('People: Can Update Person Profile', function () {
    $this->person->attributes->personId = 'person_id';

    $response = $this->person->update();

    expect($response)->toBeInstanceOf(ClientResponse::class);
});

test('People: Can Delete Person Profile', function () {
    $this->person->attributes->personId = 'person_id';

    $response = $this->person->delete();

    expect($response)->toBeInstanceOf(ClientResponse::class);
});