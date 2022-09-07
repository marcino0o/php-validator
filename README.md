# php-validator

![PHP version](https://img.shields.io/badge/php-%5E8.1-blue)
![GitHub tag (latest by date)](https://img.shields.io/github/v/tag/marcino0o/php-validator)
![GitHub](https://img.shields.io/github/license/marcino0o/php-validator)
![Gitlab code coverage](https://img.shields.io/gitlab/coverage/marcino0o/php-validator/main)
![Gitlab pipeline status](https://img.shields.io/gitlab/pipeline-status/marcino0o/php-validator?branch=main)

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

### Available rules
- [Email](https://github.com/marcino0o/php-validator/blob/main/docs/rules/Email.md)
- JWTString
- TypeArray
- [TypeString](https://github.com/marcino0o/php-validator/blob/main/docs/rules/TypeString.md)
