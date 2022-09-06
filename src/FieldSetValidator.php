<?php

declare(strict_types=1);

namespace RWS\Validator;

class FieldSetValidator
{
    /**
     * @var FieldValidator[]
     */
    private array $fields;
    private array $errors = [];

    public function __construct(
        FieldValidator ...$fieldValidators
    ) {
        $this->fields = $fieldValidators;
    }

    public function validate(array $fieldSet): void
    {
        foreach ($this->fields as $field) {
            if ($field->validate($fieldSet)->hasErrors()) {
                $this->errors[$field->name] = $field->getErrors();
            }
        }
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
