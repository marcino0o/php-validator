<?php

declare(strict_types=1);

namespace RWS\Validator;

class Result
{
    public function __construct(
        public readonly bool $valid,
        public readonly array $errors,
    ) {
    }

    public static function notValid(array $errors): self
    {
        return new self(false, $errors);
    }

    public static function valid(): self
    {
        return new self(true, []);
    }
}
