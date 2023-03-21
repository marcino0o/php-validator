<?php

declare(strict_types=1);

namespace Validator\Rule;

use Validator\Dictionary\TypeArrayDictionary as Dictionary;

class TypeArray extends Rule
{
    protected array $messages = Dictionary::MESSAGES;
    /** @var string[] */
    private array $allowedKeys;
    /** @var string[] */
    private array $requiredKeys;
    private bool $notEmpty = false;

    protected function isValid(mixed $subject): bool
    {
        if (!is_array($subject)) {
            $this->errors->createAndAppend($this->messages[Dictionary::MUST_BE_AN_ARRAY], ['value' => $subject]);

            return false;
        }

        if ($this->notEmpty && empty($subject)) {
            $this->errors->createAndAppend($this->messages[Dictionary::MUST_NOT_BE_EMPTY], ['value' => $subject]);

            return false;
        }

        $this->validateAllowedKeys($subject);
        $this->validateRequiredKeys($subject);

        return $this->errors->empty();
    }

    public function withAllowedKeys(string ...$allowedKeys): self
    {
        $this->allowedKeys = $allowedKeys;

        return $this;
    }

    public function withRequiredKeys(string ...$requiredKeys): self
    {
        $this->requiredKeys = $requiredKeys;

        return $this;
    }

    public function notEmpty(): self
    {
        $this->notEmpty = true;

        return $this;
    }

    private function validateAllowedKeys(array $subject): void
    {
        if (!isset($this->allowedKeys)) {
            return;
        }

        $subjectKeys = array_keys($subject);
        $forbiddenKeys = array_diff(array_values($subjectKeys), $this->allowedKeys);

        if (!empty($forbiddenKeys)) {
            $this->errors->createAndAppend(
                $this->messages[Dictionary::MUST_NOT_HAVE_OTHER_KEYS],
                [
                    'value' => $subject,
                    'allowedKeys' => implode(', ', $this->allowedKeys),
                    'forbiddenKeys' => implode(', ', $forbiddenKeys),
                ]
            );
        }
    }

    private function validateRequiredKeys(array $subject): void
    {
        if (!isset($this->requiredKeys)) {
            return;
        }

        $subjectKeys = array_keys($subject);
        $missingKeys = array_diff($this->requiredKeys, array_values($subjectKeys));

        if (!empty($missingKeys)) {
            $this->errors->createAndAppend(
                $this->messages[Dictionary::MUST_HAVE_REQUIRED_KEYS],
                [
                    'value' => $subject,
                    'requiredKeys' => implode(', ', $this->requiredKeys),
                    'missingKeys' => implode(', ', $missingKeys),
                ]
            );
        }
    }
}
