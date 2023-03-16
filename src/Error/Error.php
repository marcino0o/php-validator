<?php

declare(strict_types=1);

namespace Validator\Error;

class Error
{
    public function __construct(
        private readonly string $message,
        private readonly array $context = [],
        private readonly array $rules = []
    ) {
    }

    public function getMessage(): string
    {
        return str_replace(
            array_map(
                static fn(string $key): string => sprintf('{{ %s }}', $key),
                array_keys(array_merge($this->context, $this->rules))
            ),
            array_map('strval', array_values(array_merge($this->context, $this->rules))),
            $this->message
        );
    }

    public function getContext(): array
    {
        return $this->context;
    }
}
