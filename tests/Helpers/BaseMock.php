<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace Tests\Helpers;

class BaseMock
{
    protected static function useCollectionResponse(string $method): array
    {
        return [
            'data' => [
                static::$method(),
            ],
        ];
    }

    protected static function useSingleResponse(string $method): array
    {
        return [
            'data' => static::$method(),
        ];
    }

    protected static function deleteResponse(): array
    {
        return [
            'data' => null,
        ];
    }
}