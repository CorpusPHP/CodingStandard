<?php

namespace Corpus\Sniffs\ControlStructures;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class ClosingBraceNewlineSniff implements Sniff {

	public const CODE_MUST_NEWLINE_FOLLOWING_CURLY_BRACKET = 'MustNewlineFollowingCurlyBracket';

	/**
	 * @inheritDoc
	 */
	public function register() {
		return [ T_CLOSE_CURLY_BRACKET ];
	}

	/**
	 * @inheritDoc
	 */
	public function process( File $phpcsFile, $stackPtr ) {
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

		$fix = $phpcsFile->addFixableError('Must be a newline following closing curly bracket',
			$stackPtr,
			self::CODE_MUST_NEWLINE_FOLLOWING_CURLY_BRACKET);
		if( $fix ) {
			$phpcsFile->fixer->beginChangeset();
			$phpcsFile->fixer->addNewline($stackPtr);
			$phpcsFile->fixer->endChangeset();
		}
	}
}
