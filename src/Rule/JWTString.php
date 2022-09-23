<?php

declare(strict_types=1);

namespace Validator\Rule;

use Validator\Dictionary\JWTStringDictionary as Dictionary;

class JWTString extends Rule
{
    private const JWT_PATTERN = '/^[a-z0-9_-]+\.[a-z0-9_-]+\.[a-z0-9_-]+$/i';

    protected array $messages = Dictionary::MESSAGES;

    protected function isValid(mixed $subject): bool
    {
        if (!is_string($subject) || !preg_match(self::JWT_PATTERN, $subject)) {
            $this->errors->createAndAppend($this->messages[Dictionary::MUST_BE_A_JWT_STRING], ['value' => $subject]);

            return false;
        }

        return true;
    }
}
