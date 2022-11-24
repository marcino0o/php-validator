<?php

declare(strict_types=1);

namespace Validator;

use InvalidArgumentException;
use Validator\Dictionary\FieldDictionary;
use Validator\Error\ErrorBag;
use Validator\Rule\Rule;

class Field
{
    /** @var Rule[] */
    private array $rules;
    private bool $required;
    private bool $nullable = false;
    private string $requiredWith;
    private ErrorBag $errors;
    protected array $messages = FieldDictionary::MESSAGES;

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
                $this->errors->createAndAppend($this->messages[FieldDictionary::FIELD_IS_REQUIRED]);
            }

            return $this;
        }

        $subject = $fieldSet[$this->name];
        if ($subject === null) {
            if (!$this->nullable) {
                $this->errors->createAndAppend($this->messages[FieldDictionary::FIELD_IS_NOT_NULLABLE]);
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
    public function withMessages(array $messages): self
    {
        $invalidErrors = array_diff(array_keys($messages), array_keys($this->messages));

        if (!empty($invalidErrors)) {
            throw new InvalidArgumentException(
                sprintf('Unknown errors: %s for %s, allowed: %s',
                    implode(', ', $invalidErrors), self::class, implode(', ', array_keys($this->messages))
                )
            );
        }

        $this->messages = array_merge($this->messages, $messages);

        return $this;
    }
}
