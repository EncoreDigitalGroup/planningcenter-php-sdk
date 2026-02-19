# Webhook Subscriptions

### All Webhook Subscriptions

To get all webhook subscriptions in Planning Center:

```php
$subscriptions = PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)
    ->webhooks()
    ->all();

foreach ($subscriptions->items() as $subscription) {
    echo $subscription->name();
}
```

### Get a Specific Webhook Subscription

To get a single webhook subscription, chain `withId()` and `get()`:

```php
$subscription = PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)
    ->webhooks()
    ->webhookSubscription()
    ->withId('123')
    ->get();
```

### Create a Webhook Subscription

To create a new webhook subscription, set the name and url using fluent setters and call `save()`:

```php
$subscription = PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)
    ->webhooks()
    ->webhookSubscription()
    ->withName('events.v2.events.created')
    ->withUrl('https://example.com/webhooks')
    ->save();
```

You can also set the webhook subscription to be active or inactive upon creation:

```php
$subscription = PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)
    ->webhooks()
    ->webhookSubscription()
    ->withName('events.v2.events.created')
    ->withUrl('https://example.com/webhooks')
    ->withActive(true)
    ->save();
```

> The name field represents the event you want to subscribe to. Planning Center uses a naming convention
> of `{app}.v2.{resource}.{action}` for webhook event names.

### Update a Webhook Subscription

Only the `active` attribute can be updated on an existing webhook subscription:

```php
PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)
    ->webhooks()
    ->webhookSubscription()
    ->withId('123')
    ->withActive(false)
    ->save();
```

> The name and url fields cannot be changed after a webhook subscription has been created.

### Delete a Webhook Subscription

To delete a webhook subscription, provide the ID and call `delete()`:

```php
PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)
    ->webhooks()
    ->webhookSubscription()
    ->withId('123')
    ->delete();
```

### Rotate Authenticity Secret

Webhook subscriptions include an authenticity secret used to verify that incoming webhooks are from
Planning Center. To rotate this secret:

```php
$subscription = PlanningCenter::make()
    ->withBasicAuth($clientId, $clientSecret)
    ->webhooks()
    ->webhookSubscription()
    ->withId('123')
    ->get();

$subscription->rotateSecret();

// The subscription is automatically refreshed — access the new secret immediately
echo $subscription->authenticitySecret();
```

### Attributes

When retrieving webhook subscriptions, the following attributes are available:

| Method                  | Type               | Description                                           |
|-------------------------|--------------------|-------------------------------------------------------|
| `id()`                  | `?string`          | Unique identifier (read-only)                         |
| `active()`              | `?bool`            | Whether the webhook subscription is active            |
| `applicationId()`       | `?string`          | The ID of the application that owns this subscription (read-only) |
| `authenticitySecret()`  | `?string`          | The secret used to verify webhook authenticity (read-only) |
| `name()`                | `?string`          | The event name this subscription listens for          |
| `url()`                 | `?string`          | The URL where webhooks will be sent                   |
| `createdAt()`           | `?CarbonImmutable` | When the webhook subscription was created (read-only) |
| `updatedAt()`           | `?CarbonImmutable` | When the webhook subscription was last updated (read-only) |
