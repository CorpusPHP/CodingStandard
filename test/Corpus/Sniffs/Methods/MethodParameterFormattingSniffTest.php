<?php

namespace Corpus\Sniffs\Methods;

use SlevomatCodingStandard\Sniffs\TestCase;

class MethodParameterFormattingSniffTest extends TestCase {

	public function testErrors() : void {
		$report = self::checkFile(__DIR__ . '/MethodParameterFormatting.data/example.php');
		$this->assertSame(6, $report->getErrorCount());

		self::assertAllFixedInFile($report);
	}

}
