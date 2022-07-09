<?php

namespace Corpus\Sniffs\Methods;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Sniff: `Corpus.Methods.ClosureSpacing`
 *
 * Force whitespace between function/fn keyword and opening paren on closures.
 *
 * **Example:**
 *
 * ```php
 * $foo = function ( string $foo ) { echo $foo; };
 * $bar = fn ( int $bar ) => $bar + 1;
 * ```
 *
 * Becomes:
 *
 * ```php
 * $foo = function( string $foo ) { echo $foo; };
 * $bar = fn( int $bar ) => $bar + 1;
 * ```
 */
class ClosureSpacingSniff implements Sniff {

	public const CODE_BAD_CLOSURE_LEADING_WHITESPACE = 'BadClosureLeadingWhitespace';

	public function register() : array {
		return [
			T_FN,
			T_CLOSURE,
		];
	}

	public function process( File $phpcsFile, $stackPtr ) : void {
		$tokens  = $phpcsFile->getTokens();
		$nextPtr = $stackPtr + 1;

		if( isset($tokens[$nextPtr]['code']) ) {

			if( $tokens[$nextPtr]['code'] !== T_WHITESPACE ) {
				$fix = $phpcsFile->addFixableError('Missing whitespace following closure keyword.', $nextPtr, self::CODE_BAD_CLOSURE_LEADING_WHITESPACE);
				if( $fix === true ) {
					$phpcsFile->fixer->beginChangeset();
					$phpcsFile->fixer->addContentBefore($nextPtr, ' ');
					$phpcsFile->fixer->endChangeset();
				}

				return;
			}

			if($tokens[$nextPtr]['content'] !== ' ') {
				$fix = $phpcsFile->addFixableError('Incorrect whitespace following closure keyword.', $nextPtr, self::CODE_BAD_CLOSURE_LEADING_WHITESPACE);
				if( $fix === true ) {
					$phpcsFile->fixer->beginChangeset();
					$phpcsFile->fixer->replaceToken($nextPtr, ' ');
					$phpcsFile->fixer->endChangeset();
				}
			}
		}
	}

}
