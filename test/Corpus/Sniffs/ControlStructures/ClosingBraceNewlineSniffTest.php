<?php

namespace Corpus\Sniffs\ControlStructures;

use Corpus\Sniffs\TestCase;

class ClosingBraceNewlineSniffTest extends TestCase {

	public function testErrors() : void {
		$report = self::checkFile(__DIR__ . '/ClosingBraceNewline.data/examples.php');
		$this->assertSame(3, $report->getErrorCount());

		self::assertAllFixedInFile($report);
	}

}
