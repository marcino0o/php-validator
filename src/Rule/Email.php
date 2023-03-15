<?php

declare(strict_types=1);

namespace Validator\Rule;

use Validator\Dictionary\EmailDictionary as Dictionary;

class Email extends Rule
{
    protected array $messages = Dictionary::MESSAGES;
    /*** @var string[]*/
    private array $allowedDomains;
    /*** @var string[] */
    private array $blockedDomains;

    public function inDomain(string ...$allowedDomains): self
    {
        $this->allowedDomains = $allowedDomains;

        return $this;
    }

    public function notInDomain(string ...$blockedDomains): self
    {
        $this->blockedDomains = $blockedDomains;

        return $this;
    }

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

        if (isset($this->allowedDomains) && !in_array($domain, $this->allowedDomains, true)) {
            $this->errors->createAndAppend(
                $this->messages[Dictionary::MUST_BE_IN_ALLOWED_DOMAIN],
                [
                    'value' => $subject,
                    'domain' => $domain,
                    'allowedDomains' => implode(', ', $this->allowedDomains)
                ]
            );
        }

        if (isset($this->blockedDomains) && in_array($domain, $this->blockedDomains, true)) {
            $this->errors->createAndAppend(
                $this->messages[Dictionary::MUST_NOT_BE_IN_BLOCKED_DOMAIN],
                [
                    'value' => $subject,
                    'domain' => $domain,
                    'blockedDomains' => implode(', ', $this->blockedDomains)
                ]
            );
        }

        return $this->errors->empty();
    }
}
