<?php

declare(strict_types=1);

namespace Validator\Rule;

use Validator\Dictionary\UuidDictionary as Dictionary;

class Uuid extends Rule
{
    protected array $messages = Dictionary::MESSAGES;
    private const UUID_V4_PATTERN = '/^[a-f\d]{8}(-[a-f\d]{4}){4}[a-f\d]{8}$/i';

    private string $uuidPattern = self::UUID_V4_PATTERN;

    public function v4(): self
    {
        $this->uuidPattern = self::UUID_V4_PATTERN;

        return $this;
    }

    protected function isValid(mixed $subject): bool
    {
        if (!is_string($subject) || !preg_match($this->uuidPattern, $subject)) {
            $this->errors->createAndAppend($this->messages[Dictionary::MUST_BE_AN_UUID], ['value' => $subject]);

            return false;
        }

        return true;
    }
}
