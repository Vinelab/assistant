[![Build Status](https://travis-ci.org/Vinelab/assistant.png?branch=master)](https://travis-ci.org/Vinelab/assistant)

## Vinelab Assistant Package - Laravel 4

A bunch of helper classes:

Installation
------------

Refer to [vinelab/assistant on packagist.org](https://packagist.org/packages/vinelab/assistant) for composer installation instructions.

Edit **app.php** and add ```'Vinelab\Assistant\AssistantServiceProvider',``` to the ```'providers'``` array.

It will automatically alias the classes **Formatter** and **DeviceDetector** so no need to alias it in your **app.php** unless you would like to customize it. In that case edit your **'aliases'** in **app.php** adding ``` 'MyFormatter'	  => 'Vinelab\Assistant\Facades\Formatter',``` and ``` 'MyDeviceDetector'	  => 'Vinelab\Assistant\Facades\DeviceDetector',```

## Usage

### Formatter

```php
<?php

	Formatter::snakify('my word to make a snake'); // output: my_word_to_make_a_snake

	Formatter::camelify('hakuna matata'); //output: hakunaMatata

	Formatter::neutralize('I hAtE whEn sOmEoNe wRites thInGs LIKE tHiS'); // output: ihatewhensomeonewritesthingslikethis

	Formatter::dashit('bash cash slash'); // output: bash-cash-slash

	Formatter::date('10-02-2010 12:13:00'); // output: 10/02/10

	Formatter::date('10-02-2010 12:13:00', 'd-m-y'); // output: 10-02-10
```

### DeviceDetector

```php
<?php

	$user_agent = $_SERVER['HTTP_USER_AGENT'];

	// or in case of laravel
	$user_agent = Request::server('HTTP_USER_AGENT');

	DeviceDetector::isMobile($user_agent); // true|false

	DeviceDetector::isBrowser($user_agent); // true|false

	DeviceDetector::isBot($user_agent); // true|false

	DeviceDetector::whatIs($user_agent); // mobile|browser|bot

```