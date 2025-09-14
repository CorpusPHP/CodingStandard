<?php

namespace Corpus\Sniffs\ControlStructures;

use Corpus\Sniffs\TestCase;

class OpeningOneTrueBraceSniffTest extends TestCase {

	public function testErrors() : void {
		$report = self::checkFile(__DIR__ . '/OpeningOneTrueBrace.data/examples.php');
		$this->assertSame(4, $report->getErrorCount());

		self::assertAllFixedInFile($report);
	}

	public function testNoErrors() : void {
		$report = self::checkFile(__DIR__ . '/OpeningOneTrueBrace.data/noerrors.php');
		self::assertNoSniffErrorInFile($report);
	}

}
