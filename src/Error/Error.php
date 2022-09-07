<?php

declare(strict_types=1);

namespace Validator\Error;

class Error
{
    private string $message;
    private mixed $context;

    public function __construct(string $message, array $context = [])
    {
        $this->message = $message;
        $this->context = $context;
    }

    public function getMessage(): string
    {
        return str_replace(
            array_map(
                static fn(string $key): string => sprintf('{{ %s }}', $key),
                array_keys($this->context)
            ),
            array_map('strval', array_values($this->context)),
            $this->message
        );
    }

    public function getContext(): mixed
    {
        return $this->context;
    }
}
