# paginateApi
# A paginator that gives a better simple response.

This package adds a `paginateApi` method to the Eloquent query builder that listens to those parameters and also allows you to use offset and limit from a request. Example www.dlabs.cloud?limit=20&offset=10

## Installation

You can install the package via composer:

```bash
composer require dlabs/laravel-paginate-api
```


## Usage

To paginate the results according to use limit and offset, simply call the `paginateApi` method.

If you are not using the url as like this?
```php
www.dlabs.cloud?limit=20&offset=10
```

Of course you may also still use all the builder methods you know and love:

```php
YourModel::where('my_field', 'myValue')->paginateApi();
```

By default the maximum page size is set to 20, but you can update it by passing your desired items per page

```php
YourModel::where('my_field', 'myValue')->paginateApi(30);
```
Apparently the *paginateApi* method can take in below in 
```php
$perPage = 20, 
$offset = 0, 
$columns = ['*'], 
array $options = []

YourModel::paginateApi($perPage = 20, $offset = 0, $columns = ['*'], array $options = [])
```
### Response
Here is a clear simple response you will get.

    {
      "data": [
        {
          "id": 3,
          "status": "ACTIVE",
          "name": "Camden",
          "code": "ROLE01296",
          "identifier": "2655707720",
          "client_id": 1,
          "created_at": "2020-04-12T19:16:43.000000Z",
          "updated_at": "2020-04-12T19:16:43.000000Z"
        },
        {
          "id": 4,
          "status": "ACTIVE",
          "name": "Emory",
          "code": "ROLE01297",
          "identifier": "82386335018501",
          "client_id": 1,
          "created_at": "2020-04-12T19:16:43.000000Z",
          "updated_at": "2020-04-12T19:16:43.000000Z"
        }
      ],
      "offset": 2,
      "limit": 10,
      "count": 4
    }

## Testing
Really for now we do not even have a test, but we push one ASAP. Nice if you can help


## Credits

- All the guys at dlabs.cloud 🇳🇬


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
