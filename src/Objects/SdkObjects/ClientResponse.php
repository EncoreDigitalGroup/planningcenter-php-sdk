<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects;

class ClientResponse
{
    public SdkContainer $sdk;
    public object $pco;

    public function __construct()
    {
        $this->sdk = new SdkContainer;
    }
}
