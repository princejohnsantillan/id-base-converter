<?php

namespace IdBaseConverter;

use IdBaseConverter\Exceptions\InvalidPaddingException;
use IdBaseConverter\Exceptions\InvalidSymbolsException;
use IdBaseConverter\Exceptions\UnidentifiedSymbolException;

/**
 * ID Base Converter - Covert intrger ID into encoded string and vice versa.
 */
class IdBase
{
    public const BASE16 = '0123456789abcdef';

    public const BASE16UC = '0123456789ABCDEF';

    public const BASE36 = '0123456789abcdefghijklmnopqrstuvwxyz';

    public const BASE36UC = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';

    public const ALPHANUMERIC = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';

    /** @var array<string> */
    private array $symbolsArray;

    private int $base;

    /**
     * @throws InvalidSymbolsException
     * @throws InvalidPaddingException
     */
    public function __construct(
        private string $symbols = self::ALPHANUMERIC,
        private ?int $length = null,
        private ?string $padding = null,
        private string $prefix = '',
        private string $postfix = ''
    ) {
        $this->symbolsArray = str_split($symbols);

        $this->base = strlen($symbols);

        $this->analyseSymbols();

        $this->setPadding($padding);
    }

    /**
     * @throws InvalidSymbolsException
     */
    private function analyseSymbols(): void
    {
        if ($this->base <= 1) {
            throw InvalidSymbolsException::mustBeAtLeastTwoSymbols();
        }

        if ($this->base !== count(array_unique($this->symbolsArray))) {
            throw InvalidSymbolsException::mustBeUnique();
        }
    }

    /**
     * @throws InvalidPaddingException
     */
    private function setPadding(?string $padding): void
    {
        $firstSymbol = $this->symbols[0];

        if ($padding === null || $padding === $firstSymbol) {
            $this->padding = $firstSymbol;

            return;
        }

        if (strlen($padding) > 1) {
            throw InvalidPaddingException::mustBeASingleCharacter();
        }

        if (in_array($padding, $this->symbolsArray)) {
            throw InvalidPaddingException::mustBeAllowableCharacter();
        }

        $this->padding = $padding;
    }

    public function getBase(): int
    {
        return $this->base;
    }

    /**
     * @param array{length?: int, padding?: string, prefix?: string, postfix?: string} $options
     * @return IdBase
     * @throws InvalidPaddingException
     * @throws InvalidSymbolsException
     */
    public static function asBase16(array $options = []): IdBase
    {
        return new IdBase(self::BASE16, ...$options);
    }

    /**
     * @param array{length?: int, padding?: string, prefix?: string, postfix?: string} $options
     * @return IdBase
     * @throws InvalidPaddingException
     * @throws InvalidSymbolsException
     */
    public static function asBase16uc(array $options = []): IdBase
    {
        return new IdBase(self::BASE16UC, ...$options);
    }

    /**
     * @param array{length?: int, padding?: string, prefix?: string, postfix?: string} $options
     * @return IdBase
     * @throws InvalidPaddingException
     * @throws InvalidSymbolsException
     */
    public static function asBase36(array $options = []): IdBase
    {
        return new IdBase(self::BASE36, ...$options);
    }

    /**
     * @param array{length?: int, padding?: string, prefix?: string, postfix?: string} $options
     * @return IdBase
     * @throws InvalidPaddingException
     * @throws InvalidSymbolsException
     */
    public static function asBase36uc(array $options = []): IdBase
    {
        return new IdBase(self::BASE36UC, ...$options);
    }

    /**
     * @param array{length?: int, padding?: string, prefix?: string, postfix?: string} $options
     * @return IdBase
     * @throws InvalidPaddingException
     * @throws InvalidSymbolsException
     */
    public static function asAlphanumeric(array $options = []): IdBase
    {
        return new IdBase(self::ALPHANUMERIC, ...$options);
    }

    /**
     * @param string $symbols
     * @param array{length?: int, padding?: string, prefix?: string, postfix?: string} $options
     * @return IdBase
     * @throws InvalidPaddingException
     * @throws InvalidSymbolsException
     */
    public static function symbols(string $symbols, array $options = []): IdBase
    {
        return new IdBase($symbols, ...$options);
    }

    public function toString(int $value): string
    {
        $convertedId = '';

        while ($value) {
            $remainder = $value % $this->base;
            $value = floor($value / $this->base);
            $convertedId = $this->symbolsArray[$remainder].$convertedId;
        }

        return $this->applyModifiers($convertedId);
    }

    private function applyModifiers(string $string): string
    {
        if ($this->length !== null && $this->padding !== null) {
            $string = str_pad(
                string: $string,
                length: $this->length,
                pad_string: $this->padding,
                pad_type: STR_PAD_LEFT
            );
        }

        return $this->prefix.$string.$this->postfix;
    }

    /**
     * @throws UnidentifiedSymbolException
     */
    public function toInteger(string $value): int
    {
        $value = $this->sanitize($value);

        $convertedId = 0;

        $valueLength = strlen($value);

        foreach (str_split($value) as $index => $symbol) {
            $position = strpos($this->symbols, $symbol);

            if ($position === false) {
                throw UnidentifiedSymbolException::symbol($symbol);
            }

            $convertedId += $position * pow($this->base, $valueLength - $index - 1);
        }

        return $convertedId;
    }

    private function sanitize(string $value): string
    {
        //Remove Prefix
        if ($this->prefix !== '' && str_starts_with(strtoupper($value), strtoupper($this->prefix))) {
            $value = substr($value, strlen($this->prefix));
        }

        //Remove Postfix
        if ($this->postfix !== '' && str_ends_with(strtoupper($value), strtoupper($this->postfix))) {
            $value = substr($value, 0, strlen($this->postfix) * -1);
        }

        //Remove Padding
        if ($this->length !== null && strlen($value) >= $this->length) {
            $valueArray = str_split($value);

            foreach ($valueArray as $index => $symbol) {
                if ($symbol != $this->padding) {
                    break;
                }

                unset($valueArray[$index]);
            }

            $value = implode('', $valueArray);
        }

        return $value;
    }

    /**
     * @throws UnidentifiedSymbolException
     */
    public function convert(string|int $value): string|int
    {
        return is_string($value)
          ? $this->toInteger($value)
          : $this->toString($value);
    }
}
