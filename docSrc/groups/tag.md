# Tags

To start using the Group Tags API, add the following to the top of your file:

```php
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Tag;
```

### TagGroup Class

Now we can create a new instance of the Tag class;

```php
$tag = new Tag($client);
```

### All Tag Groups

To get all group tags that exist in Planning Center, use the following method:

```php
$tag->all();
```

# Tags

### Get All Tags

```php
$tag->all();
```

### Get a Single Tag

```php
$tag->tagId = TAG_ID;
$tag->get();
```

### Get Groups by Tag

```php
$tag->tagId = TAG_ID;
$tag->groups();
```