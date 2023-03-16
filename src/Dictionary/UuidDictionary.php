<?php

declare(strict_types=1);

namespace Validator\Dictionary;

class UuidDictionary
{
    public const MUST_BE_AN_UUID = 'mustBeAnUuid';

    public const MESSAGES = [
        self::MUST_BE_AN_UUID => 'Value must be an uuid.',
    ];
}
