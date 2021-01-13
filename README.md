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

**Example:**

```php
if( $foo ) {
    echo $bar;
}
echo $baz;
```

Becomes:

```php
if( $foo ) {
    echo $bar;
}

echo $baz;
```

### Class: \Corpus\Sniffs\ControlStructures\OpeningOneTrueBraceSniff

Sniff: `Corpus.ControlStructures.OpeningOneTrueBrace`

Ensure that the K&R "One True Brace" style is used.

**Example:**

```php
class Foo
{
    public function bar()
    {
        echo "bbq";
    }
}
```

Becomes:

```php
class Foo {
    public function bar() {
        echo "bbq";
    }
}
```

### Class: \Corpus\Sniffs\General\BinaryOperationNewlineSniff

Sniff: `Corpus.General.BinaryOperationNewline`

Ensure that in multiline logical statements `&&` and `||` lead lines rather than trail.

**Example:**

```php
if(
    $foo &&
    $bar &&
    $baz
)}
```

Becomes:

```php
if(
    $foo
    && $bar
    && $baz
)}
```

### Class: \Corpus\Sniffs\General\ReturnTrailingNewlineSniff

Sniff: `Corpus.General.ReturnTrailingNewline`

Ensure that no blank lines separate return statements and following curly braces.

**Example:**

```php
if( $foo == true ){
    return 1;

}
```

Becomes:

```php
if( $foo == true ){
    return 1;
}
```

### Class: \Corpus\Sniffs\Methods\MethodParameterFormattingSniff

Sniff: `Corpus.Methods.MethodParameterFormatting`

Set a maximum length for function arguments. Fix by breaking into multiple lines.

**Example:**

```php
function Foo( ClosingBraceNewlineSniffTest $closingBraceNewlineSniffTest, OpeningOneTrueBraceSniffTest $openingOneTrueBraceSniffTest ) }
```

 Becomes:

```php
function Foo(
    ClosingBraceNewlineSniffTest $closingBraceNewlineSniffTest,
    OpeningOneTrueBraceSniffTest $openingOneTrueBraceSniffTest
) }
```

```php
<?php
namespace Corpus\Sniffs\Methods;

class MethodParameterFormattingSniff {
	/**
	 * Maximum line character length after which to break function arguments into newlines
	 */
	public $maxLength = 130;
}
```

### Inherited Sniffs

- [Generic.ControlStructures.InlineControlStructure](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Generic/Sniffs/ControlStructures/InlineControlStructureSniff.php)  
- [Generic.WhiteSpace.DisallowSpaceIndent](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Generic/Sniffs/WhiteSpace/DisallowSpaceIndentSniff.php)  
- [Generic.Files.ByteOrderMark](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Generic/Sniffs/Files/ByteOrderMarkSniff.php)  
- [Generic.Files.LineEndings](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Generic/Sniffs/Files/LineEndingsSniff.php)  
- [Generic.PHP.LowerCaseConstant](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Generic/Sniffs/PHP/LowerCaseConstantSniff.php)  
- [Generic.PHP.LowerCaseKeyword](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Generic/Sniffs/PHP/LowerCaseKeywordSniff.php)  
- [Generic.PHP.DeprecatedFunctions](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Generic/Sniffs/PHP/DeprecatedFunctionsSniff.php)  
- [Generic.NamingConventions.UpperCaseConstantName](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Generic/Sniffs/NamingConventions/UpperCaseConstantNameSniff.php)  
- [Generic.Formatting.NoSpaceAfterCast](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Generic/Sniffs/Formatting/NoSpaceAfterCastSniff.php)  
- [PSR2.Files.ClosingTag](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/PSR2/Sniffs/Files/ClosingTagSniff.php)  
- [PSR2.Classes.PropertyDeclaration](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/PSR2/Sniffs/Classes/PropertyDeclarationSniff.php)  
- [PEAR.Functions.ValidDefaultValue](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/PEAR/Sniffs/Functions/ValidDefaultValueSniff.php)  
- [Squiz.Classes.LowercaseClassKeywords](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Squiz/Sniffs/Classes/LowercaseClassKeywordsSniff.php)  
- [Squiz.Classes.SelfMemberReference](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Squiz/Sniffs/Classes/SelfMemberReferenceSniff.php)  
- [Squiz.Scope.MethodScope](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/Squiz/Sniffs/Scope/MethodScopeSniff.php)  
- [SlevomatCodingStandard.Namespaces.UnusedUses](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardnamespacesunuseduses-)  
- [SlevomatCodingStandard.Namespaces.DisallowGroupUse](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardnamespacesdisallowgroupuse)  
- [SlevomatCodingStandard.Namespaces.MultipleUsesPerLine](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardnamespacesmultipleusesperline)  
- [SlevomatCodingStandard.Namespaces.UseDoesNotStartWithBackslash](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardnamespacesusedoesnotstartwithbackslash-)  
- [SlevomatCodingStandard.Classes.TraitUseDeclaration](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardclassestraitusedeclaration-)  
- [SlevomatCodingStandard.Functions.UnusedInheritedVariablePassedToClosure](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardfunctionsunusedinheritedvariablepassedtoclosure-)  
- [SlevomatCodingStandard.Functions.UselessParameterDefaultValue](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardfunctionsuselessparameterdefaultvalue-)  
- [SlevomatCodingStandard.Arrays.DisallowImplicitArrayCreation](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardarraysdisallowimplicitarraycreation)  
- [SlevomatCodingStandard.ControlStructures.DisallowContinueWithoutIntegerOperandInSwitch](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardcontrolstructuresdisallowcontinuewithoutintegeroperandinswitch-)  
- [SlevomatCodingStandard.Namespaces.UseFromSameNamespace](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardnamespacesusefromsamenamespace-)  
- [SlevomatCodingStandard.Arrays.TrailingArrayComma](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardarraystrailingarraycomma-)  
- [SlevomatCodingStandard.ControlStructures.RequireNullCoalesceOperator](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardcontrolstructuresrequirenullcoalesceoperator-)  
- [SlevomatCodingStandard.ControlStructures.RequireShortTernaryOperator](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardcontrolstructuresrequireshortternaryoperator-)  
- [SlevomatCodingStandard.ControlStructures.UselessIfConditionWithReturn](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardcontrolstructuresuselessifconditionwithreturn-)  
- [SlevomatCodingStandard.ControlStructures.UselessTernaryOperator](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardcontrolstructuresuselessternaryoperator-)  
- [SlevomatCodingStandard.Namespaces.AlphabeticallySortedUses](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardnamespacesalphabeticallysorteduses-)  
- [SlevomatCodingStandard.Namespaces.UselessAlias](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardnamespacesuselessalias-)  
- [SlevomatCodingStandard.PHP.UselessSemicolon](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardphpuselesssemicolon-)  
- [SlevomatCodingStandard.TypeHints.NullableTypeForNullDefaultValue](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardtypehintsnullabletypefornulldefaultvalue-)  
- [SlevomatCodingStandard.Classes.EmptyLinesAroundClassBraces](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardclassesemptylinesaroundclassbraces-)  
- [SlevomatCodingStandard.Variables.UselessVariable](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardvariablesuselessvariable-)  
- [SlevomatCodingStandard.Operators.SpreadOperatorSpacing](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardoperatorsspreadoperatorspacing-)  
- [SlevomatCodingStandard.Classes.ParentCallSpacing](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardclassesparentcallspacing-)  
- [SlevomatCodingStandard.ControlStructures.NewWithoutParentheses](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardcontrolstructuresnewwithoutparentheses-)  
- [SlevomatCodingStandard.Commenting.UselessFunctionDocComment](https://github.com/slevomat/coding-standard/blob/master/README.md#slevomatcodingstandardcommentinguselessfunctiondoccomment-)