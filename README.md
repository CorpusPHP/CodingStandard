# Corpus Coding Standard

[![Latest Stable Version](https://poser.pugx.org/corpus/coding-standard/version)](https://packagist.org/packages/corpus/coding-standard)
[![Total Downloads](https://poser.pugx.org/corpus/coding-standard/downloads)](https://packagist.org/packages/corpus/coding-standard)
[![License](https://poser.pugx.org/corpus/coding-standard/license)](https://packagist.org/packages/corpus/coding-standard)
[![Build Status](https://github.com/CorpusPHP/CodingStandard/workflows/CI/badge.svg?)](https://github.com/CorpusPHP/CodingStandard/actions?query=workflow%3ACI)


Corpus Coding Standard for [PHP_CodeSniffer](https://github.com/squizlabs/PHP_CodeSniffer).

## Requirements

- **dealerdirect/phpcodesniffer-composer-installer**: *
- **squizlabs/php_codesniffer**: *
- **slevomat/coding-standard**: ~6.4.1
- **php**: >=7.1

## Installing

Install the latest version with:

```bash
composer require --dev 'corpus/coding-standard'
```

## Sniffs

### Class: \Corpus\Sniffs\ControlStructures\ClosingBraceNewlineSniff

Sniff: `Corpus.ControlStructures.ClosingBraceNewline`

Ensure that all closing curly brackets are followed by a blank line.

```php
<?php
namespace Corpus\Sniffs\ControlStructures;

class ClosingBraceNewlineSniff {
	public const CODE_MUST_NEWLINE_FOLLOWING_CURLY_BRACKET = 'MustNewlineFollowingCurlyBracket';
}
```

### Class: \Corpus\Sniffs\ControlStructures\OpeningOneTrueBraceSniff

Sniff: `Corpus.ControlStructures.OpeningOneTrueBrace`

Ensure that the K&R "One True Brace" style is used.

```php
<?php
namespace Corpus\Sniffs\ControlStructures;

class OpeningOneTrueBraceSniff {
	public const CODE_BRACE_ON_NEWLINE = 'BraceOnNewLine';
}
```

### Class: \Corpus\Sniffs\General\BinaryOperationNewlineSniff

Sniff: `Corpus.General.BinaryOperationNewline`

Ensure that in multiline logical statments `&&` and `||` lead lines rather than trail.

**Example:**

```
if(
    $foo &&
    $bar &&
    $baz
)}
```

becomes

```php
if(
    $foo
    && $bar
    && $baz
)}
```

```php
<?php
namespace Corpus\Sniffs\General;

class BinaryOperationNewlineSniff {
	public const CODE_BOOLEAN_OPERATION_SHOULD_LEAD_LINE = 'BooleanOperationShouldLeadLine';
}
```