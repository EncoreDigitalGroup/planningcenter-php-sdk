# Set up the Client

At the top of your file, add the following code:

```php
use EncoreDigitalGroup\PlanningCenter\PlanningCenterClient;
use EncoreDigitalGroup\PlanningCenter\ClientConfiguration;
```

The first thing we need to do is to create an instance of `ClientConfiguration`.

```php
$clientConfig = new ClientConfiguration();
```

To authenticate to the Planning Center API, you need to configure the client with an access token.

```php

$clientConfig->setAuthorizationType('Basic');
$clientConfig->setAuthorizationToken('PCO_APPLICATION_ID:PCO_APPLICATION_SECRET');
```

Currently, the client only supports Basic Authentication, but OAuth Authentication is on the roadmap. Once released, this documentation will reflect that.

Now we can create the PlanningCenterClient like so:

```php
$client = new PlanningCenterClient($clientConfig);
```

In the event that the API returns an error, the client will retry the request up to 5 times for a grand total of 6 requests. After the 6th request, the client will return
the error to your application.