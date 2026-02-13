# Webhook Subscriptions

To start using the Webhooks API, add the following to the top of your file:

```php
use EncoreDigitalGroup\PlanningCenter\Objects\Webhooks\WebhookSubscription;
```

### WebhookSubscription Class

Now we can create a new instance of the WebhookSubscription class;

```php
$webhookSubscription = WebhookSubscription::make($clientId, $clientSecret);
```

### All Webhook Subscriptions

To get all webhook subscriptions that exist in Planning Center, use the following method:

```php
$webhookSubscription->all();
```

### Get a Specific Webhook Subscription

To get a single webhook subscription from Planning Center, use the `forWebhookSubscriptionId()` method and then chain the `get()` method.

```php
$webhookSubscription->forWebhookSubscriptionId(YOUR_WEBHOOK_SUBSCRIPTION_ID)->get();
```

### Create a Webhook Subscription

To create a new webhook subscription, you must set the name and url.

```php
$webhookSubscription->attributes->name = "events.v2.events.created";
$webhookSubscription->attributes->url = "https://example.com/webhooks";
$webhookSubscription->create();
```

You can also set the webhook subscription to be active or inactive upon creation:

```php
$webhookSubscription->attributes->name = "events.v2.events.created";
$webhookSubscription->attributes->url = "https://example.com/webhooks";
$webhookSubscription->attributes->active = true;
$webhookSubscription->create();
```

<note>The name field represents the event you want to subscribe to. Planning Center uses a naming convention
of `{app}.v2.{resource}.{action}` for webhook event names.</note>

### Update a Webhook Subscription

To update an already existing webhook subscription, you will need the ID of the subscription you wish to update.
Only the `active` attribute can be updated on an existing webhook subscription.

```php
$webhookSubscription->attributes->active = false;
$webhookSubscription->forWebhookSubscriptionId("123")->update();
```

<note>The name and url fields cannot be changed after a webhook subscription has been created.</note>

### Delete a Webhook Subscription

To delete a webhook subscription from Planning Center, you just need to pass in the ID.

```php
$webhookSubscription->forWebhookSubscriptionId("123")->delete();
```

### Rotate Authenticity Secret

Webhook subscriptions include an authenticity secret that is used to verify that incoming webhooks
are actually from Planning Center. If you need to rotate this secret, use the following method:

```php
$webhookSubscription->forWebhookSubscriptionId("123")->rotateSecret();
```

<note>After rotating the secret, you will need to retrieve the webhook subscription again to get
the new authenticity secret value.</note>

### Attributes

When retrieving webhook subscriptions, the following attributes are available:

| Attribute             | Type   | Description                                           |
|-----------------------|--------|-------------------------------------------------------|
| webhookSubscriptionId | string | The unique identifier for the webhook subscription    |
| active                | bool   | Whether the webhook subscription is active            |
| applicationId         | string | The ID of the application that owns this subscription |
| authenticitySecret    | string | The secret used to verify webhook authenticity        |
| createdAt             | Carbon | When the webhook subscription was created             |
| name                  | string | The event name this subscription listens for          |
| updatedAt             | Carbon | When the webhook subscription was last updated        |
| url                   | string | The URL where webhooks will be sent                   |
