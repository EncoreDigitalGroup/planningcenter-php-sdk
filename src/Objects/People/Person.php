<?php

namespace EncoreDigitalGroup\PlanningCenter\Objects\People;

use DateTime;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use GuzzleHttp\Psr7\Request;
use stdClass;

class Person
{
    use HasPlanningCenterClient;

    public int $personId;
    public string $given_name;
    public string $first_name;
    public string $nickname;
    public string $middle_name;
    public DateTime $last_name;
    public DateTime $birthdate;
    public DateTime $anniversary;
    public string $gender;
    public int $grade;
    public bool $child;
    public int $graduation_year;
    public bool $site_administrator;
    public bool $accounting_administrator;
    public string $people_permissions;
    public string $membership;
    public DateTime $inactivated_at;
    public string $medical_notes;
    public bool $mfa_configured;
    public DateTime $created_at;
    public DateTime $updated_at;
    public string $avatar;
    public string $name;
    public string $demographic_avatar_url;
    public string $directory_status;
    public bool $passed_background_check;
    public bool $can_create_forms;
    public bool $can_email_lists;
    public string $school_type;
    public string $status;
    public int $primary_campus_id;
    public int $remote_id;

    private static function prepareDataObject(self $person): stdClass
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

    public function all(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'people/v2/people?' . $query, $headers);

        return $this->client->send($request);
    }

    public function get(array $query = []): ClientResponse
    {
        $headers = $this->buildHeaders();

        $query = http_build_query($query);

        $request = new Request('GET', 'people/v2/people/' . $this->personId . '?' . $query, $headers);

        return $this->client->send($request);
    }

    public function create(): ClientResponse
    {
        $headers = $this->buildHeaders();

        $request = new Request('POST', 'people/v2/people', $headers, json_not_null($this));

        return $this->client->send($request);
    }

    public function update(): ClientResponse
    {
        $headers = $this->buildHeaders();

        $Person = self::prepareDataObject($this);

        $request = new Request('PATCH', 'people/v2/people/' . $this->personId, $headers, json_not_null($Person));

        return $this->client->send($request);
    }

    public function delete(): ClientResponse
    {
        $headers = $this->buildHeaders();

        $request = new Request('DELETE', 'people/v2/people/' . $this->personId, $headers, json_not_null($this));

        return $this->client->send($request);
    }

    public function email(): ClientResponse
    {
        $email = new Email($this->client);
        $email->personId = $this->personId;

        return $email->get();
    }
}
