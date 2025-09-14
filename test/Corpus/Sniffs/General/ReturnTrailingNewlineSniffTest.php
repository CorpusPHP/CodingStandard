<?php

namespace Corpus\Sniffs\General;

use Corpus\Sniffs\TestCase;

class ReturnTrailingNewlineSniffTest extends TestCase {

	public function testErrors() : void {
		$report = self::checkFile(__DIR__ . '/ReturnTrailingNewline.data/examples.php');
		$this->assertSame(4, $report->getErrorCount());

		self::assertAllFixedInFile($report);
	}

	public function testRootReturn() : void {
		$report = self::checkFile(__DIR__ . '/ReturnTrailingNewline.data/rootreturn.php');
		$this->assertSame(0, $report->getErrorCount());
	}

}
