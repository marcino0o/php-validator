# TypeString


## Quick examples

```php
<?php

require('vendor/autoload.php');

use Validator\Field;
use Validator\Rule\TypeString;

$anyString = new TypeString;

$lengthBetween = new TypeString;
$lengthBetween->lengthBetween(5, 32);

$validator = new FieldSetValidator(
    Field::required('post', $anyString),
    Field::required('authorName', $lengthBetween),
);
```

## Build in additional rules

```php
// public function minLength(int $minLength): self

use Validator\Field;
use Validator\Rule\TypeString;

Field::required('text', (new TypeString)->minLength(5));
```

```php
// public function maxLength(int $maxLength): self

use Validator\Field;
use Validator\Rule\TypeString;

Field::required('text', (new TypeString)->maxLength(32));
```

```php
// public function lengthBetween(int $minLength, int $maxLength): self

use Validator\Field;
use Validator\Rule\TypeString;

Field::required('text', (new TypeString)->lengthBetween(5, 32));
```