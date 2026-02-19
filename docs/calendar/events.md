# Event

> The Calendar module is read-only. Events cannot be created, updated, or deleted via the API.

### All Events

To get all calendar events in Planning Center:

```php
$events = PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)
    ->calendar()
    ->all();

foreach ($events->items() as $event) {
    echo $event->name();
}
```

### Future Events

To filter for future events, pass a query parameter to `all()`:

```php
$events = PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)
    ->calendar()
    ->all(['filter' => 'future']);
```

### Get an Event

To get a single calendar event, chain `withId()` and `get()`:

```php
$event = PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)
    ->calendar()
    ->event()
    ->withId('123')
    ->get();
```

### Get Event Instances

Event instances are available as a relationship on the Event resource:

```php
$instances = $event->eventInstances();

foreach ($instances->items() as $instance) {
    echo $instance->startsAt();
}
```

### Get a Single Event Instance

```php
$instance = PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)
    ->calendar()
    ->eventInstance()
    ->withId('456')
    ->get();
```

### Get Tags for an Event

Tags are available as a relationship on the Event resource:

```php
$tags = $event->tags();

foreach ($tags->items() as $tag) {
    echo $tag->name();
}
```
