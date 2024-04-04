<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects;

class HttpContainer
{
    public ?int $statusCode;
    public string $message;
    public string $pco;
    public int $attempts;
}
