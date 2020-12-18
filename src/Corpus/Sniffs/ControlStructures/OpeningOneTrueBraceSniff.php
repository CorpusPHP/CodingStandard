<?php

namespace Corpus\Sniffs\ControlStructures;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class OpeningOneTrueBraceSniff implements Sniff {

	public const CODE_BRACE_ON_NEWLINE = 'BraceOnNewLine';

	/**
	 * @inheritDoc
	 */
	public function register() {
		return [ T_OPEN_CURLY_BRACKET ];
	}

	/**
	 * @inheritDoc
	 */
	public function process( File $phpcsFile, $stackPtr ) {
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
			self::CODE_BRACE_ON_NEWLINE);
		if( $fix ) {
			$phpcsFile->fixer->beginChangeset();
			for( $i = $prev + 1; $i < $stackPtr; $i++ ) {
				$phpcsFile->fixer->replaceToken($i, $i === $stackPtr - 1 ? ' ' : '');
			}

			$phpcsFile->fixer->endChangeset();
		}
	}

}
