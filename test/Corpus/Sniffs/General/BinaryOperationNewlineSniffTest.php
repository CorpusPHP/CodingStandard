<?php

namespace Corpus\Sniffs\General;

use SlevomatCodingStandard\Sniffs\TestCase;

class BinaryOperationNewlineSniffTest extends TestCase {

	public function testErrors() : void {
		$report = self::checkFile(__DIR__ . '/BinaryOperationNewline.data/examples.php');
		$this->assertSame(3, $report->getErrorCount());

		self::assertAllFixedInFile($report);
	}

}
