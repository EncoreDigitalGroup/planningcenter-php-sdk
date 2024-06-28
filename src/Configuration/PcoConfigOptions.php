<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Configuration;

class PcoConfigOptions
{
    protected string $apiVersion;

    public function setApiVersion(string $version): static
    {
        $this->apiVersion = $version;

        return $this;
    }

    public function getApiVersion(): string
    {
        return $this->apiVersion;
    }
}