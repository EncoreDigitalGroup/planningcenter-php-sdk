# TagGroup

> The Calendar module is read-only. Tag groups cannot be created, updated, or deleted via the API.

### Get a Specific Tag Group

To get a single calendar tag group, chain `withId()` and `get()`:

```php
$tagGroup = PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)
    ->calendar()
    ->tagGroup()
    ->withId('123')
    ->get();
```

# Tags

### Get All Tags in a Tag Group

Tags are available as a relationship on the TagGroup resource:

```php
$tags = $tagGroup->tags();

foreach ($tags->items() as $tag) {
    echo $tag->name();
}
```
