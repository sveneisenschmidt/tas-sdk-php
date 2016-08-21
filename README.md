# trivago Affiliate Suite SDK for PHP

[![License](https://img.shields.io/badge/license-apache%202.0-lightgrey.svg)](https://github.com/trivago/tas-sdk-php/blob/master/LICENSE)
[![Build Status](https://travis-ci.org/trivago/tas-sdk-php.svg?branch=master)](https://travis-ci.org/trivago/tas-sdk-php)

## Installation

Require the sdk with composer:

```
composer require trivago/tas-sdk-php
```

## Quick Start

For a quick start please try out the example, which can be found in the /example folder and see the readme there.

## Usage

Here is a small code snippet that shows how to query locations.

```php
use Trivago\Tas\Config;

require_once __DIR__ . '/../vendor/autoload.php';

$config = new Config([
    Config::BASE_URL                 => 'https://api.trivago.com/webservice/tas',
    Config::ACCESS_ID                => 'Enter your Access-Id here',
    Config::SECRET_KEY               => 'Enter your Secret-Key here',
    Config::HTTP_HANDLER             => new \Trivago\Tas\HttpHandler\Curl(),
    Config::GET_TRACKING_ID_CALLBACK => function () {
        return isset($_COOKIE['trv_tid']) ? $_COOKIE['trv_tid'] : null;
    },
    Config::STORE_TRACKING_ID_CALLBACK => function ($trackingId) {
        // keep the Tracking-Id as long as possible
        setcookie('trv_tid', $trackingId, 2147483647, '/', null, null, true);
    }
]);

$tas        = new \Trivago\Tas\Tas($config);
$searchTerm = isset($_GET['query']) ? $_GET['query'] : '';

if (!empty($searchTerm)) {
    try {
        $locations = $tas->getLocations(new \Trivago\Tas\Request\LocationsRequest($searchTerm));
    } catch (\Trivago\Tas\Response\ProblemException $e) {
        echo 'API error: ' . $e->getMessage();
    }
}
```

## Documentation

Please see /docs folder.
Currently the documentation is not hosted anywhere so it needs to be created manually with [Sphinx](http://www.sphinx-doc.org).

## Execute tests

To execute unit tests run the `test` command using composer.

```
composer test
```

With `test-quick` unit tets are executed without generating coverage.

```
composer test-quick
```

## License

This project is released under the terms of the [Apache 2.0 license](https://github.com/trivago/tas-sdk-php/blob/master/LICENSE).
