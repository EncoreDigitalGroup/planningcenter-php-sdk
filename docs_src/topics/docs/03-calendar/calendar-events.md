# Event
To start using the Calendar Event API, add the following to the top of your file:
```php
use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\Event;
```
<include from="SnippetLibrary.md" element-id="setupThePcoClient"></include>

### Event Class
Now we can create a new instance of the Event class;
```php
$Event = new Event($PlanningCenterClientConfiguration);
```

### All Events
To get all calendar events that exist in Planning Center, use the following method:
```php
$Event->all();
```

### Future Events
To modify the Planning Center API Query, you can pass an argument to the ```all()``` method.
```php
$query = [
    'filter' => 'future'
];

$Event->all($PCOClient, $query);
```

Specifically for Future Calendar Events, we have created a method that applies this query
modification for you automatically.
```php
$Event->future();
```


### Get an Event
To get a single Planning Center Calendar Event, pass the ```id``` of the event to the ```get()```
method
```php
$Event->get($id);
```

### Get Event Instances
To get all event instances, pass the ```id``` of the event to the ```instance()``` method
```php
$Event->instance($id);
```

### Get a Single Event Instance
To get a single event instances, pass the ```id``` of the event instance as the second argument to the ```instance()```
method
```php
$Event->instance($id, $instance_id);
```
When ```$instance_id``` is not included, this tells the SDK that you want all event instances.
When ```$instance_id``` is included, the SDK will return only the event instance you requested.

### Get Event Connections
To get all event connections, pass the ```id``` of the event to the ```connection()``` method.
```php
$Event->connection($id);
```

### Get a Single Event Connection
To get a single event connection, pass the ```id``` of the event connection as the second argument to the
```connection()``` method
```php
$Event->connection($id, $event_connection_id);
```
When ```$event_connection_id``` is not included, this tells the SDK that you want all event connection.
When ```$event_connection_id``` is included, the SDK will return only the event connection you requested.