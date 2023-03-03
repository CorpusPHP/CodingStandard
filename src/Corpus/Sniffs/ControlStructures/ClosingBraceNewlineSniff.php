<?php

namespace Corpus\Sniffs\ControlStructures;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Sniff: `Corpus.ControlStructures.ClosingBraceNewline`
 *
 * Ensure that all closing curly brackets are followed by a blank line.
 *
 * **Example:**
 *
 * ```php
 * if( $foo ) {
 *     echo $bar;
 * }
 * echo $baz;
 * ```
 *
 * Becomes:
 *
 * ```php
 * if( $foo ) {
 *     echo $bar;
 * }
 *
 * echo $baz;
 * ```
 */
class ClosingBraceNewlineSniff implements Sniff {

	public const CODE_MUST_NEWLINE_FOLLOWING_CURLY_BRACKET = 'MustNewlineFollowingCurlyBracket';

	public function register() : array {
		return [ T_CLOSE_CURLY_BRACKET ];
	}

	public function process( File $phpcsFile, $stackPtr ) : void {
		$tokens = $phpcsFile->getTokens();

		$prevPtr = $phpcsFile->findPrevious(T_WHITESPACE, $stackPtr - 1, null, true);
		if( $tokens[$prevPtr]['line'] === $tokens[$stackPtr]['line'] ) {
			return;
		}

		$nextPtr = $phpcsFile->findNext([ T_WHITESPACE ], $stackPtr + 1, null, true);
		if( $tokens[$nextPtr]['line'] !== $tokens[$stackPtr]['line'] + 1 ) {
			return;
		}

		if( $tokens[$stackPtr - 1]['code'] !== T_WHITESPACE || $tokens[$nextPtr - 1]['code'] !== T_WHITESPACE ) {
			return;
		}

		if( $tokens[$nextPtr]['code'] === T_CLOSE_TAG ) {
			return;
		}

		if( $tokens[$stackPtr - 1]['content'] !== $tokens[$nextPtr - 1]['content'] ) {
			return;
		}

		$fix = $phpcsFile->addFixableError(
			'Must be a newline following closing curly bracket',
			$stackPtr,
			self::CODE_MUST_NEWLINE_FOLLOWING_CURLY_BRACKET
		);
		if( $fix ) {
			$phpcsFile->fixer->beginChangeset();
			$phpcsFile->fixer->addNewline($stackPtr);
			$phpcsFile->fixer->endChangeset();
		}
	}

}
