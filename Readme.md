[![Build Status](https://img.shields.io/travis/iamalirezaj/fraud/develop.svg?style=flat-square)](https://travis-ci.org/iamalirezaj/fraud)
[![Total Downloads](https://img.shields.io/packagist/dt/josh/fraud.svg?style=flat-square)](https://packagist.org/packages/josh/fraud)
[![Scrutinizer Code Quality](https://img.shields.io/scrutinizer/g/iamalirezaj/fraud.svg?style=flat-square)](https://scrutinizer-ci.com/g/iamalirezaj/fraud/?branch=develop)
[![License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](https://packagist.org/packages/josh/fraud)

# Fraud Middleware
Fraud Middleware for laravel

# Introduction
* A laravel middleware for checking fraud of user

## Requirement
* php 5.6 >=
* Laravel 5.2 >=
* HHVM

## Install with composer
You can install this package throw the [Composer](http://getcomposer.org) by running:

```
composer require josh/fraud
```

## Register middleware in Kernel
```php
// app/Http/Kernel.php

protected $routeMiddleware = [
  'fraud' => \Josh\Fraud\FraudMiddleware::class,
];
```

## Usage
#### Checking fraud in routing

```php
Route::get('/',function(){

  return "It's Work";

})->middleware('fraud');
```

## License
The MIT License (MIT). Please see [License File](LICENSE) for more information.
