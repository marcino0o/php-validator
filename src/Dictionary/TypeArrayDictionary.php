<?php

declare(strict_types=1);

namespace Validator\Dictionary;

class TypeArrayDictionary
{
    public const MUST_BE_AN_ARRAY = 'mustBeAnArray';

    public const MESSAGES = [
        self::MUST_BE_AN_ARRAY => 'Value must be an array',
    ];
}
