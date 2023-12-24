<?php

namespace IdBaseConverter\Exceptions;

use Exception;

class InvalidPaddingException extends Exception
{
    public static function mustBeASingleCharacter(): self
    {
        return new self('Padding must be a single character');
    }

    public static function mustBeAllowableCharacter(): self
    {
        return new self('Padding cannot be one of the non-first symbols');
    }
}
