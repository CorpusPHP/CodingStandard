<?php

namespace Corpus\Sniffs\Methods;

use SlevomatCodingStandard\Sniffs\TestCase;

class ClosureSpacingSniffTest extends TestCase {

	public function testErrors() : void {
		$report = self::checkFile(__DIR__ . '/ClosureSpacingSniff.data/example.php');
		$this->assertSame(3, $report->getErrorCount());

		self::assertAllFixedInFile($report);
	}

}
