# TagGroup
To start using the Calendar TagGroup API, add the following to the top of your file:
```php
use EncoreDigitalGroup\PlanningCenter\Objects\Calendar\TagGroup;
```
<include from="SnippetLibrary.md" element-id="setupThePcoClient"></include>

### TagGroup Class
Now we can create a new instance of the TagGroup class;
```php
$TagGroup = new TagGroup($PlanningCenterClientConfiguration);
```

### All Tag Groups
To get all calendar tag groups that exist in Planning Center, use the following method:
```php
$TagGroup->all();
```

# Tags

### Get All Tags in Tag Group
To get all tags in a tag group, pass the ```id``` of the tag group to the ```tag()``` method
```php
$TagGroup->tag($id);
```

### Get a Single Tag in a Tag Group
To get a single tag in a tag group, pass the ```id``` of the tag as the second argument to the ```tag()``` method
```php
$TagGroup->tag($id, $tag_id);
```
When ```$tag_id``` is not included, this tells the SDK that you want all tags in the tag group.
When ```$tag_id``` is included, the SDK will return only the tag from the tag group you requested.
