<?php

declare(strict_types=1);

namespace Validator\Error;

use ArrayIterator;
use IteratorAggregate;

class ErrorBag implements IteratorAggregate
{
    private array $errors;

    public function __construct(Error ...$errors)
    {
        $this->errors = $errors;
    }

    public function append(Error $error): self
    {
        $this->errors[] = $error;

        return $this;
    }

    public function merge(ErrorBag $errors): self
    {
        foreach ($errors as $error) {
            $this->append($error);
        }

        return $this;
    }

    public function count(): int
    {
        return count($this->errors);
    }

    public function empty(): bool
    {
        return empty($this->errors);
    }

    public function truncate(): void
    {
        $this->errors = [];
    }

    public function createAndAppend(string $message, array $context = [], array $rules = []): self
    {
        $this->append(new Error($message, $context, $rules));

        return $this;
    }

    public function first(): ?Error
    {
        if ($this->empty()) {
            return null;
        }

        return $this->errors[0];
    }

    public function getIterator(): ArrayIterator
    {
        return new ArrayIterator($this->errors);
    }
}
