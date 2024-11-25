<?php

namespace EncoreDigitalGroup\PlanningCenter\Support;

use Carbon\Exceptions\InvalidFormatException;
use Illuminate\Support\Carbon;
use stdClass;

class AttributeMapper
{
    public static function from(array|stdClass $pco, mixed $attributes, array $attributeMap, array $dateTimeAttributes = []): void
    {
        if (!is_array($pco)) {
            foreach ($attributeMap as $property => $attribute) {
                if (property_exists($pco->attributes, $attribute)) {
                    if (in_array($attribute, $dateTimeAttributes)) {
                        try {
                            $attributes->{$property} = Carbon::createFromFormat("c", $pco->attributes->{$attribute});
                        } catch (InvalidFormatException) {
                            try {
                                $attributes->{$property} = Carbon::createFromFormat("Y-m-d", $pco->attributes->{$attribute});
                            } catch (InvalidFormatException) {
                                $attributes->{$property} = null;
                            }
                        }
                    } else {
                        $attributes->{$property} = $pco->attributes->{$attribute};
                    }
                }
            }
        }
    }
}