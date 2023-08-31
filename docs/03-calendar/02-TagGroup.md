# TagGroup
To start using the Calendar TagGroup API, add the following to the top of your file:
```php
use EncoreDigitalGroup\PlanningCenter\Calendar\TagGroup;
```
## ***Before your continue***: *Did you setup the [PCOClient](../02-setup/01-Setup-the-PCOClient.md)*

### TagGroup Class
Now we can create a new instance of the TagGroup class;
```php
$TagGroup = new TagGroup;
```

### All Tag Groups
To get all calendar tag groups that exist in Planning Center, use the following method:
```php
$TagGroup->all($PCOClient);
```

### Get All Tags in Tag Group
To get all tags in a tag group, pass the ```id``` of the tag group as the second argument to the ```tag()``` method
```php
$TagGroup->tag($PCOClient, $id);
```

### Get a Single Tag in a Tag Group
To get a single tag in a tag group, pass the ```id``` of the tag as the third argument to the ```tag()``` method
```php
$TagGroup->tag($PCOClient, $id, $tag_id);
```
When ```$tag_id``` is not included, this tells the SDK that you want all tags in the tag group. When ```$tag_id``` is included, the SDK will return only the tag from the tag group you requested. As always, the final argument for this method is the query modifier array.
