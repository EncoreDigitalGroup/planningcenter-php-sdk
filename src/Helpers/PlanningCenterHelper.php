<?php

namespace EncoreDigitalGroup\PlanningCenter\Helpers;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;

class PlanningCenterHelper
{
    public static function wasSuccessful(ClientResponse $response): bool
    {
        if ($response->sdk->outcome->success) {
            return true;
        }

        return false;
    }

    public static function wasNotSuccessful(ClientResponse $response): bool
    {
        if (! $response->sdk->outcome->success) {
            return true;
        }

        return false;
    }

    public static function wasUnsuccessful(ClientResponse $res): bool
    {
        return self::wasNotSuccessful($res);
    }

    public static function wasRateLimited(ClientResponse $response): bool
    {
        if ($response->sdk->outcome->rateLimited) {
            return true;
        }

        return false;
    }

    public static function wasNotRateLimited(ClientResponse $response): bool
    {
        if (!$response->sdk->outcome->rateLimited) {
            return true;
        }

        return false;
    }

    public static function serviceError(ClientResponse $response): bool
    {
        if ($response->sdk->outcome->http->statusCode >= 500) {
            return true;
        }

        return false;
    }

    public static function idealRequestOutcome(ClientResponse $response): bool
    {
        if (self::wasNotSuccessful($response) || self::wasRateLimited($response) || self::serviceError($response)) {
            return false;
        }

        return true;
    }
}