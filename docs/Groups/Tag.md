# Tags

To start using the Group Tags API, add the following to the top of your file:

```php
use EncoreDigitalGroup\PlanningCenter\Objects\Groups\Tag;
```

### TagGroup Class

Now we can create a new instance of the Tag class;

```php
$tag = Tag::make($clientId, $clientSecret);
```

# Tags

### Get All Tags

```php
$tag->all();
```

### Get Tags for a Group

```php
$tag->forGroupId(TAG_ID)->groups();
```