# Tag Groups

To start using the Groups Tag Group API, add the following to the top of your file:

```php
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\TagGroup;
```

### TagGroup Class

Now we can create a new instance of the TagGroup class;

```php
$tagGroup = TagGroup::make($clientId, $clientSecret);
```

### All Tag Groups

To get all groups tag groups that exist in Planning Center, use the following method:

```php
$tagGroup->all();
```

# Tags

### Get All Tags in Tag Group

```php
$tagGroup->forTagGroupId(TAG_GROUP_ID)->tags();
```