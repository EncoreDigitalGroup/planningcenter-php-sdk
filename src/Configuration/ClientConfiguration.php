<?php

/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Configuration;

/** @api */
class ClientConfiguration
{
    const CALENDAR_API_VERSION = '2021-07-20';
    const GROUPS_API_VERSION = '2023-07-10';
    const PEOPLE_API_VERSION = '2023-02-15';

    protected AuthorizationOptions $authorization;
    protected PcoConfigOptions $calendar;
    protected PcoConfigOptions $groups;
    protected PcoConfigOptions $people;

    public function __construct()
    {
        $this->authorization = new AuthorizationOptions();
        $this->calendar = new PcoConfigOptions();
        $this->groups = new PcoConfigOptions();
        $this->people = new PcoConfigOptions();

        $this->calendar->setApiVersion(self::CALENDAR_API_VERSION);
        $this->groups->setApiVersion(self::GROUPS_API_VERSION);
        $this->people->setApiVersion(self::PEOPLE_API_VERSION);
    }

    public function authorization(): AuthorizationOptions
    {
        return $this->authorization;
    }

    public function calendar(): PcoConfigOptions
    {
        return $this->calendar;
    }

    public function groups(): PcoConfigOptions
    {
        return $this->groups;
    }

    public function people(): PcoConfigOptions
    {
        return $this->people;
    }
}
