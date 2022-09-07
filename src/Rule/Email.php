<?php

declare(strict_types=1);

namespace Validator\Rule;

use Validator\Dictionary\EmailDictionary as Dictionary;

class Email extends Rule
{
    protected array $messages = Dictionary::MESSAGES;

    protected function isValid(mixed $subject): bool
    {
        if (!filter_var($subject, FILTER_VALIDATE_EMAIL)) {
            $this->errors->createAndAppend($this->messages[Dictionary::MUST_BE_AN_EMAIL], ['value' => $subject]);

            return false;
        }

        [, $domain] = explode('@', $subject);

        if (!checkdnsrr($domain, 'MX')) {
            $this->errors->createAndAppend($this->messages[Dictionary::MUST_HAVE_VALID_DOMAIN], ['value' => $subject]);
        }

        return $this->errors->empty();
    }
}
