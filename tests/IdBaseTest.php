<?php

declare(strict_types=1);

namespace IdBaseConverter\Test;

use IdBaseConverter\IdBase;
use PHPUnit\Framework\TestCase;

final class IdBaseTest extends TestCase
{
    private array $idSet = [
        9,
        98,
        987,
        9876,
        98765,
        987654,
        9876543,
        98765432,
        987654321,
        9876543210,
    ];

    public function testBase16Conversion(): void
    {
        $converter = IdBase::asBase16();
        $converterWithOptions = IdBase::asBase16([
            'length' => 16,
            'padding' => '0',
            'prefix' => 'test-',
            'postfix' => '-test',
        ]);

        foreach ($this->idSet as $id) {
            $this->assertSame($converter->convert($converter->convert($id)), $id);

            $this->assertSame($converterWithOptions->convert($converterWithOptions->convert($id)), $id);
        }
    }

    public function testBase16ucConversion(): void
    {
        $converter = IdBase::asBase16uc();
        $converterWithOptions = IdBase::asBase16uc([
            'length' => 16,
            'padding' => '0',
            'prefix' => 'TEST-',
            'postfix' => '-TEST',
        ]);

        foreach ($this->idSet as $id) {
            $this->assertSame($converter->convert($converter->convert($id)), $id);

            $this->assertSame($converterWithOptions->convert($converterWithOptions->convert($id)), $id);
        }
    }

    public function testBase36Conversion(): void
    {
        $converter = IdBase::asBase36();
        $converterWithOptions = IdBase::asBase36([
            'length' => 36,
            'padding' => '0',
            'prefix' => 't',
            'postfix' => 't',
        ]);

        foreach ($this->idSet as $id) {
            $this->assertSame($converter->convert($converter->convert($id)), $id);

            $this->assertSame($converterWithOptions->convert($converterWithOptions->convert($id)), $id);
        }
    }

    public function testBase36ucConversion(): void
    {
        $converter = IdBase::asBase36uc();
        $converterWithOptions = IdBase::asBase36uc([
            'length' => 36,
            'padding' => '0',
            'prefix' => 'T',
            'postfix' => 'T',
        ]);

        foreach ($this->idSet as $id) {
            $this->assertSame($converter->convert($converter->convert($id)), $id);

            $this->assertSame($converterWithOptions->convert($converterWithOptions->convert($id)), $id);
        }
    }

    public function tesAlphanumericConversion(): void
    {
        $converter = IdBase::asBase16uc();
        $converterWithOptions = IdBase::asBase16uc([
            'length' => 20,
            'padding' => '0',
            'prefix' => 'A1-',
            'postfix' => '-A1',
        ]);

        foreach ($this->idSet as $id) {
            $this->assertSame($converter->convert($converter->convert($id)), $id);

            $this->assertSame($converterWithOptions->convert($converterWithOptions->convert($id)), $id);
        }
    }

    public function tesUserDefinedSymbolsConversion(): void
    {
        $converter = IdBase::symbols('0aA1bB2cC3dD4eE5fF6gG7hH8iI9jJ');
        $converterWithOptions = IdBase::symbols('0aA1bB2cC3dD4eE5fF6gG7hH8iI9jJ', [
            'length' => 20,
            'padding' => '*',
            'prefix' => 'UD',
            'postfix' => '--',
        ]);

        foreach ($this->idSet as $id) {
            $this->assertSame($converter->convert($converter->convert($id)), $id);

            $this->assertSame($converterWithOptions->convert($converterWithOptions->convert($id)), $id);
        }
    }

    //Todo: 
    // - fix phpunit setup
    // - add test errors/exceptions
    // - add github action lint, test, and changelog     
}
