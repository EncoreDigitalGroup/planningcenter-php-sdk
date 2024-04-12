<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects;

use EncoreDigitalGroup\SdkClientFoundation\SdkObjects\PageContainer as BasePageContainer;

class PageContainer extends BasePageContainer
{
    public ?int $next;
    public ?int $previous;
}
