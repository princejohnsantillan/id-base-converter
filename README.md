# ID Base Converter
This package makes converting integer IDs into encoded strings and vice versa easy. You can use a preset of symbol set, or you can use your own.

This can be useful if you want to add a little abstraction to your integer IDs by encoding it into strings that you can decode back to the original ID.

Let's say you have a url `https://example-dashboard.com/user/123` and you don't want to expose the exact database ID to the public. You can instead encode the ID and have the url become `https://example-dashboard.com/user/3F`.

## Requirement
PHP 8.0 or higher

## Installation
```bash
composer require princejohnsantillan/id-base-converter
```

## Usage
To use the available Symbol sets:

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

Converting an encoded string back to an interger ID:
```php
use IdBaseConverter\IdBase;

IdBase::asBase16()->toInteger('7b'); // 123

IdBase::asBase16uc()->toInteger('3F'); // 123

IdBase::symbols("0a1b2c3d4e5f6g7h8i9j")->toInteger('3b'); // 123
```

Alternatively, you can use the `convert` method to convert an integeger ID into an encoded string and/or vice versa:
```php
use IdBaseConverter\IdBase;

IdBase::asAlphanumeric()->convert(12345); // 3d7

IdBase::asAlphanumeric()->convert('3d7'); // 12345
```
