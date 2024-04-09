# ID Base Converter
This package makes converting integer IDs into encoded strings and vice versa easy. You can use a preset symbol set, or you can define your own.


This can be useful if you want to add a layer of obfuscation to your integer IDs by encoding them into strings, which you can then decode back to the original ID.

For example, if you have a URL `https://example-dashboard.com/user/123` and you don't want to expose the exact database ID to the public, you can encode the ID. The URL could then become `https://example-dashboard.com/user/3F`.

## Requirement
PHP 8.0 or higher

## Installation
```bash
composer require princejohnsantillan/id-base-converter
```

## Usage
To use the available symbol sets:

```php
use IdBaseConverter\IdBase;

// Symbols: '0123456789abcdef'
$converter = IdBase::asBase16();

// Symbols: '0123456789ABCDEF'
$converter = IdBase::asBase16uc();

// Symbols: '0123456789abcdefghijklmnopqrstuvwxyz'
$converter = IdBase::asBase36();

// Symbols: '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'
$converter = IdBase::asBase36uc();

// Symbols: '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'
$converter = IdBase::asAlphanumeric();
```

To use your own symbol set:

```php
use IdBaseConverter\IdBase;

$converter = IdBase::symbols("0a1b2c3d4e5f6g7h8i9j");
```

Converting an integer ID:

```php
use IdBaseConverter\IdBase;

IdBase::asBase16()->toString(123); // 7b

IdBase::asBase36uc()->toString(123); // 3F

IdBase::symbols("0a1b2c3d4e5f6g7h8i9j")->toString(123); // 3b
```

Converting an encoded string back to an integer ID:
```php
use IdBaseConverter\IdBase;

IdBase::asBase16()->toInteger('7b'); // 123

IdBase::asBase16uc()->toInteger('3F'); // 123

IdBase::symbols("0a1b2c3d4e5f6g7h8i9j")->toInteger('3b'); // 123
```

Alternatively, you can use the `convert` method to convert an integer ID into an encoded string or vice versa:
```php
use IdBaseConverter\IdBase;

IdBase::asAlphanumeric()->convert(12345); // 3d7

IdBase::asAlphanumeric()->convert('3d7'); // 12345
```
