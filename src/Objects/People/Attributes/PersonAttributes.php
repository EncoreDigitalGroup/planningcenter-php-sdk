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
    public ?string $givenName = null;
    public ?string $firstName = null;
    public ?string $nickname = null;
    public ?string $middleName = null;
    public ?string $lastName = null;
    public ?Carbon $birthdate = null;
    public ?Carbon $anniversary = null;
    public ?string $gender = null;
    public ?int $grade = null;
    public ?bool $child = null;
    public ?int $graduationYear = null;
    public ?bool $siteAdministrator = null;
    public ?bool $accountingAdministrator = null;
    public ?string $peoplePermissions = null;
    public ?string $membership = null;
    public ?Carbon $inactivatedAt = null;
    public ?string $medicalNotes = null;
    public ?bool $mfaConfigured = null;
    public ?Carbon $createdAt = null;
    public ?Carbon $updatedAt = null;
    public ?string $avatar = null;
    public ?string $name = null;
    public ?string $demographicAvatarUrl = null;
    public ?string $directoryStatus = null;
    public ?bool $passedBackgroundCheck = null;
    public ?bool $canCreateForms = null;
    public ?bool $canEmailLists = null;
    public ?string $schoolType = null;
    public ?string $status = null;
    public ?int $primaryCampusId = null;
    public ?int $remoteId = null;
}
