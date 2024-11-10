<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People;

use DateTime;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Carbon;

/** @experimental */
class Household
{
    use HasPlanningCenterClient;

    public int $householdId;
    public ?string $name;
    public ?int $member_count;
    public ?string $primary_contact_name;
    public DateTime|Carbon|null $created_at;
    public DateTime|Carbon|null $updated_at;
    public ?string $avatar;
    public ?string $primary_contact_id;

    public function all(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'people/v2/people?' . $query, $headers);

        return $this->client->send($request);
    }

    public function get(): ClientResponse
    {
        $headers = $this->buildHeaders();

        $request = new Request('GET', 'people/v2/households/' . $this->householdId, $headers);

        return $this->client->send($request);
    }

    public function people(): ClientResponse
    {
        $headers = $this->buildHeaders();

        $request = new Request('GET', 'people/v2/households/' . $this->householdId . '/people', $headers);

        return $this->client->send($request);
    }
}