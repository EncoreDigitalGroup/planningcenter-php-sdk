<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\People;

use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;
use stdClass;

class Email
{
    use HasPlanningCenterClient;

    public mixed $personId;
    public mixed $address;
    public mixed $location;
    public mixed $primary;
    public mixed $created_at;
    public mixed $updated_at;
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

    public function get(): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getPeopleApiVersion(),
        ];

        $request = new Request('GET', 'people/v2/people/' . $this->personId . '/emails', $headers, json_not_null($this));

        return $this->client->send($request);
    }

    public function update(self $email): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getPeopleApiVersion(),
        ];

        $emailObj = self::prepareDataObject($email);

        $request = new Request('PATCH', 'people/v2/emails/' . $email->personId, $headers, json_not_null($emailObj));

        return $this->client->send($request);
    }
}
