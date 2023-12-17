<?php

namespace EncoreDigitalGroup\PlanningCenter\People;

use DateTime;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;
use stdClass;

class Person
{
    use HasPlanningCenterClient;

    /** @var $id int */
    public $id;

    /** @var $given_name string */
    public $given_name;

    /** @var $first_name string */
    public $first_name;

    /** @var $nickname string */
    public $nickname;

    /** @var $middle_name string */
    public $middle_name;

    /** @var $last_name string */
    public $last_name;

    /** @var $birthdate DateTime */
    public $birthdate;

    /** @var $anniversary DateTime */
    public $anniversary;

    /** @var $gender string */
    public $gender;

    /** @var $grade int */
    public $grade;

    /** @var $child bool */
    public $child;

    /** @var $graduation_year int */
    public $graduation_year;

    /** @var $site_administrator bool */
    public $site_administrator;

    /** @var $accounting_administrator bool */
    public $accounting_administrator;

    /** @var $people_permissions string */
    public $people_permissions;

    /** @var $membership string */
    public $membership;

    /** @var $inactivated_at DateTime */
    public $inactivated_at;

    /** @var $medical_notes string */
    public $medical_notes;

    /** @var $mfa_configured bool */
    public $mfa_configured;

    /** @var $created_at DateTime */
    public $created_at;

    /** @var $updated_at DateTime */
    public $updated_at;

    /** @var $avatar string */
    public $avatar;

    /** @var $name string */
    public $name;

    /** @var $demographic_avatar_url string */
    public $demographic_avatar_url;

    /** @var $directory_status string */
    public $directory_status;

    /** @var $passed_background_check bool */
    public $passed_background_check;

    /** @var $can_create_forms bool */
    public $can_create_forms;

    /** @var $can_email_lists bool */
    public $can_email_lists;

    /** @var $school_type string */
    public $school_type;

    /** @var $status string */
    public $status;

    /** @var $primary_campus_id int */
    public $primary_campus_id;

    /** @var $gender_id int */
    public $gender_id;

    /** @var $remote_id int */
    public $remote_id;

    public function all($query = [])
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getPeopleApiVersion(),
        ];

        $query = http_build_query($query);
        $request = new Request('GET', 'people/v2/people?' . $query, $headers);

        return $this->client->send($request);
    }

    public function get(self $person, $query = []): string
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getPeopleApiVersion(),
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'people/v2/people/' . $person->id . '?' . $query, $headers);

        return $this->client->send($request);
    }

    public function create(self $person): string
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getPeopleApiVersion(),
        ];
        $request = new Request('POST', 'people/v2/people', $headers, json_encode($person));

        return $this->client->send($request);
    }

    public function update(self $person): string
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getPeopleApiVersion(),
        ];

        $Person = self::prepareDataObject($person);

        $request = new Request('PATCH', 'people/v2/people/' . $person->id, $headers, json_encode($Person));

        return $this->client->send($request);
    }

    public function delete(self $person): string
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getPeopleApiVersion(),
        ];
        $request = new Request('DELETE', 'people/v2/people/' . $person->id, $headers, json_encode($person));

        return $this->client->send($request);
    }

    public function email(self $person): string
    {
        $Email = new Email($this->client);
        return $Email->get($person);
    }

    private static function prepareDataObject($person): stdClass
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
