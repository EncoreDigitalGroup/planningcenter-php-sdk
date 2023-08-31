# Setup the PCOClient

At the top of your file, add the following code:

```php
use EncoreDigitalGroup\PlanningCenter\Client as PCOClient;
```
<br  />

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
