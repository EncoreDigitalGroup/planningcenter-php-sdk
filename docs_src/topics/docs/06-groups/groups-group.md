# Groups
To start using the Groups API, add the following to the top of your file:
```php
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Group;
```
<include from="SnippetLibrary.md" element-id="setupThePcoClient"></include>

### Group Class
Now we can create a new instance of the Group class;
```php
$group = new Group($clientConfig);
```

### All Groups
To get all groups that exist in Planning Center, use the following method:
```php
$group->all();
```

### Get a Specific Group

To get a specific group, set the  ```$groupId``` property to the ```id``` of the specific group you wish to retrieve.
```php
$group->groupId = 123;
$group->get();
```