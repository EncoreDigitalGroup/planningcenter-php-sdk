<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace Tests\Helpers;

class BaseMock
{
    protected static function useCollectionResponse(ObjectType $type): array
    {
        $method = $type->value;

        return [
            "data" => [
                static::$method(),
            ],
        ];
    }

    protected static function useSingleResponse(ObjectType $type): array
    {
        $method = $type->value;

        return [
            "data" => [
                static::$method(),
            ],
        ];
    }

    protected static function deleteResponse(): array
    {
        return [
            "data" => null,
        ];
    }
}