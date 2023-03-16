<?php

declare(strict_types=1);

namespace Validator\Rule;

use Validator\Dictionary\NumberDictionary as Dictionary;

class Number extends Rule
{
    protected array $messages = Dictionary::MESSAGES;

    private string $type;
    private int|float $min;
    private int|float $max;

    public function min(int|float $min): self
    {
        $this->min = $min;

        return $this;
    }

    public function max(int|float $max): self
    {
        $this->max = $max;

        return $this;
    }

    public function unsigned(): self
    {
        $this->min = 0;

        return $this;
    }

    public function integer(): self
    {
        $this->type = 'int';

        return $this;
    }

    public function float(): self
    {
        $this->type = 'float';

        return $this;
    }

    protected function isValid(mixed $subject): bool
    {
        if (!isset($this->type) && (!is_int($subject) || !is_float($subject))) {
            $this->errors->createAndAppend($this->messages[Dictionary::MUST_BE_A_NUMBER], ['value' => $subject]);

            return false;
        }

        if (isset($this->type) && $this->type === 'int' && !is_int($subject)) {
            $this->errors->createAndAppend(
                $this->messages[Dictionary::MUST_BE_AN_INTEGER_NUMBER], ['value' => $subject]
            );

            return false;
        }

        if (isset($this->type) && $this->type === 'float' && !is_float($subject)) {
            $this->errors->createAndAppend($this->messages[Dictionary::MUST_BE_A_FLOAT_NUMBER], ['value' => $subject]);

            return false;
        }

        if (isset($this->min) && $subject < $this->min) {
            $this->errors->createAndAppend(
                $this->messages[Dictionary::MUST_BE_GEQ_THAN],
                ['value' => $subject, 'min' => $this->min]
            );

            return false;
        }

        if (isset($this->max) && $subject > $this->max) {
            $this->errors->createAndAppend(
                $this->messages[Dictionary::MUST_BE_LEQ_THAN],
                ['value' => $subject, 'max' => $this->max]
            );

            return false;
        }

        return true;
    }
}
