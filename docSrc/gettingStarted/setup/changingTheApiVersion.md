# Changing the API Version

The PlanningCenterClient allows you to change the Planning Center API Version. Planning Center has its own method of
setting the default API version that your application will use. We have defined default API versions to support this
SDK better. They are listed below:

<list>
<li>PCO Calendar: 2021-07-20</li>
<li>PCO Groups: 2023-07-10</li>
<li>PCO People: 2023-02-15</li>
</list>

To change the API Version that the SDK will use, use the following methods:
```php
$clientConfig->setCalendarApiVersion('2021-07-20');
$clientConfig->setGroupsApiVersion('2023-07-10');
$clientConfig->setPeopleApiVersion('2023-02-15');
```

These methods are only required if you wish to change the version of the Planning Center API your application uses.
To revert the default, simply don't pass a value into any one of these methods.

```php
$clientConfig->setCalendarApiVersion();
$clientConfig->setGroupsApiVersion();
$clientConfig->setPeopleApiVersion();
```