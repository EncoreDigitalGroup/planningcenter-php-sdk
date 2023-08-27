<?php
namespace EncoreDigitalGroup\PlanningCenter;

class Client
{
    public $config;
    
    public function configure($config = [])
    {
        return array_merge(
            [
                'calendar' => [
                    'apiVersion' => '2021-07-20',
                ]
            ], $config);
    }
}

