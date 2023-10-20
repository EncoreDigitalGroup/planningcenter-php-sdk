<?php

namespace EncoreDigitalGroup\PlanningCenter\People;

use DateTime;
use GuzzleHttp\Psr7\Request;

class Person
{
    public string $id;
    public $given_name;
    public string $first_name;
    public string $nickname;
    public string $middle_name;
    public string $last_name;
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
    public $primary_campus_id;
    public $gender_id;
    public $remote_id;
    
    public static function all($PCOClient, $query = [])
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['people']['apiVersion'],
        ];

        $query = http_build_query($query);
        $request = new Request('GET', 'people/v2/people?' . $query, $headers);

        return $PCOClient->send($request);
    }

    public static function get($PCOClient, self $person, $query = []): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['people']['apiVersion'],
        ];
        $query = http_build_query($query);
        $request = new Request('GET', 'people/v2/people/' . $person->id . '?' . $query, $headers);

        return $PCOClient->send($request);
    }
    
    public static function create($PCOClient, self $person): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['people']['apiVersion'],
        ];
        $request = new Request('POST', 'people/v2/people', $headers, json_encode($person));

        return $PCOClient->send($request);
    }

    public static function update($PCOClient, self $person): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['people']['apiVersion'],
        ];
        $request = new Request('PATCH', 'people/v2/people/' . $person->id, $headers, json_encode($person));

        return $PCOClient->send($request);
    }

    public static function delete($PCOClient, self $person): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['people']['apiVersion'],
        ];
        $request = new Request('DELETE', 'people/v2/people/' . $person->id, $headers, json_encode($person));

        return $PCOClient->send($request);
    }
    
    public static function emails($PCOClient, self $person): string
    {
        $config = $GLOBALS['pcoClientConfig'];
        $headers = [
            'Authorization' => $config['authorization'],
            'X-PCO-API-Version' => $config['people']['apiVersion'],
        ];
        $request = new Request('DELETE', 'people/v2/emails/' . $person->id . '/person', $headers, json_encode($person));

        return $PCOClient->send($request);
    }
}
