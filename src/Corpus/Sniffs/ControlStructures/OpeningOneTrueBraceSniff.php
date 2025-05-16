<?php

namespace Corpus\Sniffs\ControlStructures;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Sniff: `Corpus.ControlStructures.OpeningOneTrueBrace`
 *
 * Ensure that the "One True Brace" style is used.
 *
 * **Example:**
 *
 * ```php
 * class Foo
 * {
 *     public function bar()
 *     {
 *         echo "bbq";
 *     }
 * }
 * ```
 *
 * Becomes:
 *
 * ```php
 * class Foo {
 *     public function bar() {
 *         echo "bbq";
 *     }
 * }
 * ```
 *
 * @see https://wiki.c2.com/?OneTrueBraceStyle
 */
class OpeningOneTrueBraceSniff implements Sniff {

	public const CODE_BRACE_ON_NEWLINE = 'BraceOnNewLine';

	public function register() : array {
		return [ T_OPEN_CURLY_BRACKET ];
	}

	public function process( File $phpcsFile, $stackPtr ) : void {
		$tokens = $phpcsFile->getTokens();
		$prev   = $phpcsFile->findPrevious(T_WHITESPACE, $stackPtr - 1, 0, true);
		if( !$prev || $tokens[$prev]['line'] === $tokens[$stackPtr]['line'] ) {
			return;
		}

		if( in_array($tokens[$prev]['code'], [
			T_SEMICOLON,
			T_OPEN_CURLY_BRACKET,
			T_CLOSE_CURLY_BRACKET,
			T_OPEN_TAG,
		], true) ) {
			return;
		}

		$fix = $phpcsFile->addFixableError(
			'Opening brace should be on the same line as the declaration',
			$stackPtr,
			self::CODE_BRACE_ON_NEWLINE
		);
		if( $fix ) {
			$phpcsFile->fixer->beginChangeset();
			for( $i = $prev + 1; $i < $stackPtr; $i++ ) {
				$phpcsFile->fixer->replaceToken($i, $i === $stackPtr - 1 ? ' ' : '');
			}

			$phpcsFile->fixer->endChangeset();
		}
	}

}
