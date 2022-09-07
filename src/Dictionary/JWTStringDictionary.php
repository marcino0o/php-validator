<?php

declare(strict_types=1);

namespace Validator\Dictionary;

class JWTStringDictionary
{
    public const MUST_BE_A_JWT_STRING = 'mustBeAnJWTString';

    public const MESSAGES = [
        self::MUST_BE_A_JWT_STRING => 'Value must be a JWT string',
    ];
}
