<?php

namespace Corpus\Sniffs\General;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Sniff: `Corpus.General.ReturnTrailingNewline`
 *
 * Ensure that no blank lines separate return statements and following curly braces.
 *
 * **Example:**
 *
 * ```php
 * if( $foo == true ){
 *     return 1;
 *
 * }
 * ```
 *
 * Becomes:
 *
 * ```php
 * if( $foo == true ){
 *     return 1;
 * }
 * ```
 */
class ReturnTrailingNewlineSniff implements Sniff {

	public const CODE_RETURN_HAS_TRAILING_NEWLINE = 'ReturnHasTrailingNewline';

	/**
	 * @inheritDoc
	 */
	public function register() {
		return [ T_RETURN ];
	}

	/**
	 * @inheritDoc
	 */
	public function process( File $phpcsFile, $stackPtr ) {
		$tokens = $phpcsFile->getTokens();

		$eosPtr  = $phpcsFile->findEndOfStatement($stackPtr);
		$nextPtr = $phpcsFile->findNext(T_WHITESPACE, $eosPtr + 1, null, true);
		if( !$nextPtr ) {
			return;
		}

		if( $tokens[$nextPtr]['code'] !== T_CLOSE_CURLY_BRACKET ) {
			return;
		}

		if( $tokens[$nextPtr]['line'] <= $tokens[$eosPtr]['line'] + 1 ) {
			return;
		}

		$fix = $phpcsFile->addFixableError(
			'There must be no blank lines between return and the following curly brace',
			$stackPtr,
			self::CODE_RETURN_HAS_TRAILING_NEWLINE
		);
		if( $fix ) {
			$phpcsFile->fixer->beginChangeset();
			for( $removePtr = $eosPtr + 1; $removePtr <= $nextPtr; $removePtr++ ) {
				if( $tokens[$removePtr + 1]['line'] === $tokens[$nextPtr]['line'] ) {
					break;
				}

				$phpcsFile->fixer->replaceToken($removePtr, '');
			}

			$phpcsFile->fixer->endChangeset();
		}
	}

}
