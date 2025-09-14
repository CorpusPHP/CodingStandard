<?php

/**
 * This file is based on code from the Slevomat Coding Standard project.
 *
 * Original work copyright (c) 2015-present Slevomat.cz, s.r.o.
 * Modifications copyright (c) 2025 Jesse Donat / CorpusPHP
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @see https://github.com/slevomat/coding-standard/blob/ba476e9c5dd52107acb17e33a70034d65f380847/LICENSE.md
 * @see https://github.com/slevomat/coding-standard/blob/ba476e9c5dd52107acb17e33a70034d65f380847/SlevomatCodingStandard/Sniffs/TestCase.php
 */

namespace Corpus\Sniffs;

use PHP_CodeSniffer\Config;
use PHP_CodeSniffer\Files\File;
use PHP_CodeSniffer\Files\LocalFile;
use PHP_CodeSniffer\Runner;
use PHP_CodeSniffer\Sniffs\Sniff;
use PHP_CodeSniffer\Util\Common;

/**
 * @codeCoverageIgnore
 */
abstract class TestCase extends \PHPUnit\Framework\TestCase {

	protected const TAB_WIDTH = 0;

	/**
	 * @param array<string, array<int|string, (bool|int|string|null)>|bool|int|string> $sniffProperties
	 * @param list<string>                                                             $codesToCheck
	 * @param list<string>                                                             $cliArgs
	 */
	protected static function checkFile(
		string $filePath,
		array $sniffProperties = [],
		array $codesToCheck = [],
		array $cliArgs = []
	) : File {
		if( \defined('PHP_CODESNIFFER_CBF') === false ) {
			\define('PHP_CODESNIFFER_CBF', false);
		}

		$codeSniffer         = new Runner;
		$codeSniffer->config = new Config(\array_merge([ '-s' ], $cliArgs));
		$codeSniffer->init();

		if( \count($sniffProperties) > 0 ) {
			foreach( $sniffProperties as $name => $value ) {
				$sniffProperties[$name] = [
					'value' => $value,
					'scope' => 'sniff',
				];
			}

			$codeSniffer->ruleset->ruleset[self::getSniffName()]['properties'] = $sniffProperties;
		}

		$sniffClassName = static::getSniffClassName();
		/** @var Sniff $sniff */
		$sniff = new $sniffClassName;

		$codeSniffer->ruleset->sniffs = [ $sniffClassName => $sniff ];

		if( \count($codesToCheck) > 0 ) {
			foreach( self::getSniffClassReflection()->getConstants() as $constantName => $constantValue ) {
				if( \strpos($constantName, 'CODE_') !== 0 || \in_array($constantValue, $codesToCheck, true) ) {
					continue;
				}

				$codeSniffer->ruleset->ruleset[\sprintf('%s.%s', self::getSniffName(), $constantValue)]['severity'] = 0;
			}
		}

		$codeSniffer->ruleset->populateTokenListeners();
		$codeSniffer->config->tabWidth = static::TAB_WIDTH;

		$file = new LocalFile($filePath, $codeSniffer->ruleset, $codeSniffer->config);
		$file->process();

		return $file;
	}

	protected static function assertNoSniffErrorInFile( File $phpcsFile ) : void {
		$errors = $phpcsFile->getErrors();
		$text   = \sprintf('No errors expected, but %d errors found:', \count($errors));
		foreach( $errors as $line => $error ) {
			$text .= \sprintf(
				'%sLine %d:%s%s',
				\PHP_EOL,
				$line,
				\PHP_EOL,
				self::getFormattedErrors($error),
			);
		}

		self::assertEmpty($errors, $text);
	}

	protected static function assertNoSniffWarningInFile( File $phpcsFile ) : void {
		$warnings = $phpcsFile->getWarnings();
		$text     = \sprintf('No warnings expected, but %d warnings found:', \count($warnings));
		foreach( $warnings as $line => $warning ) {
			$text .= \sprintf(
				'%sLine %d:%s%s',
				\PHP_EOL,
				$line,
				\PHP_EOL,
				self::getFormattedErrors($warning),
			);
		}

		self::assertEmpty($warnings, $text);
	}

	protected static function assertSniffError( File $phpcsFile, int $line, string $code, ?string $message = null ) : void {
		$errors = $phpcsFile->getErrors();
		self::assertTrue(isset($errors[$line]), \sprintf('Expected error on line %s, but none found.', $line));

		$sniffCode = \sprintf('%s.%s', self::getSniffName(), $code);

		self::assertTrue(
			self::hasError($errors[$line], $sniffCode, $message),
			\sprintf(
				'Expected error %s%s, but none found on line %d.%sErrors found on line %d:%s%s%s',
				$sniffCode,
				$message !== null
					? \sprintf(' with message "%s"', $message)
					: '',
				$line,
				\PHP_EOL . \PHP_EOL,
				$line,
				\PHP_EOL,
				self::getFormattedErrors($errors[$line]),
				\PHP_EOL,
			),
		);
	}

	protected static function assertSniffWarning( File $phpcsFile, int $line, string $code, ?string $message = null ) : void {
		$errors = $phpcsFile->getWarnings();
		self::assertTrue(isset($errors[$line]), \sprintf('Expected warning on line %s, but none found.', $line));

		$sniffCode = \sprintf('%s.%s', self::getSniffName(), $code);

		self::assertTrue(
			self::hasError($errors[$line], $sniffCode, $message),
			\sprintf(
				'Expected warning %s%s, but none found on line %d.%sWarnings found on line %d:%s%s%s',
				$sniffCode,
				$message !== null
					? \sprintf(' with message "%s"', $message)
					: '',
				$line,
				\PHP_EOL . \PHP_EOL,
				$line,
				\PHP_EOL,
				self::getFormattedErrors($errors[$line]),
				\PHP_EOL,
			),
		);
	}

	protected static function assertNoSniffError( File $phpcsFile, int $line ) : void {
		$errors = $phpcsFile->getErrors();
		self::assertFalse(
			isset($errors[$line]),
			\sprintf(
				'Expected no error on line %s, but found:%s%s%s',
				$line,
				\PHP_EOL . \PHP_EOL,
				isset($errors[$line]) ? self::getFormattedErrors($errors[$line]) : '',
				\PHP_EOL,
			),
		);
	}

	protected static function assertAllFixedInFile( File $phpcsFile ) : void {
		$phpcsFile->disableCaching();
		$phpcsFile->fixer->fixFile();
		self::assertStringEqualsFile(\preg_replace('~(\\.php)$~', '.fixed\\1', $phpcsFile->getFilename()), $phpcsFile->fixer->getContents());
	}

	/**
	 * @return class-string
	 */
	protected static function getSniffClassName() : string {
		/** @var class-string $sniffClassName */
		$sniffClassName = \substr(static::class, 0, -\strlen('Test'));

		return $sniffClassName;
	}

	protected static function getSniffName() : string {
		return Common::getSniffCode(static::getSniffClassName());
	}

	private static function getSniffClassReflection() : \ReflectionClass {
		static $reflections = [];

		$className = static::getSniffClassName();

		return $reflections[$className] ?? $reflections[$className] = new \ReflectionClass($className);
	}

	/**
	 * @param list<list<array{source: string, message: string}>> $errorsOnLine
	 */
	private static function hasError( array $errorsOnLine, string $sniffCode, ?string $message ) : bool {
		$hasError = false;

		foreach( $errorsOnLine as $errorsOnPosition ) {
			foreach( $errorsOnPosition as $error ) {
				/** @var string $errorSource */
				$errorSource = $error['source'];
				/** @var string $errorMessage */
				$errorMessage = $error['message'];

				if(
					$errorSource === $sniffCode
					&& (
						$message === null
						|| \strpos($errorMessage, $message) !== false
					)
				) {
					$hasError = true;
					break;
				}
			}
		}

		return $hasError;
	}

	/**
	 * @param list<list<array{source: string, message: string}>> $errors
	 */
	private static function getFormattedErrors( array $errors ) : string {
		return \implode(
			\PHP_EOL,
			\array_map(
				static fn ( array $errors ) : string => \implode(
					\PHP_EOL,
					\array_map(static fn ( array $error ) : string => \sprintf("\t%s: %s", $error['source'], $error['message']), $errors),
				),
				$errors,
			),
		);
	}

}
