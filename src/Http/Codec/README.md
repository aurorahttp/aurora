HTTP Codec
==================
[![Build Status](https://travis-ci.org/aurorahttp/http-codec.svg)](https://travis-ci.org/aurorahttp/http-codec)
[![Coverage Status](https://coveralls.io/repos/github/aurorahttp/http-codec/badge.svg?branch=master)](https://coveralls.io/github/aurorahttp/http-codec?branch=master)
[![Latest Stable Version](https://poser.pugx.org/aurora/http-codec/v/stable.svg)](https://packagist.org/packages/aurora/http-codec)
[![Total Downloads](https://poser.pugx.org/aurora/http-codec/downloads.svg)](https://packagist.org/packages/aurora/http-codec) 
[![Latest Unstable Version](https://poser.pugx.org/aurora/http-codec/v/unstable.svg)](https://packagist.org/packages/aurora/http-codec)
[![License](https://poser.pugx.org/aurora/http-codec/license.svg)](https://packagist.org/packages/aurora/http-codec)
[![Aurora Http](https://img.shields.io/badge/Powered_by-Aurora_Http-green.svg?style=flat)](https://aurorahttp.com/)

Decode raw request message and encode PRS-7 response object.

 > ! The HTTP 2.0 part is under development and not yet supported.

Installation
------------
It's recommended that you use [Composer](https://getcomposer.org/) to install this library.

```bash
$ composer require aurora/http-codec
```

This will install the library and all required dependencies. The library requires PHP 7.0 or newer.

Usage
-----

Decode raw Http message content to a request object:
```php
$stream = new Aurora\Http\Decoder\Stream();
$stream = $stream->write($rawHttpMessage);

$decoder = new Aurora\Http\Decoder\Decoder();
$serverRequest = $decoder->decode($stream);
```

Encode a response object to stream:
```php
$encoder = new Aurora\Http\Decoder\Encoder();
$stream = $encoder->encode($response);
```

License
-------
The HTTP Codec is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).