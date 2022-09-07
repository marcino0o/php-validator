<?php

declare(strict_types=1);

namespace Validator;

use Validator\Error\ErrorBag;

class FieldSetValidator
{
    /** @var Field[] */
    private array $fields;
    /** @var array|ErrorBag[] */
    private array $errors = [];

    public function __construct(
        Field ...$fieldValidators
    ) {
        $this->fields = $fieldValidators;
    }

    public function validate(array $fieldSet): self
    {
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
}
