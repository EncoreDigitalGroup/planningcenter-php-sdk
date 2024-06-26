<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Helpers;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\SdkClientFoundation\SdkObjects\ClientResponse as BaseClientResponse;

class PlanningCenterHelper
{
    public static function wasSuccessful(BaseClientResponse|ClientResponse $response): bool
    {
        if ($response->sdk->outcome->success) {
            return true;
        }

        return false;
    }

    public static function wasNotSuccessful(BaseClientResponse|ClientResponse $response): bool
    {
        if (! $response->sdk->outcome->success) {
            return true;
        }

        return false;
    }

    public static function wasUnsuccessful(BaseClientResponse|ClientResponse $res): bool
    {
        return self::wasNotSuccessful($res);
    }

    public static function wasRateLimited(BaseClientResponse|ClientResponse $response): bool
    {
        if ($response->sdk->outcome->rateLimited) {
            return true;
        }

        return false;
    }

    public static function wasNotRateLimited(BaseClientResponse|ClientResponse $response): bool
    {
        if (! $response->sdk->outcome->rateLimited) {
            return true;
        }

        return false;
    }

    public static function serviceError(BaseClientResponse|ClientResponse $response): bool
    {
        if ($response->sdk->outcome->http->statusCode >= 500) {
            return true;
        }

        return false;
    }

    public static function idealRequestOutcome(BaseClientResponse|ClientResponse $response): bool
    {
        if (self::wasNotSuccessful($response) || self::wasRateLimited($response) || self::serviceError($response)) {
            return false;
        }

        return true;
    }
}
