# Set up the PCOClient

At the top of your file, add the following code:

```php
use EncoreDigitalGroup\PlanningCenter\Client as PCOClient;
```
Now we can create the PCOClient like so:
```php
$PCOClient = new PCOClient;
```

To authenticate to the Planning Center API, you need to configure the client with an access token.

```php
$PCOClient->configure([
    'authorization' => 'Basic PCO_APPLICATION_ID:PCO_APPLICATION_SECRET'
]);
```
Currently, the client only supports Basic Authentication, but OAuth Authentication is on the roadmap. Once released, this documentation will reflect that.

<note>
In the event that the API returns an error, the client will retry the request up to 5 times for a grand total of 6 requests. After the 6th request, the client will return the error to your application. 
</note>

<tip><a href="02-Change-the-API-Version.md">How to change the API Version</a></tip>
