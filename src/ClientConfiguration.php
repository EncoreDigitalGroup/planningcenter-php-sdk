<?php

namespace EncoreDigitalGroup\PlanningCenter;

class ClientConfiguration
{
    const CALENDAR_API_VERSION = '2021-07-20';
    const GROUPS_API_VERSION = '2023-07-10';
    const PEOPLE_API_VERSION = '2023-02-15';
    protected array $authorization;
    protected string $authorizationToken;
    protected string $authorizationType;
    protected array $calendar;
    protected array $groups;
    protected array $people;

    public function __construct()
    {
        $this->calendar = [
            'apiVersion' => $this->getCalenderApiVersion(),
        ];

        $this->groups = [
            'apiVersion' => $this->getGroupsApiVersion(),
        ];

        $this->people = [
            'apiVersion' => $this->getPeopleApiVersion(),
        ];
    }

    public function setAuthorization($authorization = null): void
    {
        $this->authorization = $authorization ?? $this->getAuthorization();
    }

    public function getAuthorization(): string
    {
        return $this->getAuthorizationType() . " " . base64_encode($this->getAuthorizationToken());
    }

    public function setAuthorizationToken($authorization_token = null): void
    {
        $this->authorizationToken = $authorization_token ?? $this->getAuthorization();
    }

    public function getAuthorizationToken(): string
    {
        return $this->authorization['authorization'] ?? '';
    }

    public function setAuthorizationType($authorization_type = null): void
    {
        $this->authorizationType = $authorization_type ?? $this->getAuthorizationType();
    }

    public function getAuthorizationType(): string
    {
        return $this->authorizationType ?? 'Basic';
    }

    public function setCalendarApiVersion($version = null): void
    {
        $this->calendar['apiVersion'] = $version ?? $this->getCalenderApiVersion();
    }

    public function getCalenderApiVersion(): string
    {
        return $this->calendar['apiVersion'] ?? self::CALENDAR_API_VERSION;
    }

    public function setGroupsApiVersion($version = null): void
    {
        $this->groups['apiVersion'] = $version ?? $this->getGroupsApiVersion();
    }

    public function getGroupsApiVersion(): string
    {
        return $this->groups['apiVersion'] ?? self::GROUPS_API_VERSION;
    }

    public function setPeopleApiVersion($version = null): void
    {
        $this->people['apiVersion'] = $version ?? $this->getPeopleApiVersion();
    }

    public function getPeopleApiVersion(): string
    {
        return $this->people['apiVersion'] ?? self::PEOPLE_API_VERSION;
    }
}
