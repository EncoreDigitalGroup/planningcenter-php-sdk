<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

if (! function_exists('json_not_null')) {
    function json_not_null(mixed $data): string
    {
        $jsonString = json_encode($data);

        if ($jsonString === false) {
            return '';
        }

        $array = json_decode($jsonString, true);

        if ($array === null) {
            return '';
        }

        $array = array_filter($array, function ($value) {
            return $value !== null;
        });

        $result = json_encode($array);

        if ($result === false) {
            return '';
        }

        return $result;
    }
}
