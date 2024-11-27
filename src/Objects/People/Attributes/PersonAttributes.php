<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People\Attributes;

use Illuminate\Support\Carbon;

class PersonAttributes
{
    public string $personId;
    public ?string $givenName;
    public ?string $firstName;
    public ?string $nickname;
    public ?string $middleName;
    public ?string $lastName;
    public ?Carbon $birthdate;
    public ?Carbon $anniversary;
    public ?string $gender;
    public ?int $grade;
    public ?bool $child;
    public ?int $graduationYear;
    public ?bool $siteAdministrator;
    public ?bool $accountingAdministrator;
    public ?string $peoplePermissions;
    public ?string $membership;
    public ?Carbon $inactivatedAt;
    public ?string $medicalNotes;
    public ?bool $mfaConfigured;
    public ?Carbon $createdAt;
    public ?Carbon $updatedAt;
    public ?string $avatar;
    public ?string $name;
    public ?string $demographicAvatarUrl;
    public ?string $directoryStatus;
    public ?bool $passedBackgroundCheck;
    public ?bool $canCreateForms;
    public ?bool $canEmailLists;
    public ?string $schoolType;
    public ?string $status;
    public ?int $primaryCampusId;
    public ?int $remoteId;
}
