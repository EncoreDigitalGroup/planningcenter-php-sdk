<?php

namespace EncoreDigitalGroup\PlanningCenter\People;

use DateTime;
use GuzzleHttp\Psr7\Request;
use stdClass;

class Person
{
    /**
     * @prop $id int
     * @prop $given_name string
     * @prop $first_name string
     * @prop $nickname string
     * @prop $middle_name string
     * @prop $last_name string
     * @prop $birthdate DateTime
     * @prop $anniversary DateTime
     * @prop $gender string
     * @prop $grade int
     * @prop $child bool
     * @prop $graduation_year int
     * @prop $site_administrator bool
     * @prop $accounting_administrator bool
     * @prop $people_permissions string
     * @prop $membership string
     * @prop $inactivated_at DateTime
     * @prop $medical_notes string
     * @prop $mfa_configured bool
     * @prop $created_at DateTime
     * @prop $updated_at DateTime
     * @prop $avatar string
     * @prop $name string
     * @prop $demographic_avatar_url string
     * @prop $directory_status string
     * @prop $passed_background_check bool
     * @prop $can_create_forms bool
     * @prop $can_email_lists bool
     * @prop $school_type string
     * @prop $status string
     * @prop $primary_campus_id int
     * @prop $gender_id int
     * @prop $remote_id int
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
