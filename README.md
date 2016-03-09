TradeSmarter platform API Client
====

This repository contains PHP Client for TradeSmarter platform.

TradeSmarter is a trading platform for binary options.

## Installation
Install using [Composer](http://getcomposer.org), doubtless.

```sh
$ composer require alexander-emelyanov/tradesmarter-api-client
```

## Usage

First, you need to create a client object to connect to the TradeSmarter servers. You will need to acquire an API username and API password for your app first from broker, then pass the credentials to the client object for logging in. 

```php
$client = new \TradeSmarter\ApiClient("https://<username>:<password>@<hostname>");
```

Assuming your credentials is valid, you are good to go!

### Get countries list

```php
/** @var \TradeSmarter\Responses\Country[] $countries */
$countries = $client->countries();
```

### Register new customer

```php
$request = new TradeSmarter\Request\Register([
    'firstName' => 'Alexander',
    'lastName' => 'Emelyanov',
    'email' => md5(rand()) . '@gmail.com',
    'confirmed' => 1,
    'password' => md5('portal'),
    'phone' => '+79851984667',
    'country' => 'ru',
    'locale' => 'en-US',
    'params' => [],
    'lead' => 0,
]);

/** @var \TradeSmarter\Responses\Register $response */
$response = $client->register($request);
```

## Contribution
You are welcome!

### Running tests

You can run unit tests via [PHPUnit](http://phpunit.de):

```sh
$ vendor/bin/phpunit tests
```

Note: you should install dev dependencies for this package using 

```sh
$ composer update --dev
```
