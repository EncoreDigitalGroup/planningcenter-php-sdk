<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People;

use EncoreDigitalGroup\PlanningCenter\Objects\People\Attributes\PersonAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use Illuminate\Support\Arr;
use PHPGenesis\Http\HttpClient;
use stdClass;

class Person
{
    use HasPlanningCenterClient;

    public int|string|null $id;
    public ?PersonAttributes $attributes;

    public function all(?array $query = null): ClientResponse
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

    public function get(?array $query = null): ClientResponse
    {
        $http = HttpClient::baseUrl($this->baseUrl)
            ->get('people/v2/people/' . $this->id, $query);

        $response = new ClientResponse($http);
        $this->mapFromPco($http->json('data'));
        $response->data = $this->attributes;

        return $response;
    }

    public function create(): ClientResponse
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
        $http = HttpClient::patch('people/v2/people/' . $this->id, $this->mapToPco());

        $response = new ClientResponse($http);
        $this->mapFromPco($http->json('data'));
        $response->data = $this->attributes;

        return $response;
    }

    public function delete(): ClientResponse
    {
        $http = HttpClient::delete('people/v2/people/' . $this->id);

        $response = new ClientResponse($http);
        $this->mapFromPco($http->json('data'));
        $response->data = $this->attributes;

        return $response;
    }

    public function email(): ClientResponse
    {
        $email = new Email($this->client);
        $email->personId = $this->id;

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
        $this->attributes->gender = $pco->data->attributes->gender;
        $this->attributes->grade = $pco->data->attributes->grade;
        $this->attributes->child = $pco->data->attributes->child;
        $this->attributes->graduationYear = $pco->data->attributes->graduation_year;
        $this->attributes->siteAdministrator = $pco->data->attributes->site_administrator;
        $this->attributes->accountingAdministrator = $pco->data->attributes->accounting_administrator;
        $this->attributes->peoplePermissions = $pco->data->attributes->people_permissions;
        $this->attributes->membership = $pco->data->attributes->membership;
        $this->attributes->inactivatedAt = $pco->data->attributes->inactivated_at;
        $this->attributes->medicalNotes = $pco->data->attributes->medical_notes;
        $this->attributes->mfaConfigured = $pco->data->attributes->mfa_configured;
        $this->attributes->createdAt = $pco->data->attributes->created_at;
        $this->attributes->updatedAt = $pco->data->attributes->updated_at;
        $this->attributes->avatar = $pco->data->attributes->avatar;
        $this->attributes->name = $pco->data->attributes->name;
        $this->attributes->demographicAvatarUrl = $pco->data->attributes->demographic_avatar_url;
        $this->attributes->directoryStatus = $pco->data->attributes->directory_status;
        $this->attributes->passedBackgroundCheck = $pco->data->attributes->passed_background_check;
        $this->attributes->canCreateForms = $pco->data->attributes->can_create_forms;
        $this->attributes->canEmailLists = $pco->data->attributes->can_email_lists;
        $this->attributes->schoolType = $pco->data->attributes->school_type;
        $this->attributes->status = $pco->data->attributes->status;
        $this->attributes->primaryCampusId = $pco->data->attributes->primary_campus_id;
        $this->attributes->remoteId = $pco->data->attributes->remote_id;
    }

    private function mapToPco(): array
    {
        $person = [
            'id' => $this->attributes->personId ?? null,
            'first_name' => $this->attributes->firstName ?? null,
            'middle_name' => $this->attributes->middleName ?? null,
            'last_name' => $this->attributes->lastName ?? null,
            'birthdate' => $this->attributes->birthdate ?? null,
            'anniversary' => $this->attributes->anniversary ?? null,
            'gender' => $this->attributes->gender ?? null,
            'grade' => $this->attributes->grade ?? null,
            'child' => $this->attributes->child ?? null,
            'graduation_year' => $this->attributes->graduationYear ?? null,
            'site_administrator' => $this->attributes->siteAdministrator ?? null,
            'accounting_administrator' => $this->attributes->accountingAdministrator ?? null,
            'people_permissions' => $this->attributes->peoplePermissions ?? null,
            'membership' => $this->attributes->membership ?? null,
            'inactivated_at' => $this->attributes->inactivatedAt ?? null,
            'medical_notes' => $this->attributes->medicalNotes ?? null,
            'mfa_configured' => $this->attributes->mfaConfigured ?? null,
            'created_at' => $this->attributes->createdAt ?? null,
            'updated_at' => $this->attributes->updatedAt ?? null,
            'avatar' => $this->attributes->avatar ?? null,
            'name' => $this->attributes->name ?? null,
            'demographic_avatar_url' => $this->attributes->demographicAvatarUrl ?? null,
            'directory_status' => $this->attributes->directoryStatus ?? null,
            'passed_background_check' => $this->attributes->passedBackgroundCheck ?? null,
            'can_create_forms' => $this->attributes->canCreateForms ?? null,
            'can_email_lists' => $this->attributes->canEmailLists ?? null,
            'school_type' => $this->attributes->schoolType ?? null,
            'status' => $this->attributes->status ?? null,
            'primary_campus_id' => $this->attributes->primaryCampusId ?? null,
            'remote_id' => $this->attributes->remoteId ?? null,
        ];

        unset($person['id']);
        unset($person['created_at']);
        unset($person['updated_at']);
        unset($person['name']);
        unset($person['demographic_avatar_url']);

        return Arr::whereNotNull($person);
    }
}
