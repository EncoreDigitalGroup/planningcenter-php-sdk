# Changing the Planning Center API Version

The PCOClient allows you to change the Planning Center API Version. Planning Center has its own method of setting the default API version that your application will use. We have defined default API versions to support this SDK better. They are listed below:
<br />
* PCO Calendar: 2021-07-20
* PCO Groups: 2023-07-10
* PCO People: 2023-02-15
<br />

To change the API Version that the SDK will use, add to your configuration array like so:
```php
$PCOClient->configure([
    'authorization' => 'Basic PCO_APPLICATION_ID:PCO_APPLICATION_SECRET',
    'calendar' => [
        'apiVersion': 'DESIRED_API_VERSION'
    ],
    'groups' => [
        'apiVersion': 'DESIRED_API_VERSION'
    ],
    'people' => [
        'apiVersion': 'DESIRED_API_VERSION'
    ]
]);
```
Excluding any of the product or apiVersion array keys will configure the SDK to the default values.
<br />
<br />

Next: [Calendar](../03-calendar/README.md)
