<?php

declare(strict_types=1);

namespace Validator;

use Validator\Error\Error;
use Validator\Error\ErrorBag;

class FieldSetValidator
{
    /** @var Field[] */
    private array $fields;
    /** @var array|ErrorBag[] */
    private array $errors = [];
    /** @var string[] */
    private array $allowedFields;

    public function __construct(
        Field ...$fieldValidators,
    ) {
        $this->fields = $fieldValidators;
    }

    public function withAllowedFields(string ...$allowedFields): self
    {
        $this->allowedFields = $allowedFields;

        return $this;
    }

    public function validate(array $fieldSet): self
    {
        $this->validateAllowedFields($fieldSet);

        foreach ($this->fields as $field) {
            if ($field->validate($fieldSet)->hasErrors()) {
                $this->errors[$field->name] = $field->getErrors();
            }
        }

        return $this;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    private function validateAllowedFields(array $fieldSet): void
    {
        if (!isset($this->allowedFields)) {
            return;
        }

        $forbiddenFields = array_diff(array_keys($fieldSet), $this->allowedFields);
        foreach ($forbiddenFields as $forbiddenField) {
            $this->errors[$forbiddenField] = new ErrorBag(new Error('Usage of this field is forbidden'));
        }
    }
}
