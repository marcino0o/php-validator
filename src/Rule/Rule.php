<?php

declare(strict_types=1);

namespace Validator\Rule;

use InvalidArgumentException;
use Validator\Error\ErrorBag;

abstract class Rule
{
    protected array $messages = [];

    protected ErrorBag $errors;

    public function __construct()
    {
        $this->errors = new ErrorBag();
    }

    public static function v(): self
    {
        return new static();
    }

    public function isSatisfiedBy(mixed $subject): bool
    {
        $this->errors->truncate();

        return $this->isValid($subject);
    }

    abstract protected function isValid(mixed $subject): bool;

    public function getErrors(): ErrorBag
    {
        return $this->errors;
    }

    public function withMessage(string $error, string $customMessage): self
    {
        if (!array_key_exists($error, $this->messages)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Unknown error %s for %s rule',
                    $error,
                    static::class
                )
            );
        }

        $this->messages[$error] = $customMessage;

        return $this;
    }

    public function withMessages(array $messages): self
    {
        $invalidErrors = array_diff(array_keys($messages), array_keys($this->messages));

        if (!empty($invalidErrors)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Unknown errors: %s for %s rule, allowed: %s',
                    implode(', ', $invalidErrors),
                    static::class,
                    implode(', ', array_keys($this->messages))
                )
            );
        }

        $this->messages = array_merge($this->messages, $messages);

        return $this;
    }
}
