<?php

namespace EncoreDigitalGroup\PlanningCenter\People;

use DateTime;
use GuzzleHttp\Psr7\Request;
use JMS\Serializer\SerializerBuilder;
use stdClass;

class Email
{
    public $id;
    public $address;
    public $location;
    public $primary;
    public $created_at;
    public $updated_at;
    public $blocked;

    public static function get($PCOClient, Person $person): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['people']['apiVersion'],
        ];
        
        $request = new Request('GET', 'people/v2/people/' . $person->id . '/emails', $headers, json_encode($person));

        return $PCOClient->send($request);
    }

    public static function update($PCOClient, self $email): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['people']['apiVersion'],
        ];
        
        $Email = self::prepareDataObject($email);
        
        $request = new Request('PATCH', 'people/v2/emails/' . $email->id, $headers, json_encode($Email));

        return $PCOClient->send($request);
    }

    private static function prepareDataObject($email)
    {
        $Email = new stdClass();
        $Email->data = new stdClass();
        $Email->data->attributes = new stdClass();
        $Email->data->attributes->address = $email->address;
        $Email->data->attributes->primary = $email->primary;

        return $Email;
    }
}
