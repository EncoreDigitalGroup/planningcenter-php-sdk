# Groups

### All Groups

To get all groups in Planning Center:

```php
$groups = PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)
    ->groups()
    ->all();

foreach ($groups->items() as $group) {
    echo $group->name();
}
```

### Get a Specific Group

To get a single group, chain `withId()` and `get()`:

```php
$group = PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)
    ->groups()
    ->group()
    ->withId('123')
    ->get();
```

### Get Memberships for a Group

Memberships are available as a relationship on the Group resource:

```php
$memberships = $group->memberships();

foreach ($memberships->items() as $membership) {
    // ...
}
```

### Get Tags for a Group

Tags are available as a relationship on the Group resource:

```php
$tags = $group->tags();

foreach ($tags->items() as $tag) {
    echo $tag->name();
}
```
