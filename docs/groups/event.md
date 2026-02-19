# Group Events

### Get a Specific Group Event

To get a single group event, chain `withId()` and `get()`:

```php
$groupEvent = PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)
    ->groups()
    ->groupEvent()
    ->withId('123')
    ->get();
```
