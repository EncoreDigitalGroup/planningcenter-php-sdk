<?php

if (!function_exists('json_not_null')) {
    function json_not_null(mixed $data): bool|string
    {
        $filteredProperties = array_filter(get_object_vars($data), function ($value) {
            return $value !== null;
        });

        return json_encode($filteredProperties);
    }
}