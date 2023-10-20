<?php

namespace EncoreDigitalGroup\PlanningCenter\People;

use DateTime;
use GuzzleHttp\Psr7\Request;
use JMS\Serializer\SerializerBuilder;

class Email
{
    public string $id;
    public string $address;
    public string $location;
    public bool $primary;
    public DateTime $created_at;
    public DateTime $updated_at;
    public bool $blocked;
}
