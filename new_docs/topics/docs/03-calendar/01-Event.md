# Event
To start using the Calendar Event API, add the following to the top of your file:
```php
use EncoreDigitalGroup\PlanningCenter\Calendar\Event;
```
## ***Before your continue***: *Did you setup the [PCOClient](01-Setup-the-PCOClient.md)*

### Event Class
Now we can create a new instance of the Event class;
```php
$Event = new Event;
```

### All Events
To get all calendar events that exist in Planning Center, use the following method:
```php
$Event->all($PCOClient);
```

### Future Events
To modify the Planning Center API Query, you can pass a second argument to the ```all()``` method.
```php
$query = [
    'filter' => 'future'
];

$Event->all($PCOClient, $query);
```
<br />

Specifically for Future Calendar Events, we have created a method that applies this query modification for you automatically.
```php
$Event->future($PCOClient);
```
However, the final argument for any method in this SDK will be an array of query modifiers.

### Get an Event
To get a single Planning Center Calendar Event, pass the ```id``` of the event as the second argument to the ```get()``` method
```php
$Event->get($PCOClient, $id);
```

### Get Event Instances
To get all event instances, pass the ```id``` of the event as the second argument to the ```instance()``` method
```php
$Event->instance($PCOClient, $id);
```

### Get a Single Event Instance
To get a single event instances, pass the ```id``` of the event instance as the third argument to the ```instance()``` method
```php
$Event->instance($PCOClient, $id, $instance_id);
```
When ```$instance_id``` is not included, this tells the SDK that you want all event instances. When ```$instance_id``` is included, the SDK will return only the event instance you requested. As always, the final argument for this method is the query modifier array.

### Get Event Connections
To get all event connections, pass the ```id``` of the event as the second argument to the ```connection()``` method
```php
$Event->connection($PCOClient, $id);
```

### Get a Single Event Connection
To get a single event connection, pass the ```id``` of the event connection as the third argument to the ```connection()``` method
```php
$Event->connection($PCOClient, $id, $event_connection_id);
```
When ```$event_connection_id``` is not included, this tells the SDK that you want all event connection. When ```$event_connection_id``` is included, the SDK will return only the event connection you requested. As always, the final argument for this method is the query modifier array.
<br />
<br />

Next: [TagGroup](02-TagGroup.md)
