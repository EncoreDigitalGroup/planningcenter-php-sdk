<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\Groups;

use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;
use Illuminate\Http\Client\Response;
use stdClass;

/** @api */
class Event
{
    use HasPlanningCenterClient;

    public const EVENT_ENDPOINT = '/groups/v2/events';

    public int|string|null $id;
    public EventAttributes $attributes;


    public function all(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::EVENT_ENDPOINT, $query);

        $clientResponse = new ClientResponse($http);

        foreach ($http->json('data') as $groupEvent) {
            $pcoGroupEvent = new Event($this->clientId, $this->clientSecret);
            // TODO: Create mapFromPco method.
            $pcoGroupEvent->mapFromPco($groupEvent);
            $clientResponse->data->push($pcoGroupEvent);
        }

        return $clientResponse;
    }

    public function get(array $query = []): ClientResponse
    {
        $http = $this->client()
            ->get($this->hostname() . self::EVENT_ENDPOINT . '/' . $this->id, $query);

        return $this->processResponse($http);
    }

    private function mapFromPco(stdClass $pco): void
    {

    }
}
