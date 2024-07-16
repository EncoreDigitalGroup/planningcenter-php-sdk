<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter;

use EncoreDigitalGroup\PlanningCenter\Configuration\ClientConfiguration;
use PHPGenesis\Common\Container\PhpGenesisContainer;
use PHPGenesis\Http\HttpClient;
use PHPGenesis\Http\HttpClientBuilder;

class PlanningCenterClient
{
    protected HttpClientBuilder $builder;

    public function __construct()
    {
        PhpGenesisContainer::getInstance()->singleton(ClientConfiguration::class, function (): \EncoreDigitalGroup\PlanningCenter\Configuration\ClientConfiguration {
            return new ClientConfiguration();
        });

        $this->builder = new HttpClientBuilder();

        HttpClient::baseUrl('https://api.planningcenteronline.com');
    }
}
