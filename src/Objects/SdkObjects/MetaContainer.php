<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects;

use Illuminate\Http\Client\Response;

class MetaContainer
{
    public Response $response;
    public bool $success;
    public ?int $nextPage;
    public ?int $previousPage;
}
