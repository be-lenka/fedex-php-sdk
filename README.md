# PHP Fedex REST API

### Requirements

Fedex REST API project, adapted for PHP >=7, guzzle>=7 and later.
Should also work with PHP 8.0 but has not been tested.

### Composer

To install the bindings via [Composer](https://getcomposer.org/), add the following to `composer.json`:

```json
composer require be-lenka/fedex-php-sdk
```

or

```json
{
  "repositories": [
    {
      "type": "vcs",
      "url": "https://github.com/be-lenka/fedex-php-sdk.git"
    }
  ],
  "require": {
    "be-lenka/fedex-php-sdk": "*@dev"
  }
}
```

Then run `composer install`

### Manual Installation

Download the files and include `autoload.php`:

```php
<?php
require_once('/path/to/vendor/autoload.php');
```

## Get access token

```php
<?php
require_once(__DIR__ . '/vendor/autoload.php');

$auth = new \belenka\fedex\Authorization\Authorize();
if($productionMode) {
    $auth->useProduction();
}

$auth->setClientId('<clientId>');
$auth->setClientSecret('<clientSecret>');

$auth->authorize();
$token = $auth->getAccessToken();
```

## Fetch tracking information by number

```php
$obj = new \belenka\fedex\Services\Track\TrackByTrackingNumberRequest();

// Response from $auth->getAccessToken()
$obj->setAccessToken($token);
$obj->setTrackingNumber($number);

$response = $obj->request();
```

## Address validation

```php
$address = new \belenka\fedex\Entity\Address();
$address->setCity('Prague');
$address->setCountryCode('CZ');
$address->setPostalCode('98511');
$address->setStateOrProvince('Czech Republic');
$address->setStreetLines('Jakubská');

$obj = \belenka\fedex\Services\AddressValidation\AddressValidation($address);

// Response from $auth->getAccessToken()
$obj->setAccessToken($token);
$obj->setAddress($address);
        
$response = $obj->request();
```
