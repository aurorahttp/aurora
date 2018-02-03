HTTP Transaction
================
[![Build Status](https://travis-ci.org/aurorahttp/http-transaction.svg)](https://travis-ci.org/aurorahttp/http-transaction)
[![Coverage Status](https://coveralls.io/repos/github/aurorahttp/http-transaction/badge.svg?branch=master)](https://coveralls.io/github/aurorahttp/http-transaction?branch=master)
[![Latest Stable Version](https://poser.pugx.org/aurora/http-transaction/v/stable.svg)](https://packagist.org/packages/aurora/http-transaction)
[![Total Downloads](https://poser.pugx.org/aurora/http-transaction/downloads.svg)](https://packagist.org/packages/aurora/http-transaction) 
[![Latest Unstable Version](https://poser.pugx.org/aurora/http-transaction/v/unstable.svg)](https://packagist.org/packages/aurora/http-transaction)
[![License](https://poser.pugx.org/aurora/http-transaction/license.svg)](https://packagist.org/packages/aurora/http-transaction)
[![Aurora Http](https://img.shields.io/badge/Powered_by-Aurora_Http-green.svg?style=flat)](https://aurorahttp.com/)

HTTP Transaction manage a request to a response workflow. The workflow includes 
accept a request, apply HTTP request filters, apply HTTP middlewares, apply HTTP 
response filters and returns a response. The library support PSR-7.

Installation
------------
It's recommended that you use [Composer](https://getcomposer.org/) to install this library.

```bash
$ composer require aurora/http-transaction
```

This will install the library and all required dependencies. The library requires PHP 7.0 or newer.

Workflow
--------

```
        ------ request  ---- Filter --->       
       |                               |    
   Transaction                    Middleware 
       |                               |
        <----- response ---- Filter ---- 
 ```
 
Usage
-----

License
-------

The HTTP Transaction is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).