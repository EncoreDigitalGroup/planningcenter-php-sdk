<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects;

class SdkContainer
{
    public OutcomeContainer $outcome;
    public PageContainer $page;

    public function __construct()
    {
        $this->outcome = new OutcomeContainer;
        $this->page = new PageContainer;
    }
}
