<?php

declare(strict_types=1);

namespace Validator\Rule;

use Validator\Dictionary\TypeStringDictionary as Dictionary;

class TypeString extends Rule
{
    protected array $messages = Dictionary::MESSAGES;

    private int $minLength;
    private int $maxLength;
    /** @var string[]  */
    private array $allowedValues;

    private function getRules(): array
    {
        $rules = [];
        if (isset($this->minLength)) {
            $rules['minLength'] = $this->minLength;
        }

        if (isset($this->maxLength)) {
            $rules['maxLength'] = $this->maxLength;
        }

        return $rules;
    }

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

    public function allowedValues(string ...$allowedValues): self
    {
        $this->allowedValues = $allowedValues;

        return $this;
    }

    protected function isValid(mixed $subject): bool
    {
        if (!is_string($subject)) {
            $this->errors->createAndAppend(
                $this->messages[Dictionary::VALUE_MUST_BE_A_STRING],
                ['value' => $subject],
                $this->getRules()
            );

            return false;
        }

        if (isset($this->minLength) || isset($this->maxLength)) {
            $this->validateMinLength($subject);
            $this->validateMaxLength($subject);
        }

        if (isset($this->allowedValues) && !in_array($subject, $this->allowedValues, true)) {
            $this->errors->createAndAppend(
                $this->messages[Dictionary::NOT_ALLOWED_VALUE],
                ['value' => $subject, 'allowedValues' => $this->allowedValues],
            );
        }

        return $this->errors->empty();
    }

    private function validateMinLength(string $subject): void
    {
        if (!isset($this->minLength)) {
            return;
        }

        $stringLength = mb_strlen($subject);

        if ($stringLength < $this->minLength) {
            $this->errors->createAndAppend(
                $this->messages[Dictionary::LENGTH_TOO_SHORT],
                ['value' => $subject, 'minLength' => $this->minLength, 'length' => $stringLength],
                $this->getRules()
            );
        }
    }

    private function validateMaxLength(string $subject): void
    {
        if (!isset($this->maxLength)) {
            return;
        }

        $stringLength = mb_strlen($subject);

        if ($stringLength > $this->maxLength) {
            $this->errors->createAndAppend(
                $this->messages[Dictionary::LENGTH_TOO_LONG],
                ['value' => $subject, 'maxLength' => $this->maxLength, 'length' => $stringLength],
                $this->getRules()
            );
        }
    }
}
