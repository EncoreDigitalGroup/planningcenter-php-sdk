<?php
/*
 * Encore Digital Group - Planning Center PHP SDK
 * Copyright (c) 2024. Encore Digital Group
 */

namespace EncoreDigitalGroup\PlanningCenter\Objects\People\Attributes;

use DateTime;
use Illuminate\Support\Carbon;

class PersonAttributes
{
    public int $personId;
    public ?string $givenName;
    public ?string $firstName;
    public ?string $nickname;
    public ?string $middleName;
    public ?string $lastName;
    public DateTime|Carbon|null $birthdate;
    public DateTime|Carbon|null $anniversary;
    public ?string $gender;
    public ?int $grade;
    public ?bool $child;
    public ?int $graduationYear;
    public ?bool $siteAdministrator;
    public ?bool $accountingAdministrator;
    public ?string $peoplePermissions;
    public ?string $membership;
    public DateTime|Carbon|null $inactivatedAt;
    public ?string $medicalNotes;
    public ?bool $mfaConfigured;
    public DateTime|Carbon|null $createdAt;
    public DateTime|Carbon|null $updatedAt;
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
