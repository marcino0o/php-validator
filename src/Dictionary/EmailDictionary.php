<?php

declare(strict_types=1);

namespace Validator\Dictionary;

class EmailDictionary
{
    public const MUST_BE_AN_EMAIL = 'mustBeAnEmail';
    public const MUST_HAVE_VALID_DOMAIN = 'mustHaveValidDomain';

    /** @var array|string[]  */
    public const MESSAGES = [
        self::MUST_BE_AN_EMAIL => 'Value must be an email',
        self::MUST_HAVE_VALID_DOMAIN => 'Email must have a valid domain',
    ];
}
