<?php

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
