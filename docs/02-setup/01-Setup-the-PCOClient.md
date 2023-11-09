# Set up the PCOClient

At the top of your file, add the following code:

```php
use EncoreDigitalGroup\PlanningCenter\Client as PCOClient;
```
<br />

Now we can create the PCOClient like so:
```php
$PCOClient = new PCOClient;
```
<br />

To authenticate to the Planning Center API, you need to configure the client with an access token.

```php
$PCOClient->configure([
    'authorization' => 'Basic PCO_APPLICATION_ID:PCO_APPLICATION_SECRET'
]);
```
Currently, the client only supports Basic Authentication, but OAuth Authentication is on the roadmap. Once released, this documentation will reflect that.
<br />
<br />

***Note***: *In the event that the API returns an error, the client will retry the request up to 5 times for a grand total of 6 requests. After the 6th request, the client will return the error to your application.* 

*Helpful Hint: [How to Change the API Version](02-Change-the-API-Version.md)*
<br />
<br />
Next: [Calendar](../03-calendar/README.md)
