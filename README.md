# ID Base Converter
This package makes converting integer IDs into encoded strings and vice versa easy. You can use a preset of symbol set, or you can create your own. 

## Installation
```bash
composer require princejohnsantillan/id-base-converter
```

## Usage
To use the available Symbol sets:

```php
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
$converter = IdBase::symbols("0a1b2c3d4e5f6g7h8i9j");
```

Converting an integer ID:

```php
IdBase::asBase16()->toString(123); // 7b

IdBase::asBase36uc()->toString(123); // 3F

IdBase::symbols("0a1b2c3d4e5f6g7h8i9j")->toString(123); // 3b
```

Converting an encoded string back to an interger ID:
```php
IdBase::asBase16()->toInteger('7b'); // 123

IdBase::asBase16uc()->toInteger('3F'); // 123

IdBase::symbols("0a1b2c3d4e5f6g7h8i9j")->toInteger('3b'); // 123
```

Alternatively, you can use the `convert` method to convert an integeger ID into an encoded string or vice versa:
```php
IdBase::asAlphanumeric()->convert(12345); // 3d7

IdBase::asAlphanumeric()->convert('3d7'); // 12345
```
