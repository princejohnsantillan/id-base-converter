<?php

namespace IdBaseConverter\Exceptions;

use Exception;

class InvalidSymbolsException extends Exception
{
    public static function mustBeUnique(): self
    {
        return new self('Symbols must be unique');
    }

    public static function mustBeAtLeastTwoSymbols(): self
    {
        return new self('More than 1 symbol is required');
    }
}
