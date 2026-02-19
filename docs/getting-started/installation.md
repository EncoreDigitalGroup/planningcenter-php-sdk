# Installation via Composer

To install this package in your project, use the following composer command:

```bash
composer require encoredigitalgroup/planningcenter-php-sdk
```

Once composer has installed the SDK, require the composer autoloader in your project:

```php
require 'vendor/autoload.php';
```

## Initialization

All interactions with the SDK go through the `PlanningCenter` entry point. Before accessing any module,
you must authenticate using either Basic Auth or an OAuth token.

### Basic Auth

```php
use EncoreDigitalGroup\PlanningCenter\PlanningCenter;

$pco = PlanningCenter::make()->withBasicAuth($clientId, $clientSecret);
```

### OAuth Token

```php
use EncoreDigitalGroup\PlanningCenter\PlanningCenter;

$pco = PlanningCenter::make()->withToken($token);
```

Once authenticated, you can access any module:

```php
$pco->people();
$pco->groups();
$pco->calendar();
$pco->webhooks();
```