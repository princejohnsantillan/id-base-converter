<?php

namespace IdBaseConverter\Exceptions;

use Exception;

class UnidentifiedSymbolException extends Exception
{
    public static function symbol(string $symbol): self
    {
        return new self("Unidentified symbol: {$symbol}");
    }
}
