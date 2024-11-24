<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace Tests\Unit\People;

use EncoreDigitalGroup\PlanningCenter\Objects\People\Person;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use PHPGenesis\Http\HttpClient;
use Tests\Helpers\BaseMock;

class PeopleMocks extends BaseMock
{
    use HasPlanningCenterClient;

    public const string PERSON_ID = '1';
    public const string FIRST_NAME = 'John';
    public const string LAST_NAME = 'Smith';
    public const string EMAIL_ID = '1';
    public const string EMAIL_ADDRESS = 'john.smith@example.com';

    public static function setup(): void
    {
        self::useProfileCollection();
        self::useSpecificProfile();
    }

    public static function useProfileCollection(): void
    {
        HttpClient::fake([
            self::HOSTNAME . Person::PEOPLE_ENDPOINT => function ($request) {
                return match ($request->method()) {
                    'POST' => HttpClient::response(self::useSingleResponse("profile")),
                    'GET', => HttpClient::response(self::useCollectionResponse("profile")),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    public static function useSpecificProfile(): void
    {
        HttpClient::fake([
            self::HOSTNAME . Person::PEOPLE_ENDPOINT . '/1' => function ($request) {
                return match ($request->method()) {
                    'PUT', 'PATCH', 'GET', => HttpClient::response(self::useSingleResponse("profile")),
                    'DELETE' => HttpClient::response(self::deleteResponse()),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    public static function useEmailCollection(): void
    {
        HttpClient::fake([
            self::HOSTNAME . Person::PEOPLE_ENDPOINT => function ($request) {
                return match ($request->method()) {
                    'POST' => HttpClient::response(self::useSingleResponse("email")),
                    'GET', => HttpClient::response(self::useCollectionResponse("email")),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    protected static function profile(): array
    {
        return [
            "type" => "Person",
            "id" => "1",
            "attributes" => [
                "avatar" => "string",
                "demographic_avatar_url" => "string",
                "first_name" => self::FIRST_NAME,
                "name" => self::FIRST_NAME . ' ' . self::LAST_NAME,
                "status" => "string",
                "remote_id" => 1,
                "accounting_administrator" => true,
                "anniversary" => "2000-01-01",
                "birthdate" => "2000-01-01",
                "child" => true,
                "given_name" => "string",
                "grade" => 1,
                "graduation_year" => 1,
                "last_name" => self::LAST_NAME,
                "middle_name" => "string",
                "nickname" => "string",
                "people_permissions" => "string",
                "site_administrator" => true,
                "gender" => "string",
                "inactivated_at" => "2000-01-01T12:00:00Z",
                "medical_notes" => "string",
                "membership" => "string",
                "created_at" => "2000-01-01T12:00:00Z",
                "updated_at" => "2000-01-01T12:00:00Z",
                "can_create_forms" => true,
                "can_email_lists" => true,
                "directory_shared_info" => [],
                "directory_status" => "string",
                "passed_background_check" => true,
                "resource_permission_flags" => [],
                "school_type" => "string",
                "login_identifier" => "string",
                "mfa_configured" => true,
                "stripe_customer_identifier" => "string",
            ],
            "relationships" => [
                "primary_campus" => [
                    "data" => [
                        "type" => "PrimaryCampus",
                        "id" => "1",
                    ],
                ],
                "gender" => [
                    "data" => [
                        "type" => "Gender",
                        "id" => "1",
                    ],
                ],
            ],
        ];
    }

    protected static function email(): array
    {
        return [
            'type' => 'Email',
            'id' => '1',
            'attributes' => [
                'address' => 'john.smith@example.com',
                'location' => 'home',
                'primary' => true,
                'created_at' => '2000-01-01T12:00:00Z',
                'updated_at' => '2000-01-01T12:00:00Z',
                'blocked' => true,
            ],
            'relationships' => [
                'person' => [
                    'data' => [
                        'type' => 'Person',
                        'id' => '1',
                    ],
                ],
            ],
        ];
    }
}