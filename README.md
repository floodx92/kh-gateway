# KhGateway

This package provides a simple way to interact with the K&H Bank Gateway API.
This package is not affiliated with K&H Bank in any way.

Use the official docs to understand the full payment flow: [K&H Official documentation](https://github.com/khpos/Payment-gateway_HU/wiki)

## Requirements

- PHP 8.1 or higher

## Installation

You can install the package via composer:

```bash
composer require floodx92/kh-gateway
```

## Usage

First, you need to instantiate `CurlHttpClient` and `OpenSSLAdapter` classes.
You can always use `new ClassName()` or `ClassName::make()` to instantiate a class.

```php
use Floodx92\KhGateway\Util\CurlHttpClient;
use Floodx92\KhGateway\Crypto\OpenSSLAdapter;
use Floodx92\KhGateway\ApiService;
use Floodx92\KhGateway\Storage\FileKeyStorage;

// Instantiate the Http client, with the API URL
$client = CurlHttpClient::make(ApiService::SANDBOX_URL);
//client = CurlHttpClient::make(ApiService::PRODUCTION_URL);

// For the OpenSSLAdapter, first we need a KeyStore
$keyStore = FileKeyStorage::make(
    'path/to/your/private.key',
    'path/to/your/public.key',
    //optionally you can pass a passphrase as last argument
)
$adapter = OpenSSLAdapter::make($keyStore, $verifySignature = true);
```

Then, you can use the `ApiService` class to send requests to the API.

```php
use Floodx92\KhGateway\ApiService;
use Floodx92\KhGateway\Model\Request\EchoRequest;
use Floodx92\KhGateway\Exception\HttpException;

$api = ApiService::make($adapter, $client);

// Send an Echo request
$echoRequest = EchoRequest::make($merchantId = 'ABC123456')
try {
    $echoResult = $api->echo($echoRequest);
    echo $echoResult->resultCode;
} catch (HttpException $e) {
    // Handle the exception
}
```

## Error Handling

All methods can throw a `HttpException` in case of a cURL error or when an HTTP error status code is received. You should catch this exception and handle it appropriately in your code.


## TODO

- [ ] Add tests
- [ ] Add more documentation
- [ ] Better JSON mapping for the responses

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## License

This package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).