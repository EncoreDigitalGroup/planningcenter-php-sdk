# Groups

To start using the Groups API, add the following to the top of your file:

```php
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Group;
```

### Group Class

Now we can create a new instance of the Group class;

```php
$group = Group::make($clientId, $clientSecret);
```

### All Groups

To get all groups that exist in Planning Center, use the following method:

```php
$group->all();
```

### Get a Specific Group

To get a single Planning Center Group, use the `forGroupId()` method and then chain the `get()` method.

```php
$group->forGroupId(YOUR_GROUP_ID)->get();
```