# Person
To start using the Person API, add the following to the top of your file:
```php
use EncoreDigitalGroup\PlanningCenter\People\Person;
```
<include from="SnippetLibrary.md" element-id="setupThePcoClient"></include>

### Person Class
Now we can create a new instance of the Person class;
```php
$Person = new Person;
```

### All People
To get all people that exist in Planning Center, use the following method:
```php
Person::all($PCOClient);
```

# Person

### Get a Specific Person
To get a specific person, pass the ```$Person``` object created earlier with ```$Person->id``` set to the ```id``` of the specific person you want.
```php
$Person->id = 123;
Person::get($PCOClient, $Person);
```

### Create a new Person
To create a new Person, you must set the first and last name of the Person.
```php
$Person->first_name = 'John';
$Person->last_name = 'Smith';
Person::create($PCOClient, $Person);
```
<note>You can pass more than just the first and last name fields when creating a new Person. This is just the minimum requirement.</note>

### Update a Person
To update an already existing person, you will need the ID of the person you wish to update. For example, let's say that when we created
John Smith in the previous section, we realized later that his name is spelled Jon and not John. Let's assume that his Person ID is 123.
```PHP
$Person->id = 123;
$Person->first_name = 'Jon';
Person::update($PCOClient, $Person);
```
<note>Except for the ID, you only need to pass fields that are being updated.</note>

### Delete a Person
To delete a person from planning center, you just need to pass in the ID.
```PHP
$Person->id = 123;
Person::delete($PCOClient, $Person);
```
<warning>There is no way to recover a person once they have been deleted in Planning Center.
The Planning Center UI asks you to confirm that you wish to do this; no such step exists via the API.</warning>