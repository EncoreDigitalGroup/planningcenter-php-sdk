<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\SdkClientFoundation\BaseClient;
use EncoreDigitalGroup\SdkClientFoundation\ClientConfiguration as BaseClientConfiguration;
use EncoreDigitalGroup\SdkClientFoundation\SdkObjects\ClientResponse as BaseClientResponse;

class PlanningCenterClient extends BaseClient
{
    public function __construct(BaseClientConfiguration $config)
    {
        parent::__construct($config);
        $this->config->setBaseUri('https://api.planningcenteronline.com');
    }

    public function setConfiguration(BaseClientConfiguration $config): BaseClientConfiguration
    {
        $this->config = $config;

        return $this->config;
    }

    public function getConfiguration(): BaseClientConfiguration
    {
        return $this->config;
    }

    protected function processResponse(mixed $res): BaseClientResponse
    {
        return new ClientResponse($res);
    }
}
