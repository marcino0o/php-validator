<?php

declare(strict_types=1);

namespace RWS\Validator\Rule;

use RWS\Validator\Error\Error;
use RWS\Validator\Rule;

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
