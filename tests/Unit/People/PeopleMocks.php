<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace Tests\Unit\People;

use EncoreDigitalGroup\PlanningCenter\Objects\People\Person;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use PHPGenesis\Http\HttpClient;

class PeopleMocks
{
    use HasPlanningCenterClient;

    public const string FIRST_NAME = 'John';
    public const string LAST_NAME = 'Smith';

    public static function setup(): void
    {
        self::useCreatePerson();
    }

    public static function useCreatePerson(): void
    {
        HttpClient::fake([
            self::HOSTNAME . Person::PEOPLE_ENDPOINT . '*' => HttpClient::response([
                'data' => [
                    self::personProfileMock(),
                ],
            ]),
        ]);
    }

    private static function personProfileMock(): array
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
}