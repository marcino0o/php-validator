<?php

declare(strict_types=1);

namespace Validator\Dictionary;

class FieldDictionary
{
    public const FIELD_IS_REQUIRED = 'fieldRequired';
    public const FIELD_IS_NOT_NULLABLE = 'nullNotAllowed';

    public const MESSAGES = [
        self::FIELD_IS_REQUIRED => 'Field is required.',
        self::FIELD_IS_NOT_NULLABLE => 'Field value can\'t be null.',
    ];
}
