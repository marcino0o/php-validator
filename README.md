# php-validator
___
![PHP version](https://img.shields.io/badge/php-%5E8.1-blue)
![GitHub tag (latest by date)](https://img.shields.io/github/v/tag/marcino0o/php-validator)
![GitHub](https://img.shields.io/github/license/marcino0o/php-validator)
![Gitlab code coverage](https://img.shields.io/gitlab/coverage/marcino0o/php-validator/main)
![Gitlab pipeline status](https://img.shields.io/gitlab/pipeline-status/marcino0o/php-validator?branch=main)

PHP package for easy validation

## Requirements
___
* PHP >= 8.1
* composer

## Installation
___
Using composer:

```console
composer require "marcino0o/php-validator"
```

## Usage
___
### Quick example

```php
<?php

require('vendor/autoload.php');

use Validator\FieldSetValidator;
use Validator\FieldValidator;
use Validator\Rule\Email;
use Validator\Rule\TypeString;

$dataToValidate = [
    'email' => 'joe.doe@example.com', // will pass
    'name' => null, // will pass
]; 

$validator = new FieldSetValidator(
    FieldValidator::required('email', new Email()),
    FieldValidator::optional('name', new TypeString())->nullable(),
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

use Validator\FieldValidator;
use Validator\Rule\TypeString;

// example 1
FieldValidator::required('text', new TypeString())
    ->validate(['text' => 'Hello world'])
    ->hasErrors(); // will return false

// example 2
FieldValidator::required('text', new TypeString())
    ->validate([])
    ->hasErrors(); // will return true

```
**Optional**
```php
<?php

require('vendor/autoload.php');

use Validator\FieldValidator;
use Validator\Rule\TypeString;

// example 1
FieldValidator::optional('text', new TypeString())
    ->validate(['text' => 'Hello world'])
    ->hasErrors(); // will return false

// example 2
FieldValidator::optional('text', new TypeString())
    ->validate([])
    ->hasErrors(); // will return false

```
**Required with other field**
```php
<?php

require('vendor/autoload.php');

use Validator\FieldValidator;
use Validator\Rule\TypeString;

// example 1
FieldValidator::requiredWith('i_will_be_required', 'when_i_exists' new TypeString())
    ->validate(['when_i_exists' => 'Hello world'])
    ->hasErrors(); // will return true

// example 2
FieldValidator::requiredWith('i_will_be_required', 'when_i_exists' new TypeString())
    ->validate([
        'i_will_be_required' => 'Hello universe',
        'when_i_exists' => 'Hello world',
    ])
    ->hasErrors(); // will return false

// example 3
FieldValidator::requiredWith('i_will_be_required', 'when_i_exists' new TypeString())
    ->validate(['not_related_param' => 'Hello world'])
    ->hasErrors(); // will return false

```
### Available rules
| **Rule**   | **Description** |
|------------|-----------------|
| Email      |                 |
| JWTString  |                 |
| TypeArray  |                 |
| TypeString |                 |

