<?php

declare(strict_types=1);

namespace Validator\Dictionary;

class EmailDictionary
{
    public const MUST_BE_AN_EMAIL = 'mustBeAnEmail';
    public const MUST_HAVE_VALID_DOMAIN = 'mustHaveValidDomain';
    public const MUST_BE_IN_ALLOWED_DOMAIN = 'mustBeInAllowedDomain';
    public const MUST_NOT_BE_IN_BLOCKED_DOMAIN = 'mustNotBeInBlockedDomain';

    /** @var array|string[]  */
    public const MESSAGES = [
        self::MUST_BE_AN_EMAIL => 'Value must be an email address',
        self::MUST_HAVE_VALID_DOMAIN => 'Email address must have a valid domain',
        self::MUST_BE_IN_ALLOWED_DOMAIN => 'Only email address in on of: {{ allowedDomains }} domains are allowed',
        self::MUST_NOT_BE_IN_BLOCKED_DOMAIN => 'Email address in domain {{ domain }} are not allowed',
    ];
}
