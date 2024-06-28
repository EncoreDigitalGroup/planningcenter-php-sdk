<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People;

use EncoreDigitalGroup\PlanningCenter\Objects\People\Attributes\PersonAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use PHPGenesis\Http\HttpClient;
use stdClass;

class Person
{
    use HasPlanningCenterClient;

    public int|string|null $id;
    public ?PersonAttributes $attributes;

    public function all(array $query = []): ClientResponse
    {
        $http = HttpClient::baseUrl($this->baseUrl)
            ->get('people/v2/people', $query);

        $response = new ClientResponse($http);
        $response->data = [];

        foreach($http->json('data') as $person) {
            $p = new Person($this->client);
            $p->mapFromPco($person);
            $response->data[] = $p;
        }

        return $response;
    }

    public function get(array $query = []): ClientResponse
    {
        $http = HttpClient::baseUrl($this->baseUrl)
            ->get('people/v2/people/' . $this->id, $query);

        $response = new ClientResponse($http);
        $this->mapFromPco($http->json('data'));
        $response->data = $this->attributes;

        return $response;
    }

    public function create()
    {
        $http = HttpClient::baseUrl($this->baseUrl)
            ->post('people/v2/people', $this->mapToPco());

        $response = new ClientResponse($http);
        $this->mapFromPco($http->json('data'));
        $response->data = $this->attributes;

        return $response;
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

    private function mapFromPco(stdClass $pco): void
    {
        $this->id = $pco->data->id;
        $this->attributes->personId = $pco->data->id;
        $this->attributes->firstName = $pco->data->attributes->first_name;
        $this->attributes->middleName = $pco->data->attributes->middle_name;
        $this->attributes->lastName = $pco->data->attributes->last_name;
        $this->attributes->birthdate = $pco->data->attributes->birthdate;
        $this->attributes->anniversary = $pco->data->attributes->anniversary;
    }

    private function mapToPco(): array
    {
        $person = [
            'id' => $this->attributes->personId,
            'first_name' => $this->attributes->firstName,
            'middle_name' => $this->attributes->middleName,
            'last_name' => $this->attributes->lastName,
            'birthdate' => $this->attributes->birthdate,
            'anniversary' => $this->attributes->anniversary,
            'gender' => $this->attributes->gender,
            'grade' => $this->attributes->grade,
            'child' => $this->attributes->child,
            'graduation_year' => $this->attributes->graduationYear,
            'site_administrator' => $this->attributes->siteAdministrator,
            'accounting_administrator' => $this->attributes->accountingAdministrator,
            'people_permissions' => $this->attributes->peoplePermissions,
            'membership' => $this->attributes->membership,
            'inactivated_at' => $this->attributes->inactivatedAt,
            'medical_notes' => $this->attributes->medicalNotes,
            'mfa_configured' => $this->attributes->mfaConfigured,
            'created_at' => $this->attributes->createdAt,
            'updated_at' => $this->attributes->updatedAt,
            'avatar' => $this->attributes->avatar,
            'name' => $this->attributes->name,
            'demographic_avatar_url' => $this->attributes->demographicAvatarUrl,
            'directory_status' => $this->attributes->directoryStatus,
            'passed_background_check' => $this->attributes->passedBackgroundCheck,
            'can_create_forms' => $this->attributes->canCreateForms,
            'can_email_lists' => $this->attributes->canEmailLists,
            'school_type' => $this->attributes->schoolType,
            'status' => $this->attributes->status,
            'primary_campus_id' => $this->attributes->primaryCampusId,
            'remote_id' => $this->attributes->remoteId,
        ];

        unset($person['id']);
        unset($person['created_at']);
        unset($person['updated_at']);
        unset($person['name']);
        unset($person['demographic_avatar_url']);

        return $person;
    }
}
