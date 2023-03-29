# php-validator

![PHP version](https://img.shields.io/badge/php-%5E8.1-blue)
![GitHub tag (latest by date)](https://img.shields.io/github/v/tag/marcino0o/php-validator)
![GitHub Release Date](https://img.shields.io/github/release-date/marcino0o/php-validator)
![GitHub](https://img.shields.io/github/license/marcino0o/php-validator)
[![Coverage Status](https://coveralls.io/repos/github/marcino0o/php-validator/badge.svg?branch=main)](https://coveralls.io/github/marcino0o/php-validator?branch=main)
![Gitlab pipeline status](https://img.shields.io/github/actions/workflow/status/marcino0o/php-validator/php.yml?branch=main)

PHP package for easy validation

## Features

* field sets validation
* custom error messages

## Requirements

* PHP >= 8.1
* composer

## Installation

Using composer:

```console
composer require "marcino0o/php-validator"
```

## Usage

### Quick example

```php
<?php

require('vendor/autoload.php');

use Validator\FieldSetValidator;
use Validator\Field;
use Validator\Rule\Email;
use Validator\Rule\TypeString;

$dataToValidate = [
    'email' => 'joe.doe@example.com', // will pass
    'name' => null, // will pass
]; 

$validator = new FieldSetValidator(
    Field::required('email', new Email()),
    Field::optional('name', new TypeString())->nullable(),
);

if ($validator->validate($dataToValidate)->hasErrors()) {
    var_dump($validator->getErrors());
    exit;
}

// all good
```

#### Specifying allowed fields in set

```php
<?php

require('vendor/autoload.php');

use Validator\FieldSetValidator;
use Validator\Field;
use Validator\Rule\Email;

$dataToValidate = [
    'email' => 'joe.doe@example.com', // will pass
    'name' => 'Joe Doe', // will not pass
]; 

$validator = new FieldSetValidator(
    Field::required('email', new Email()),
);
$validator->withAllowedFields('email');
```

#### Fields in sets with multidimensional arrays

```php
<?php

require('vendor/autoload.php');

use Validator\FieldSetValidator;
use Validator\Field;
use Validator\Rule\TypeArray
use Validator\Rule\TypeString;
use Validator\Rule\Uuid;

$dataToValidate = [
    'author' => [
        'uuid' => 'c07f9405-8618-49a7-980a-e4982e307274',
        'name' => 'Joe Doe',
    ],   
]; 

$validator = new FieldSetValidator(
    Field::required('author', (new TypeArray())->withRequiredKeys('uuid', 'name')),
    Field::requiredWith('author.uuid', 'author' new Uuid()),
    Field::requiredWith('author.name', 'author' new TypeString()),
);
```

### Field requirement options

**Always required**

```php
<?php

require('vendor/autoload.php');

use Validator\Field;
use Validator\Rule\TypeString;

// example 1
Field::required('text', new TypeString())
    ->validate(['text' => 'Hello world'])
    ->hasErrors(); // will return false

// example 2
Field::required('text', new TypeString())
    ->validate([])
    ->hasErrors(); // will return true
```

**Optional**

```php
<?php

require('vendor/autoload.php');

use Validator\Field;
use Validator\Rule\TypeString;

// example 1
Field::optional('text', new TypeString())
    ->validate(['text' => 'Hello world'])
    ->hasErrors(); // will return false

// example 2
Field::optional('text', new TypeString())
    ->validate([])
    ->hasErrors(); // will return false
```

**Required with other field**

```php
<?php

require('vendor/autoload.php');

use Validator\Field;
use Validator\Rule\TypeString;

// example 1
Field::requiredWith('i_will_be_required', 'when_i_exists', new TypeString())
    ->validate(['when_i_exists' => 'Hello world'])
    ->hasErrors(); // will return true

// example 2
Field::requiredWith('i_will_be_required', 'when_i_exists', new TypeString())
    ->validate([
        'i_will_be_required' => 'Hello universe',
        'when_i_exists' => 'Hello world',
    ])
    ->hasErrors(); // will return false

// example 3
Field::requiredWith('i_will_be_required', 'when_i_exists', new TypeString())
    ->validate(['not_related_param' => 'Hello world'])
    ->hasErrors(); // will return false
```

### Custom messages

```php
<?php

require('vendor/autoload.php');

use Validator\Dictionary\TypeStringDictionary as Dictionary;
use Validator\Rule\TypeString;

$example1 = new TypeString;
$example1->withMessages([
    Dictionary::LENGTH_TOO_SHORT => 'C\'mon, {{ minLength }} characters it\'s not much! You can write more than "{{ value }}"',
    Dictionary::LENGTH_TOO_LONG => 'Take it easy! There is a space for only {{ maxLength }} characters!',
]);

$example1->lengthBetween(5, 1000)->isSatisfiedBy('abc'); // false
$example1->getErrors()->first()->getMessage(); // C'mon, 5 characters it's not much! You can write more than "abc"


$example2 = new TypeString;
$example1->withMessage(Dictionary::LENGTH_TOO_SHORT, 'Text is too short.')
```

## Available rules
- [Email](https://github.com/marcino0o/php-validator/blob/main/docs/rules/Email.md)
- [JWTString](https://github.com/marcino0o/php-validator/blob/main/docs/rules/JWTString.md)
- [Number](https://github.com/marcino0o/php-validator/blob/main/docs/rules/Number.md)
- [TypeArray](https://github.com/marcino0o/php-validator/blob/main/docs/rules/TypeArray.md)
- [TypeDateTime](https://github.com/marcino0o/php-validator/blob/main/docs/rules/TypeDateTime.md)
- [TypeString](https://github.com/marcino0o/php-validator/blob/main/docs/rules/TypeString.md)
- [Uuid](https://github.com/marcino0o/php-validator/blob/main/docs/rules/Uuid.md)
