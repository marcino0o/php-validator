<?php

declare(strict_types=1);

namespace Validator\Rule;

use Validator\Error\Error;
use Validator\Rule;

class Email extends Rule
{
    public function isSatisfiedBy(mixed $subject): bool
    {
        if (!filter_var($subject, FILTER_VALIDATE_EMAIL)) {
            $this->errors->append(new Error('valueMustBeAnEmail', $subject));

            return false;
        }

        [, $domain] = explode('@', $subject);

        if (!checkdnsrr($domain, 'MX')) {
            $this->errors->append(new Error('emailMustHaveValidDomain', $subject));
        }

        return $this->errors->count() === 0;
    }
}
