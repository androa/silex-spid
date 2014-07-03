SPiD service provider for Silex
============================
Service provider making the SPiD PHP SDK available to your Silex application.

[![Build Status](https://travis-ci.org/vgnett/silex-spid.svg?branch=master)](https://travis-ci.org/vgnett/silex-spid)

## Installation
Add `"vgnett/silex-spid": "XXX"` to the composer.json file inside your project and do a `composer install`. Check [Composer][1] for the latest available version.

## Setup instructions
Register the SPiD service provider in your Silex app like this;

```php
$app->register(new SPiDServiceProvider(), array(
    'spid.clientId'         => 'foobar',
    'spid.clientSecret'     => 'barfoo',
    'spid.clientSignSecret' => 'foobarsecret',
    'spid.redirectUri'      => 'http://example.com/auth/login',
    'spid.domain'           => 'example.com',
    'spid.cookie'           => true,
    'spid.production'       => false,
    'spid.https'            => true,
    'spid.apiVersion'       => 2
));
```

## Usage
After registering the SPiD service provider, the VGS_Client instance can be accessed from the `$app` variable like this;

```php
$response = $app['spid']->api('/user/123');
```

## Tests
The service provider comes with PHPUnit tests and can be run by doing a `./vendor/phpunit/phpunit/phpunit` inside the silex-spid folder.

## Documentation
See more documentation and examples at the spid-php-sdk page (maintained by Schibsted Payment) at [github.com/schibsted/spid-php-examples][2] and [techdocs.spid.no][3] (access for SPiD customers only).

## License
License
Copyright (c) 2014, Kristoffer Brabrand kristoffer@brabrand.no

Licensed under the MIT License

[1]: http://packagist.org/packages/vgnett/silex-spid
[2]: https://github.com/schibsted/spid-php-examples/
[3]: http://techdocs.spid.no/