<?php

declare(strict_types=1);

namespace Validator\Rule;

use Validator\Error\Error;

class JWTString extends Rule
{
    private const JWT_PATTERN = '/^[a-zA-Z0-9_-]+\.[a-zA-Z0-9_-]+\.[a-zA-Z0-9_-]+$/';

    protected function isValid(mixed $subject): bool
    {
        if (!is_string($subject) || !preg_match(self::JWT_PATTERN, $subject)) {
            $this->errors->append(new Error('valueMustBeAnJWTString', ['value' => $subject]));

            return false;
        }

        return true;
    }
}
