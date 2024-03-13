<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\People;

use DateTime;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;
use stdClass;

/**
 * @property int id
 * @property string given_name
 * @property string first_name
 * @property string nickname
 * @property string middle_name
 * @property string last_name
 * @property DateTime birthdate
 * @property DateTime anniversary
 * @property string gender
 * @property int grade
 * @property bool child
 * @property int graduation_year
 * @property bool site_administrator
 * @property bool accounting_administrator
 * @property string people_permissions
 * @property string membership
 * @property DateTime inactivated_at
 * @property string medical_notes
 * @property bool mfa_configured
 * @property DateTime created_at
 * @property DateTime updated_at
 * @property string avatar
 * @property string name
 * @property string demographic_avatar_url
 * @property string directory_status
 * @property bool passed_background_check
 * @property bool can_create_forms
 * @property bool can_email_lists
 * @property string school_type
 * @property string status
 * @property int primary_campus_id
 * @property int $gender_id
 * @property int $remote_id
 */
class Person
{
    use HasPlanningCenterClient;

    public mixed $id;
    public mixed $given_name;
    public mixed $first_name;
    public mixed $nickname;
    public mixed $middle_name;
    public mixed $last_name;
    public mixed $birthdate;
    public mixed $anniversary;
    public mixed $gender;
    public mixed $grade;
    public mixed $child;
    public mixed $graduation_year;
    public mixed $site_administrator;
    public mixed $accounting_administrator;
    public mixed $people_permissions;
    public mixed $membership;
    public mixed $inactivated_at;
    public mixed $medical_notes;
    public mixed $mfa_configured;
    public mixed $created_at;
    public mixed $updated_at;
    public mixed $avatar;
    public mixed $name;
    public mixed $demographic_avatar_url;
    public mixed $directory_status;
    public mixed $passed_background_check;
    public mixed $can_create_forms;
    public mixed $can_email_lists;
    public mixed $school_type;
    public mixed $status;
    public mixed $primary_campus_id;
    public mixed $gender_id;
    public mixed $remote_id;

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

    public function all($query = []): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getPeopleApiVersion(),
        ];

        $query = http_build_query($query);
        $request = new Request('GET', 'people/v2/people?' . $query, $headers);

        return $this->client->send($request);
    }

    public function get(self $person, $query = []): stdClass
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

    public function update(self $person): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getPeopleApiVersion(),
        ];

        $Person = self::prepareDataObject($person);

        $request = new Request('PATCH', 'people/v2/people/' . $person->id, $headers, json_encode($Person));

        return $this->client->send($request);
    }

    public function delete(self $person): stdClass
    {
        $headers = [
            'Authorization' => $this->config->getAuthorization(),
            'X-PCO-API-Version' => $this->config->getPeopleApiVersion(),
        ];
        $request = new Request('DELETE', 'people/v2/people/' . $person->id, $headers, json_encode($person));

        return $this->client->send($request);
    }

    public function email(self $person): stdClass
    {
        $Email = new Email($this->client);

        return $Email->get($person);
    }
}
