# Tag Groups

### Get a Specific Tag Group

To get a single groups tag group, chain `withId()` and `get()`:

```php
$tagGroup = PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)
    ->groups()
    ->groupTagGroup()
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
