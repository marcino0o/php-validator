<?php

declare(strict_types=1);

namespace Validator\Dictionary;

class TypeStringDictionary
{
    public const VALUE_MUST_BE_A_STRING = 'valueMustBeAString';
    public const LENGTH_TOO_SHORT = 'lengthTooShort';
    public const LENGTH_TOO_LONG = 'lengthTooLong';
    public const NOT_ALLOWED_VALUE = 'notAllowedValue';

    public const MESSAGES = [
        self::VALUE_MUST_BE_A_STRING => 'Value must be a string',
        self::LENGTH_TOO_SHORT => 'Value must be at least {{ minLength }} characters long, got {{ length }}',
        self::LENGTH_TOO_LONG => 'Value can\'t be longer then {{ maxLength }} characters, got {{ length }}',
        self::NOT_ALLOWED_VALUE => 'Value must be one of {{ allowedValues }}, got {{ value }}',
    ];
}
