<?php

namespace EncoreDigitalGroup\PlanningCenter\People;

use DateTime;
use GuzzleHttp\Psr7\Request;
use stdClass;

class Person
{
    /**
     * @var $id int
     * @var $given_name string
     * @var $first_name string
     * @var $nickname string
     * @var $middle_name string
     * @var $last_name string
     * @var $birthdate DateTime
     * @var $anniversary DateTime
     * @var $gender string
     * @var $grade int
     * @var $child bool
     * @var $graduation_year int
     * @var $site_administrator bool
     * @var $accounting_administrator bool
     * @var $people_permissions string
     * @var $membership string
     * @var $inactivated_at DateTime
     * @var $medical_notes string
     * @var $mfa_configured bool
     * @var $created_at DateTime
     * @var $updated_at DateTime
     * @var $avatar string
     * @var $name string
     * @var $demographic_avatar_url string
     * @var $directory_status string
     * @var $passed_background_check bool
     * @var $can_create_forms bool
     * @var $can_email_lists bool
     * @var $school_type string
     * @var $status string
     * @var $primary_campus_id int
     * @var $gender_id int
     * @var $remote_id int
     */
    public $id;
    public $given_name;
    public $first_name;
    public $nickname;
    public $middle_name;
    public $last_name;
    public $birthdate;
    public $anniversary;
    public $gender;
    public $grade;
    public $child;
    public $graduation_year;
    public $site_administrator;
    public $accounting_administrator;
    public $people_permissions;
    public $membership;
    public $inactivated_at;
    public $medical_notes;
    public $mfa_configured;
    public $created_at;
    public $updated_at;
    public $avatar;
    public $name;
    public $demographic_avatar_url;
    public $directory_status;
    public $passed_background_check;
    public $can_create_forms;
    public $can_email_lists;
    public $school_type;
    public $status;
    public $primary_campus_id;
    public $gender_id;
    public $remote_id;

    public static function all($PCOClient, $query = [])
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['people']['apiVersion'],
        ];

        $query = http_build_query($query);
        $request = new Request('GET', 'people/v2/people?' . $query, $headers);

        return $PCOClient->send($request);
    }

    public static function get($PCOClient, self $person, $query = []): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['people']['apiVersion'],
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'people/v2/people/' . $person->id . '?' . $query, $headers);

        return $PCOClient->send($request);
    }

    public static function create($PCOClient, self $person): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['people']['apiVersion'],
        ];
        $request = new Request('POST', 'people/v2/people', $headers, json_encode($person));

        return $PCOClient->send($request);
    }

    public static function update($PCOClient, self $person): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['people']['apiVersion'],
        ];
        
        $Person = self::prepareDataObject($person);

        $request = new Request('PATCH', 'people/v2/people/' . $person->id, $headers, json_encode($Person));

        return $PCOClient->send($request);
    }

    public static function delete($PCOClient, self $person): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['people']['apiVersion'],
        ];
        $request = new Request('DELETE', 'people/v2/people/' . $person->id, $headers, json_encode($person));

        return $PCOClient->send($request);
    }

    public static function email($PCOClient, self $person): string
    {
        return Email::get($PCOClient, $person);
    }
    
    private static function prepareDataObject($person)
    {
        $Person = new stdClass();
        $Person->data = new stdClass();
        $Person->data->attributes = new stdClass();
        $Person->data->attributes->first_name = $person->first_name;
        $Person->data->attributes->middle_name = $person->middle_name;
        $Person->data->attributes->last_name = $person->last_name;
        $Person->data->attributes->birthdate = $person->birthdate;
        $Person->data->attributes->anniversary = $person->anniversary;
        $Person->data->attributes->gender = $person->gender;
        $Person->data->attributes->grade = $person->grade;
        $Person->data->attributes->child = $person->child;
        $Person->data->attributes->graduation_year = $person->graduation_year;
        $Person->data->attributes->membership = $person->membership;
        $Person->data->attributes->status = $person->status;
        
        return $Person;
    }
}
