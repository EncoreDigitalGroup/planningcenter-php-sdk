<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects;

use EncoreDigitalGroup\SdkClientFoundation\SdkObjects\OutcomeContainer as BaseOutcomeContainer;
use EncoreDigitalGroup\SdkClientFoundation\SdkObjects\PageContainer as BasePageContainer;
use EncoreDigitalGroup\SdkClientFoundation\SdkObjects\SdkContainer as BaseSdkContainer;

class SdkContainer extends BaseSdkContainer
{
    public BaseOutcomeContainer $outcome;
    public BasePageContainer $page;

    public function __construct()
    {
        $this->outcome = new OutcomeContainer;
        $this->page = new PageContainer;
    }
}
