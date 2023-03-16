# Uuid


## Quick examples

```php
<?php

require('vendor/autoload.php');

use Validator\Field;
use Validator\Rule\Uuid;

$validator = new FieldSetValidator(
    Field::required('email', new Uuid()),
```

## Select uuid version (default v4)

```php
// public function v4(): self

use Validator\Field;
use Validator\Rule\Uuid;

Field::required('uuid', (new Uuid())->v4());
```