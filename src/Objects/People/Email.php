<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People;

use DateTime;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Carbon;
use stdClass;

class Email
{
    use HasPlanningCenterClient;

    public string|int|null $personId;
    public ?string $emailAddressId;
    public string $address;
    public string $location;
    public bool $primary;
    public DateTime|Carbon $created_at;
    public DateTime|Carbon $updated_at;
    public mixed $blocked;

    private static function prepareDataObject(self $email): stdClass
    {
        $Email = new stdClass;
        $Email->data = new stdClass;
        $Email->data->attributes = new stdClass;
        $Email->data->attributes->address = $email->address;
        $Email->data->attributes->primary = $email->primary;

        return $Email;
    }

    public function get(): ClientResponse
    {
        $headers = $this->buildHeaders();

        $request = new Request('GET', 'people/v2/people/' . $this->personId . '/emails', $headers, json_not_null($this));

        return $this->client->send($request);
    }

    public function update(): ClientResponse
    {
        $headers = $this->buildHeaders();

        $emailObj = self::prepareDataObject($this);

        $request = new Request('PATCH', 'people/v2/emails/' . $this->emailAddressId, $headers, json_not_null($emailObj));

        return $this->client->send($request);
    }
}
