<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Configuration;

use PHPGenesis\Common\Container\PhpGenesisContainer;
use PHPGenesis\Http\HttpClientBuilder;

class ClientConfiguration
{
    const CALENDAR_API_VERSION = '2021-07-20';
    const GROUPS_API_VERSION = '2023-07-10';
    const PEOPLE_API_VERSION = '2023-02-15';

    public AuthorizationOptions $authorization;

    protected PhpGenesisContainer $container;
    protected HttpClientBuilder $builder;
    protected PcoConfigOptions $calendar;
    protected PcoConfigOptions $groups;
    protected PcoConfigOptions $people;

    public function __construct()
    {
        $this->container = PhpGenesisContainer::getInstance();
        $this->builder = new HttpClientBuilder;
        $this->authorization = new AuthorizationOptions;
        $this->calendar = new PcoConfigOptions;
        $this->groups = new PcoConfigOptions;
        $this->people = new PcoConfigOptions;

        $this->calendar->setApiVersion(self::CALENDAR_API_VERSION);
        $this->groups->setApiVersion(self::GROUPS_API_VERSION);
        $this->people->setApiVersion(self::PEOPLE_API_VERSION);
    }
}
