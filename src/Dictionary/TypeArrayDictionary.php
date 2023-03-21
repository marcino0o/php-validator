<?php

declare(strict_types=1);

namespace Validator\Dictionary;

class TypeArrayDictionary
{
    public const MUST_BE_AN_ARRAY = 'mustBeAnArray';
    public const MUST_NOT_HAVE_OTHER_KEYS = 'mustNotHaveOtherKeys';
    public const MUST_HAVE_REQUIRED_KEYS = 'mustHaveRequiredKeys';
    public const MUST_NOT_BE_EMPTY = 'mustNotBeEmpty';

    public const MESSAGES = [
        self::MUST_BE_AN_ARRAY => 'Value must be an array',
        self::MUST_NOT_HAVE_OTHER_KEYS =>
            'Array can\'t have keys other than: {{ allowedKeys }}, got: {{ forbiddenKeys }}',
        self::MUST_HAVE_REQUIRED_KEYS => 'Array must have keys: {{ requiredKeys }}, missing: {{ missingKeys }}',
        self::MUST_NOT_BE_EMPTY => 'Array must not be empty.',
    ];
}
