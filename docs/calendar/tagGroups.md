# TagGroup

To start using the Calendar TagGroup API, add the following to the top of your file:

```php
use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\TagGroup;
```

<include from="SnippetLibrary.md" element-id="setupThePcoClient"></include>

### TagGroup Class

Now we can create a new instance of the TagGroup class;

```php
$tagGroup = new TagGroup($client);
```

### All Tag Groups

To get all calendar tag groups that exist in Planning Center, use the following method:

```php
$tagGroup->all();
```

# Tags

### Get All Tags in Tag Group

```php
$tagGroup->tagGroupId = TAG_GROUP_ID;
$tagGroup->tags();
```

### Get a Single Tag in a Tag Group

```php
$tagGroup->tagGroupId = TAG_GROUP_ID;
$tagGroup->tagId = TAG_ID
$tagGroup->tag();
```