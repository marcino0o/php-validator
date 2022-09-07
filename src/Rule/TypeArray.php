<?php

declare(strict_types=1);

namespace Validator\Rule;

use Validator\Error\Error;

class TypeArray extends Rule
{
    protected function isValid(mixed $subject): bool
    {
        if (!is_array($subject)) {
            $this->errors->append(new Error('valueMustBeAnArray', ['value' => $subject]));

            return false;
        }

        return true;
    }
}
