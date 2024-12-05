# Group Events

To start using the Group Events API, add the following to the top of your file:

```php
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Event;
```

### Group Class

Now we can create a new instance of the Group class;

```php
$groupEvent = Event::make($clientId, $clientSecret);
```

### All Groups

To get all group events that exist in Planning Center, use the following method:

```php
$groupEvent->all();
```

### Get a Specific Group Event

To get a single Planning Center Group Event, use the `forEventId()` method and then chain the `get()`
method.

```php
$groupEvent->forEventId(YOUR_EVENT_ID)->get();
```