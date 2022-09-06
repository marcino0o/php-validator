<?php

declare(strict_types=1);

namespace RWS\Validator\Rule;

use RWS\Validator\Error\Error;
use RWS\Validator\Rule;

class TypeString extends Rule
{
    private ?int $minLength = null;
    private ?int $maxLength = null;

    public function minLength(int $minLength): self
    {
        $this->minLength = $minLength;

        return $this;
    }

    public function maxLength(int $maxLength): self
    {
        $this->maxLength = $maxLength;

        return $this;
    }

    public function lengthBetween(int $minLength, int $maxLength): self
    {
        $this->minLength = $minLength;
        $this->maxLength = $maxLength;

        return $this;
    }

    public function isSatisfiedBy(mixed $subject): bool
    {
        if (!is_string($subject)) {
            $this->errors->append(new Error('valueMustBeAString', ['value' => $subject]));

            return false;
        }

        if (isset($this->minLength) || isset($this->maxLength)) {
            $stringLength = mb_strlen($subject);

            if (isset($this->minLength) && $stringLength < $this->minLength) {
                $this->errors->append(
                    new Error('stringLengthTooShort', ['value' => $subject, 'minLength' => $this->minLength])
                );
            }

            if (isset($this->maxLength) && $stringLength > $this->maxLength) {
                $this->errors->append(
                    new Error('stringLengthTooLong', ['value' => $subject, 'maxLength' => $this->maxLength])
                );
            }
        }

        return $this->errors->count() === 0;
    }
}
