<?php

declare(strict_types=1);

namespace Validator\Rule;

use Validator\Dictionary\TypeArrayDictionary as Dictionary;

class TypeArray extends Rule
{
    protected array $messages = Dictionary::MESSAGES;

    protected function isValid(mixed $subject): bool
    {
        if (!is_array($subject)) {
            $this->errors->createAndAppend($this->messages[Dictionary::MUST_BE_AN_ARRAY], ['value' => $subject]);

            return false;
        }

        return true;
    }
}
