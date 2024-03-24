<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects;

class ClientResponse
{
    public SdkContainer $sdk;
    public object $pco;

    public function __construct()
    {
        $this->sdk = new SdkContainer();
    }

}