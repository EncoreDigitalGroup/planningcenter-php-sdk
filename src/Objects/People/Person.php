<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2023-2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People;

use EncoreDigitalGroup\PlanningCenter\Configuration\AuthorizationOptions;
use EncoreDigitalGroup\PlanningCenter\Configuration\ClientConfiguration;
use EncoreDigitalGroup\PlanningCenter\Objects\People\Attributes\PersonAttributes;
use EncoreDigitalGroup\PlanningCenter\Objects\SdkObjects\ClientResponse;
use EncoreDigitalGroup\PlanningCenter\PlanningCenterClient;
use EncoreDigitalGroup\PlanningCenter\Traits\HasPlanningCenterClient;
use Illuminate\Support\Arr;
use PHPGenesis\Common\Container\PhpGenesisContainer;
use PHPGenesis\Http\HttpClient;
use stdClass;

/** @api */
class Person
{
    use HasPlanningCenterClient;

    public int|string|null $id;
    public PersonAttributes $attributes;
    protected AuthorizationOptions $auth;

    public function __construct(?PlanningCenterClient $client = null)
    {
        $this->client = $client ?? new PlanningCenterClient();
        $this->attributes = new PersonAttributes();
        $this->auth = PhpGenesisContainer::getInstance()->get(ClientConfiguration::class)->authorization();
    }

    public function all(?array $query = null): ClientResponse
    {
        $http = HttpClient::withBasicAuth($this->auth->getClientId(), $this->auth->getClientSecret())
            ->get($this->client->getBaseUrl() . '/people/v2/people', $query);

        $clientResponse = new ClientResponse($http);
        $clientResponse->data = [];

        foreach ($http->json('data') as $person) {
            $p = new Person($this->client);
            $p->mapFromPco($person);
            $clientResponse->data[] = $p;
        }

        return $clientResponse;
    }

    public function get(?array $query = null): ClientResponse
    {
        $http = HttpClient::withBasicAuth($this->auth->getClientId(), $this->auth->getClientSecret())
            ->get($this->client->getBaseUrl() . '/people/v2/people/' . $this->id, $query);

        return $this->processResponse($http);
    }

    public function create(): ClientResponse
    {
        $http = HttpClient::withBasicAuth($this->auth->getClientId(), $this->auth->getClientSecret())
            ->post($this->client->getBaseUrl() . '/people/v2/people', $this->mapToPco());

        return $this->processResponse($http);
    }

    public function update(): ClientResponse
    {
        $http = HttpClient::withBasicAuth($this->auth->getClientId(), $this->auth->getClientSecret())
            ->patch($this->client->getBaseUrl() . '/people/v2/people/' . $this->id, $this->mapToPco());

        return $this->processResponse($http);
    }

    public function delete(): ClientResponse
    {
        $http = HttpClient::withBasicAuth($this->auth->getClientId(), $this->auth->getClientSecret())
            ->delete($this->client->getBaseUrl() . '/people/v2/people/' . $this->id);

        return $this->processResponse($http);
    }

    public function email(): ClientResponse
    {
        $email = new Email($this->client);
        $email->attributes->personId = $this->id;

        return $email->forPerson();
    }

    private function mapFromPco(array $pco): void
    {
        $pco = objectify($pco);

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
            'data' => [
                'attributes' => [
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
                ],
            ],
        ];

        unset($person['data']['attributes']['id']);
        unset($person['data']['attributes']['created_at']);
        unset($person['data']['attributes']['updated_at']);
        unset($person['data']['attributes']['name']);
        unset($person['data']['attributes']['demographic_avatar_url']);

        return Arr::whereNotNull($person['data']['attributes']);
    }
}
