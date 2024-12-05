# Event

To start using the Calendar Event API, add the following to the top of your file:

```php
use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Event;
```

### Event Class

Now we can create a new instance of the Event class;

```php
$event = Event::make($clientId, $clientSecret);
```

### All Events

To get all calendar events that exist in Planning Center, use the following method:

```php
$event->all();
```

### Future Events

To modify the Planning Center API Query, you can pass an argument to the ```all()``` method.

```php
$query = [
    'filter' => 'future'
];

$event->all($query);
```

Specifically for Future Calendar Events, we have created a method that applies this query
modification for you automatically.

```php
$event->future();
```

### Get an Event

To get a single Planning Center Calendar Event, use the `forEventId()` method and then chain the `get()`
method.

```php
$event->forEventId(YOUR_EVENT_ID)->get();
```

### Get Event Instances

```php
$event->forEventId(YOUR_EVENT_ID)->instances();
```

### Get a Single Event Instance

```php
$eventInstance = EventInstance::make($clientId, $clientSecret);
$eventInstance->forEventInstanceId(YOUR_EVENT_INSTANCE_ID)->get();
```