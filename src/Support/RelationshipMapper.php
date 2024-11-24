<?php

namespace EncoreDigitalGroup\PlanningCenter\Support;

use Carbon\Exceptions\InvalidFormatException;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\Relationships\BasicRelationship;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\Relationships\BasicRelationshipData;
use Illuminate\Support\Carbon;
use stdClass;

class RelationshipMapper
{
    public static function from(array|stdClass $pco, mixed $relationships, array $relationshipMap): void
    {
        if (!is_array($pco)) {
            foreach ($relationshipMap as $relationship => $property) {
                if (property_exists($pco->relationships, $property)) {
                    if (
                        $relationships->$relationship instanceof BasicRelationship
                        && $relationships->$relationship->data instanceof BasicRelationshipData
                    ) {
                        $relationships->$relationship->data->type = $pco->relationships->$relationship->data->type;
                        $relationships->$relationship->data->id = $pco->relationships->$relationship->data->id;
                    }
                } else {
                    $relationships->$relationship = null;
                }
            }
        }
    }
}