<?php

declare(strict_types=1);

namespace RWS\Validator\Error;

use ArrayIterator;

class ErrorBag extends ArrayIterator
{
    public function __construct(Error ...$errors)
    {
        parent::__construct($errors);
    }

    public function merge(ErrorBag $errors): self
    {
        $mergedErrors = clone $this;
        foreach ($errors as $error) {
            $mergedErrors->append($error);
        }

        return $mergedErrors;
    }
}
