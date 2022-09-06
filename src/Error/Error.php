<?php

declare(strict_types=1);

namespace RWS\Validator\Error;

class Error
{
    private string $message;
    private int $code;
    private mixed $context;

    public function __construct(string $message, mixed $context = null, int $code = 0)
    {
        $this->message = $message;
        $this->code = $code;
        $this->context = $context;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function getCode(): int
    {
        return $this->code;
    }

    public function getContext(): mixed
    {
        return $this->context;
    }
}