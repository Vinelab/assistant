[![Build Status](https://travis-ci.org/Vinelab/assistant.png?branch=master)](https://travis-ci.org/Vinelab/assistant)

# Assistant
A bunch of helper classes that provides:

- Device detection (mobile, browser, bot, social network crawlers, etc.)
- String formatting
- Generating UUIDs (v4 compliant) and random IDs

> Supports UTF-8 Character sets.

## Installation

### Dependencies
- php 5.3+
- mbstring (extension)

### via Composer
```
composer require vinelab/assistant
```

Or add it to your `composer.json`

```json
{
     "require": {
         "vinelab/assistant": "*"
     }
 }
```

#### Laravel
Edit **app.php** and add `'Vinelab\Assistant\AssistantServiceProvider'` to the `'providers'` array.

It will automatically alias the classes **Formatter**, **DeviceDetector** and **Generator**,
In case you would like to customize their names, edit the `aliases` array in **app.php** with the following:

```php
array(
	'...',
	'MyFormatter' => 'Vinelab\Assistant\Facades\Formatter',
	'MyGenerator' => 'Vinelab\Assistant\Facades\Generator',
	'MyDeviceDetector' => 'Vinelab\Assistant\Facades\DeviceDetector',
)
```

### Formatter

```php
	Formatter::snakify('my word to make a snake'); // output: my_word_to_make_a_snake

	Formatter::camelify('hakuna matata'); //output: hakunaMatata

	Formatter::neutralize('I hAtE whEn sOmEoNe wRites thInGs LIKE tHiS');
	// output: ihatewhensomeonewritesthingslikethis

	Formatter::dashit('bash cash slash'); // output: bash-cash-slash

	Formatter::date('10-02-2010 12:13:00'); // output: 10/02/10

	Formatter::date('10-02-2010 12:13:00', 'd-m-y'); // output: 10-02-10

	// Turn a camelCase string into dash-separated string
	Formatter::aliasify('simpleTest'); // output: simple-test

	Formatter::br2nl('a<br>b'); // output: a\nb

	// Clean up HTML formatting to be saved in the database or used as plain text
	// keeping links only as anchor tags. Solves an issue with editors when pasting
	// in text from word processors or web pages. PS: removes all sorts of media.
	Formatter::cleanHTML('<p>some</p><br><a href="#html">HTML</a><div>cleaned</div><img src="http://come.img" />');
	// output: some\n\n<a href="#html">HTML</a>\ncleaned\n
```

### DeviceDetector

```php
	$user_agent = $_SERVER['HTTP_USER_AGENT'];

	// or in case of laravel
	$user_agent = Request::server('HTTP_USER_AGENT');

	DeviceDetector::isMobile($user_agent); // true|false

	DeviceDetector::isBrowser($user_agent); // true|false

	DeviceDetector::isBot($user_agent); // true|false - also detects sharing bots

	DeviceDetector::isSharingBot($user_agent) // true|false

	DeviceDetector::whatIs($user_agent); // mobile|browser|bot|sharing-bot

	DeviceDetector::os($user_agent); // ios|android|blackberry|windows|other
```

### DomainDetector

```php
	$http = $_SERVER['HTTP_HOST'];

	// or in case of laravel
	$http = Request::server('HTTP_HOST');

	DomainDetector::domain($http); // eg. test.subdomains.google.co.uk -> 'google'
	DomainDetector::subdomain($http); // eg. test.subdomains.google.co.uk -> ['test', 'subdomains']

```

### Generator

```php
	// Generate a UUID v4 compliant.
	$uuid = Generator::uuid();

	// unique identifier that does not exceed 30 chars
	$id = Generator::randomId(); // 907927051cdd15588d36
```
