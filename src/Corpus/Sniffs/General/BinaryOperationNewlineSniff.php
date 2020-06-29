<?php

namespace Corpus\Sniffs\General;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

/**
 * Sniff: `Corpus.General.BinaryOperationNewline`
 *
 * Ensure that in multiline logical statments `&&` and `||` lead lines rather than trail.
 *
 * **Example:**
 *
 * ```php
 * if(
 *     $foo &&
 *     $bar &&
 *     $baz
 * ){}
 * ```
 *
 * Becomes:
 *
 * ```php
 * if(
 *     $foo
 *     && $bar
 *     && $baz
 * ){}
 * ```
 *
 */
class BinaryOperationNewlineSniff implements Sniff {

	public const CODE_BOOLEAN_OPERATION_SHOULD_LEAD_LINE = 'BooleanOperationShouldLeadLine';

	/**
	 * @inheritDoc
	 */
	public function register() {
		return [ T_BOOLEAN_AND, T_BOOLEAN_OR ];
	}

	/**
	 * @inheritDoc
	 */
	public function process( File $phpcsFile, $stackPtr ) {
		$tokens = $phpcsFile->getTokens();

		$nextPtr = $phpcsFile->findNext(T_WHITESPACE, $stackPtr + 1, null, true);
		if( $tokens[$stackPtr]['line'] + 1 !== $tokens[$nextPtr]['line'] ) {
			return;
		}

		$fix = $phpcsFile->addFixableError('Boolean %s should start line and not end previous line',
			$stackPtr,
			self::CODE_BOOLEAN_OPERATION_SHOULD_LEAD_LINE,
			[ $tokens[$stackPtr]['content'] ]
		);

		if( $fix ) {
			$phpcsFile->fixer->beginChangeset();
			$phpcsFile->fixer->replaceToken($nextPtr, $tokens[$stackPtr]['content'] . ' ' . $tokens[$nextPtr]['content']);
			$phpcsFile->fixer->replaceToken($stackPtr, '');

			if( $tokens[$stackPtr - 1]['code'] === T_WHITESPACE ) {
				$phpcsFile->fixer->replaceToken($stackPtr - 1, '');
			}

			$phpcsFile->fixer->endChangeset();
		}
	}

}
