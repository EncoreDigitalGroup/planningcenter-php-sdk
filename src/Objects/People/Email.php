<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\People;

use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;
use stdClass;

class Email
{
    use HasPlanningCenterClient;

    public $id;
    public $address;
    public $location;
    public $primary;
    public $created_at;
    public $updated_at;
    public $blocked;

    private static function prepareDataObject($email): stdClass
    {
        $Email = new stdClass;
        $Email->data = new stdClass;
        $Email->data->attributes = new stdClass;
        $Email->data->attributes->address = $email->address;
        $Email->data->attributes->primary = $email->primary;

        return $Email;
    }

    public function get(Person $person): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getPeopleApiVersion(),
        ];

        $request = new Request('GET', 'people/v2/people/' . $person->id . '/emails', $headers, json_encode($person));

        return $this->client->send($request);
    }

    public function update(self $email): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getPeopleApiVersion(),
        ];

        $Email = self::prepareDataObject($email);

        $request = new Request('PATCH', 'people/v2/emails/' . $email->id, $headers, json_encode($Email));

        return $this->client->send($request);
    }
}
