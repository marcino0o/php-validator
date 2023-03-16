<?php

declare(strict_types=1);

namespace Validator\Dictionary;

class NumberDictionary
{
    public const MUST_BE_A_NUMBER = 'mustBeANumber';
    public const MUST_BE_AN_INTEGER_NUMBER = 'mustBeAnIntegerNumber';
    public const MUST_BE_A_FLOAT_NUMBER = 'mustBeAFloatNumber';
    public const MUST_BE_LEQ_THAN = 'mustBeLowerOrEqualThan';
    public const MUST_BE_GEQ_THAN = 'mustBeGraterOrEqualThan';

    public const MESSAGES = [
        self::MUST_BE_A_NUMBER => 'Value must be a number',
        self::MUST_BE_AN_INTEGER_NUMBER => 'Value must be an integer number',
        self::MUST_BE_A_FLOAT_NUMBER => 'Value must be a float number',
        self::MUST_BE_LEQ_THAN => 'Value must be lower or equal that {{ max }}',
        self::MUST_BE_GEQ_THAN => 'Value must be grater or equal that {{ min }}',
    ];
}
