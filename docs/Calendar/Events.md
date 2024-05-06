# Event

To start using the Calendar Event API, add the following to the top of your file:

```php
use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Event;
```

<include from="SnippetLibrary.md" element-id="setupThePcoClient"></include>

### Event Class

Now we can create a new instance of the Event class;

```php
$event = new Event($client);
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

To get a single Planning Center Calendar Event, pass the ```id``` of the event to the ```get()```
method

```php
$event->eventId = YOUR_EVENT_ID;
$event->get();
```

### Get Event Instances

```php
$event->eventId = YOUR_EVENT_ID;
$event->instances();
```

### Get a Single Event Instance

```php
$event->eventId = YOUR_EVENT_ID;
$event->eventInstanceId = YOUR_EVENT_INSTANCE_ID;
$event->instance();
```

### Get a Single Event Connection

```php
$event->eventId = YOUR_EVENT_ID;
$event->connectionId = YOUR_CONNECTION_ID;
$event->connection();
```