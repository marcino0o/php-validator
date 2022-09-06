<?php

declare(strict_types=1);

namespace Validator;

use Validator\Error\ErrorBag;

abstract class Rule
{
    protected ErrorBag $errors;

    public function __construct() {
        $this->errors = new ErrorBag();
    }

    abstract public function isSatisfiedBy(mixed $subject): bool;

    public function getErrors(): ErrorBag
    {
        return $this->errors;
    }
}
