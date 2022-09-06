<?php

declare(strict_types=1);

namespace Validator\Rule;

use Validator\Error\Error;
use Validator\Rule;

class TypeArray extends Rule
{
    public function isSatisfiedBy(mixed $subject): bool
    {
        if (!is_array($subject)) {
            $this->errors->append(new Error('valueMustBeAnArray', ['value' => $subject]));

            return false;
        }

        return true;
    }
}
