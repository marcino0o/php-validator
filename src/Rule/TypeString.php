<?php

declare(strict_types=1);

namespace Validator\Rule;

use Validator\Dictionary\TypeStringDictionary as Dictionary;

class TypeString extends Rule
{
    protected array $messages = Dictionary::MESSAGES;

    private ?int $minLength = null;
    private ?int $maxLength = null;

    public function minLength(int $minLength): self
    {
        $this->minLength = $minLength;

        return $this;
    }

    public function maxLength(int $maxLength): self
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    public function lengthBetween(int $minLength, int $maxLength): self
    {
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;

        return $this;
    }

    protected function isValid(mixed $subject): bool
    {
        if (!is_string($subject)) {
            $this->errors->createAndAppend($this->messages[Dictionary::VALUE_MUST_BE_A_STRING], ['value' => $subject]);

            return false;
        }

        if (isset($this->minLength) || isset($this->maxLength)) {
            $this->validateMinLength($subject);
            $this->validateMaxLength($subject);
        }

        return $this->errors->empty();
    }

    private function validateMinLength(string $subject): void
    {
        if ($this->minLength === null) {
            return;
        }

        $stringLength = mb_strlen($subject);

        if ($stringLength < $this->minLength) {
            $this->errors->createAndAppend(
                $this->messages[Dictionary::LENGTH_TOO_SHORT],
                ['value' => $subject, 'minLength' => $this->minLength, 'length' => $stringLength]
            );
        }
    }

    private function validateMaxLength(string $subject): void
    {
        if ($this->maxLength === null) {
            return;
        }

        $stringLength = mb_strlen($subject);

        if ($stringLength > $this->maxLength) {
            $this->errors->createAndAppend(
                $this->messages[Dictionary::LENGTH_TOO_LONG],
                ['value' => $subject, 'maxLength' => $this->maxLength, 'length' => $stringLength]
            );
        }
    }
}
