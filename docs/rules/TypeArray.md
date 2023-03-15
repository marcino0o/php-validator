# TypeArray


## Quick examples

```php
<?php

require('vendor/autoload.php');

use Validator\Field;
use Validator\Rule\TypeArray;

$anyArray = new TypeArray();

$requiredKeys = new TypeArray();
$requiredKeys->withRequiredKeys('firstName', 'lastName', 'city');

$validator = new FieldSetValidator(
    Field::required('tags', $anyArray),
    Field::required('author', $requiredKeys),
);
```

## Build in additional rules

```php
// public function withRequiredKeys(string ...$requiredKeys): self

use Validator\Field;
use Validator\Rule\TypeArray;

Field::required('car', (new TypeArray())->withRequiredKeys('brand', 'model', 'generation'));
```

```php
// public function withAllowedKeys(string ...$allowedKeys): self

use Validator\Field;
use Validator\Rule\TypeArray;

Field::required('player', (new TypeArray())->withAllowedKeys('name', 'age'));
```