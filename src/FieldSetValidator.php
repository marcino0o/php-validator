<?php

declare(strict_types=1);

namespace Validator;

use Validator\Error\ErrorBag;

class FieldSetValidator
{
    /** @var FieldValidator[] */
    private array $fields;
    /** @var array|ErrorBag[] */
    private array $errors = [];

    public function __construct(
        FieldValidator ...$fieldValidators
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

//    public function assertValid(array $fieldSet): void
//    {
//        if ($this->validate($fieldSet)->hasErrors()) {
//            throw new \Exception('Validation failed');
//        }
//    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
