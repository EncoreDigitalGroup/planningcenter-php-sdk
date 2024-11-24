<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

if (!function_exists('pco_objectify')) {
    function pco_objectify(array|stdClass|null $value): ?stdClass
    {
        if (is_null($value)) {
            return null;
        }

        $value = objectify($value);

        if (is_array($value)) {
            $value = $value[0];
        }

        return $value;
    }
}