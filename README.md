# Blablacar Memcached Wrapper

[![Build Status](https://travis-ci.org/blablacar/memcached-client.png)](https://travis-ci.org/blablacar/memcached-client)

This library provides a simple Memcached connection wrapper.

## Installation

The recommended way to install this library is through
[Composer](http://getcomposer.org/). Require the `blablacar/memcached-client`
package into your `composer.json` file:

```json
{
    "require": {
        "blablacar/memcached-client": "@stable"
    }
}
```

**Protip:** you should browse the
[`blablacar/memcached-client`](https://packagist.org/packages/blablacar/memcached-client)
page to choose a stable version to use, avoid the `@stable` meta constraint.

## Usage

Create a Client and you're done!

```php
$client = new \Blablacar\Memcached\Client('127.0.0.1', 6379); // Default values
$client->set('foobar', 42); // Return 1
```

## License

Blablacar Memcached client is released under the MIT License. See the bundled
LICENSE file for details.
