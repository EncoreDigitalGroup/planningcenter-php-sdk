<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\Relationships;

class BasicRelationshipData
{
    public function __construct(
        public ?string $type = null,
        public ?string $id = null,
    ) {}
}
