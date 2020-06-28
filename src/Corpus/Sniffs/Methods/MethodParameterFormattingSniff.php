<?php

namespace Corpus\Sniffs\Methods;

use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Sniffs\Sniff;

class MethodParameterFormattingSniff implements Sniff {

	public $maxLength = 130;

	public const CODE_OVERLY_LONG_ARGUMENT_LIST = 'OverlyLongArgumentList';

	public function register() {
		return [ T_FUNCTION, T_CLOSURE ];
	}

	public function process( File $phpcsFile, $stackPtr ) {
		$tokens = $phpcsFile->getTokens();

		$scopePtr = $tokens[$stackPtr]['scope_opener'] ?? $phpcsFile->findEndOfStatement($stackPtr);

		if( $tokens[$stackPtr]['line'] !== $tokens[$scopePtr]['line'] ) {
			return;
		}

		if( $tokens[$scopePtr]['column'] < $this->maxLength ) {
			return;
		}


		$stmtStartPtr = $phpcsFile->findFirstOnLine([], $stackPtr, true);
		if( $tokens[$stmtStartPtr]['code'] === T_WHITESPACE ) {
			$stmtStartPtr++;
		}

		$indent = str_repeat("\t", $tokens[$stmtStartPtr]['column']);

		$fix = $phpcsFile->addFixableError(
			"Single line function definition exceeds %d characters",
			$stackPtr,
			self::CODE_OVERLY_LONG_ARGUMENT_LIST,
			[ $this->maxLength ]
		);

		if( $fix === true ) {
			$startPtr = $tokens[$stackPtr]['parenthesis_opener'];
			$endPtr   = $tokens[$stackPtr]['parenthesis_closer'];
			$phpcsFile->fixer->beginChangeset();

			if( $tokens[$startPtr + 1]['code'] === T_WHITESPACE ) {
				$phpcsFile->fixer->replaceToken($startPtr + 1, '');
			}

			$phpcsFile->fixer->addContent($startPtr, $phpcsFile->eolChar . $indent);

			for( $ptr = $stackPtr + 1; $ptr < $endPtr; $ptr++ ) {
				if( $tokens[$ptr]['code'] === T_COMMA ) {
					if( $tokens[$ptr + 1]['code'] === T_WHITESPACE ) {
						$phpcsFile->fixer->replaceToken($ptr + 1, '');
					}

					$phpcsFile->fixer->addContent($ptr, $phpcsFile->eolChar . $indent);
				}
			}

			if( $tokens[$endPtr - 1]['code'] === T_WHITESPACE ) {
				$phpcsFile->fixer->replaceToken($endPtr - 1, '');
			}

			$phpcsFile->fixer->addContentBefore(
				$endPtr,
				$phpcsFile->eolChar . str_repeat("\t", $tokens[$stmtStartPtr]['column'] - 1)
			);

			$phpcsFile->fixer->endChangeset();
		}
	}

}
