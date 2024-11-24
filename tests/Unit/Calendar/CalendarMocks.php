<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace Tests\Unit\Calendar;

use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Event;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use PHPGenesis\Http\HttpClient;
use Tests\Helpers\BaseMock;
use Tests\Helpers\ObjectType;

class CalendarMocks extends BaseMock
{
    use HasPlanningCenterClient;

    public const string EVENT_ID = '1';
    public const string EVENT_NAME = 'Sample Event';

    public static function setup(): void
    {
        self::useEventCollection();
        self::useSpecificEvent();
    }

    public static function useEventCollection(): void
    {
        HttpClient::fake([
            self::HOSTNAME . Event::EVENT_ENDPOINT => function ($request) {
                return match ($request->method()) {
                    'POST' => HttpClient::response(self::useSingleResponse(ObjectType::Event)),
                    'GET' => HttpClient::response(self::useCollectionResponse(ObjectType::Event)),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    public static function useSpecificEvent(): void
    {
        HttpClient::fake([
            self::HOSTNAME . Event::EVENT_ENDPOINT . '/1' => function ($request) {
                return match ($request->method()) {
                    'PUT', 'PATCH', 'GET' => HttpClient::response(self::useSingleResponse(ObjectType::Event)),
                    'DELETE' => HttpClient::response(self::deleteResponse()),
                    default => HttpClient::response([], 405),
                };
            },
        ]);
    }

    protected static function event(): array
    {
        return [
            'type' => 'Event',
            'id' => '1',
            'attributes' => [
                'approval_status' => 'string',
                'created_at' => '2000-01-01T12:00:00Z',
                'description' => 'string',
                'featured' => true,
                'image_url' => 'string',
                'name' => self::EVENT_NAME,
                'percent_approved' => 1,
                'percent_rejected' => 1,
                'registration_url' => 'string',
                'summary' => 'string',
                'updated_at' => '2000-01-01T12:00:00Z',
                'visible_in_church_center' => true,
            ],
            'relationships' => [
                'owner' => [
                    'data' => [
                        'type' => 'Person',
                        'id' => '1',
                    ],
                ],
            ],
        ];
    }
}