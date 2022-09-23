# TypeEmail


## Quick examples

```php
<?php

require('vendor/autoload.php');

use Validator\Field;
use Validator\Rule\Email;

$validator = new FieldSetValidator(
    Field::required('email', new Email),
);
```

## Build in additional rules

```php
// public function inDomain(string ...$allowedDomains): self

use Validator\Field;
use Validator\Rule\Email;

Field::required('email', (new Email)->inDomain('gmail.com', 'yahoo.com'));
```

```php
// public function notInDomain(string ...$blockedDomains): self

use Validator\Field;
use Validator\Rule\Email;

Field::required('email', (new Email)->notInDomain('yandex.ru'));
```