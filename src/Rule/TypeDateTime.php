<?php

declare(strict_types=1);

namespace Validator\Rule;

use DateTimeImmutable;
use DateTimeInterface;
use Exception;
use InvalidArgumentException;

class TypeDateTime extends Rule
{
    private DateTimeImmutable $before;
    private DateTimeImmutable $after;

    public function before(string $dateString): self
    {
        try {
            $this->before = new DateTimeImmutable(strtotime($dateString));
        } catch (Exception) {
            throw new InvalidArgumentException(sprintf('Can\t convert %s to date', $dateString));
        }

        return $this;
    }

    public function after(string $dateString): self
    {
        try {
            $this->after = new DateTimeImmutable(strtotime($dateString));
        } catch (Exception) {
            throw new InvalidArgumentException(sprintf('Can\t convert %s to date', $dateString));
        }

        return $this;
    }

    protected function isValid(mixed $subject): bool
    {
        if (!is_string($subject)) {
            $this->errors->createAndAppend('valueMustBeADate', ['value' => $subject]);

            return false;
        }

        try {
            $date = new DateTimeImmutable($subject);
        } catch (Exception) {
            $this->errors->createAndAppend('valueMustBeADate', ['value' => $subject]);

            return false;
        }

        if (isset($this->before) && $date > $this->before) {
            $this->errors->createAndAppend(
                'mustBeBefore',
                ['value' => $subject, 'before' => $this->before->format(DateTimeInterface::ATOM)]
            );
        }

        if (isset($this->after) && $date < $this->after) {
            $this->errors->createAndAppend(
                'mustBeAfter',
                ['value' => $subject, 'after' => $this->after->format(DateTimeInterface::ATOM)]
            );
        }

        return $this->errors->empty();
    }
}
