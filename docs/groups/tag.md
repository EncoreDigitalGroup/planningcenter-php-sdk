# Tags

### Get a Specific Tag

To get a single group tag, chain `withId()` and `get()`:

```php
$tag = PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)
    ->groups()
    ->groupTag()
    ->withId('123')
    ->get();
```

### Get Tags for a Group

Tags can also be retrieved as a relationship on the Group resource:

```php
$group = PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)
    ->groups()
    ->group()
    ->withId('456')
    ->get();

$tags = $group->tags();

foreach ($tags->items() as $tag) {
    echo $tag->name();
}
```
