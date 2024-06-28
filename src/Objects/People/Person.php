<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People;

use DateTime;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use Illuminate\Support\Carbon;
use PHPGenesis\Http\HttpClient;
use stdClass;

class Person
{
    use HasPlanningCenterClient;

    public int $personId;
    public ?string $given_name;
    public ?string $first_name;
    public ?string $nickname;
    public ?string $middle_name;
    public ?string $last_name;
    public DateTime|Carbon|null $birthdate;
    public DateTime|Carbon|null $anniversary;
    public ?string $gender;
    public ?int $grade;
    public ?bool $child;
    public ?int $graduation_year;
    public ?bool $site_administrator;
    public ?bool $accounting_administrator;
    public ?string $people_permissions;
    public ?string $membership;
    public DateTime|Carbon|null $inactivated_at;
    public ?string $medical_notes;
    public ?bool $mfa_configured;
    public DateTime|Carbon|null $created_at;
    public DateTime|Carbon|null $updated_at;
    public ?string $avatar;
    public ?string $name;
    public ?string $demographic_avatar_url;
    public ?string $directory_status;
    public ?bool $passed_background_check;
    public ?bool $can_create_forms;
    public ?bool $can_email_lists;
    public ?string $school_type;
    public ?string $status;
    public ?int $primary_campus_id;
    public ?int $remote_id;

    private static function mapToPco(self $person): stdClass
    {
        $pco = new stdClass;
        $pco->data = new stdClass;
        $pco->data->attributes = new stdClass;
        $pco->data->attributes->first_name = $person->first_name;
        $pco->data->attributes->middle_name = $person->middle_name;
        $pco->data->attributes->last_name = $person->last_name;
        $pco->data->attributes->birthdate = $person->birthdate;
        $pco->data->attributes->anniversary = $person->anniversary;
        $pco->data->attributes->gender = $person->gender;
        $pco->data->attributes->grade = $person->grade;
        $pco->data->attributes->child = $person->child;
        $pco->data->attributes->graduation_year = $person->graduation_year;
        $pco->data->attributes->membership = $person->membership;
        $pco->data->attributes->status = $person->status;

        return $pco;
    }

    public function all(array $query = [])
    {
        $http = HttpClient::baseUrl($this->baseUrl)
            ->get('people/v2/people', $query);
    }

    public function get(array $query = [])
    {
        $http = HttpClient::baseUrl($this->baseUrl)
            ->get('people/v2/people/' . $this->personId, $query);
    }

    public function create()
    {
        $http = HttpClient::baseUrl($this->baseUrl)
            ->post('people/v2/people', [
                'first_name' => $this->first_name,
                'middle_name' => $this->middle_name,
                'last_name' => $this->last_name,
            ]);
    }

    public function update()
    {

        $http = HttpClient::patch('people/v2/people/' . $this->personId, [
            'first_name' => $this->first_name,
            'middle_name' => $this->middle_name,
            'last_name' => $this->last_name,
        ]);
    }

    public function delete()
    {
        $http = HttpClient::delete('people/v2/people/' . $this->personId);
    }

    public function email(): ClientResponse
    {
        $email = new Email($this->client);
        $email->personId = $this->personId;

        return $email->get();
    }
}
