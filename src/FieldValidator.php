<?php

declare(strict_types=1);

namespace Validator;

use Validator\Error\Error;
use Validator\Error\ErrorBag;
use Validator\Rule\Rule;

class FieldValidator
{
    /** @var Rule[] */
    private array $rules;
    private bool $required;
    private bool $nullable = false;
    private string $requiredWith;
    private ErrorBag $errors;

    private function __construct(
        public readonly string $name,
        Rule ...$rules
    ) {
        $this->rules = $rules;
        $this->errors = new ErrorBag();
    }

    public static function required(string $name, Rule ...$rules): self
    {
        $fieldValidator = new self($name, ...$rules);
        $fieldValidator->required = true;

        return $fieldValidator;
    }

    public static function requiredWith(string $name, string $withFieldName, Rule ...$rules): self
    {
        $fieldValidator = new self($name, ...$rules);
        $fieldValidator->required = false;
        $fieldValidator->requiredWith = $withFieldName;

        return $fieldValidator;
    }
    public static function optional(string $name, Rule ...$rules): self
    {
        $fieldValidator = new self($name, ...$rules);
        $fieldValidator->required = false;

        return $fieldValidator;
    }

    public function validate(array $fieldSet): self
    {
        if (!array_key_exists($this->name, $fieldSet)) {
            if ($this->isRequired($fieldSet)) {
                $this->errors->append(new Error('fieldRequired'));
            }

            return $this;
        }

        $subject = $fieldSet[$this->name];
        if ($subject === null) {
            if (!$this->nullable) {
                $this->errors->append(new Error('nullNotAllowed'));
            }

            return $this;
        }

        foreach ($this->rules as $rule) {
            if (!$rule->isSatisfiedBy($subject)) {
                $this->errors->merge($rule->getErrors());
            }
        }

        return $this;
    }

    public function hasErrors(): bool
    {
        return $this->errors->count() > 0;
    }

    public function nullable(): self
    {
        $this->nullable = true;

        return $this;
    }

    private function isRequired(array $fieldSet): bool
    {
        return $this->required || (isset($this->requiredWith) && array_key_exists($this->requiredWith, $fieldSet));
    }

    public function getErrors(): ErrorBag
    {
        return $this->errors;
    }
}
