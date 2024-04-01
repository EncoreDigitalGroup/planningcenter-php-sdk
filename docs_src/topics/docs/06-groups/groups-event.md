# Group Events
To start using the Group Events API, add the following to the top of your file:
```php
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Event;
```
<include from="SnippetLibrary.md" element-id="setupThePcoClient"></include>

### Group Class
Now we can create a new instance of the Group class;
```php
$groupEvent = new Event($clientConfig);
```

### All Groups
To get all group events that exist in Planning Center, use the following method:
```php
$groupEvent->all();
```

### Get Events for a Specific Group

To get events for a specific group, set the  ```$groupId``` property to the ```id``` of the specific
group you wish to retrieve events for.
```php
$groupEvent->groupId = 123;
$groupEvent->all();
```

### Get a Specific Group Event

To get specific group event, set the  ```$eventId``` property to the ```id``` of the specific
group event you wish to retrieve.
```php
$groupEvent->eventId = 123;
$groupEvent->get();
```