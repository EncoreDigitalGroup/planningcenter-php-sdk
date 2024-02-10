<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\People;

use DateTime;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;
use stdClass;

class Person
{
    use HasPlanningCenterClient;

    /** @var int */
    public $id;

    /** @var string */
    public $given_name;

    /** @var string */
    public $first_name;

    /** @var string */
    public $nickname;

    /** @var string */
    public $middle_name;

    /** @var string */
    public $last_name;

    /** @var DateTime */
    public $birthdate;

    /** @var DateTime */
    public $anniversary;

    /** @var string */
    public $gender;

    /** @var int */
    public $grade;

    /** @var bool */
    public $child;

    /** @var int */
    public $graduation_year;

    /** @var bool */
    public $site_administrator;

    /** @var bool */
    public $accounting_administrator;

    /** @var string */
    public $people_permissions;

    /** @var string */
    public $membership;

    /** @var DateTime */
    public $inactivated_at;

    /** @var string */
    public $medical_notes;

    /** @var bool */
    public $mfa_configured;

    /** @var DateTime */
    public $created_at;

    /** @var DateTime */
    public $updated_at;

    /** @var string */
    public $avatar;

    /** @var string */
    public $name;

    /** @var string */
    public $demographic_avatar_url;

    /** @var string */
    public $directory_status;

    /** @var bool */
    public $passed_background_check;

    /** @var bool */
    public $can_create_forms;

    /** @var bool */
    public $can_email_lists;

    /** @var string */
    public $school_type;

    /** @var string */
    public $status;

    /** @var int */
    public $primary_campus_id;

    /** @var int */
    public $gender_id;

    /** @var int */
    public $remote_id;

    private static function prepareDataObject($person): stdClass
    {
        $Person = new stdClass;
        $Person->data = new stdClass;
        $Person->data->attributes = new stdClass;
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
}
