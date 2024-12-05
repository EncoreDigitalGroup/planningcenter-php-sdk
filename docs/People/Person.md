# Email

To start using the Person API, add the following to the top of your file:

```php
use EncoreDigitalGroup\PlanningCenter\Objects\People\Person;
```

### Person Class

Now we can create a new instance of the Person class;

```php
$person = Person::make($clientId, $clientSecret);
```

### All People

To get all people that exist in Planning Center, use the following method:

```php
$person->all();
```

# Person

### Get a Specific Person

To get a single Person from Planning Center, use the `forPersonId()` method and then chain the `get()`
method.

```php
$person->forPersonId(PERSON_ID)->get();
```

### Create a new Person

To create a new Person, you must set the first and last name of the Person.

```php
$person->attributes->firstName = "John";
$person->attributes->lastName = "Smith";
$person->create();
```

<note>You can pass more than just the first and last name fields when creating a new Person.
This is just the minimum requirement.</note>

### Update a Person

To update an already existing person, you will need the ID of the person you wish to update.
For example, let's say that when we created John Smith in the previous section, we realized later that his name
is spelled Jon and not John. Let's assume that his Person ID is 123.

```PHP
$person->attributes->firstName = "Jon";
$person->forPersonId("123")->update();
```

<note>Except for the ID, you only need to pass fields that are being updated.</note>

### Delete a Person

To delete a person from planning center, you just need to pass in the ID.

```PHP
$person->forPersonId("123")->delete();
```

Note: There is no way to recover a person once they have been deleted in Planning Center.
The Planning Center UI asks you to confirm that you wish to do this; no such step exists via the API.