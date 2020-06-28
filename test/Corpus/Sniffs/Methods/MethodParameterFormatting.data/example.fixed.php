<?php

use Corpus\Sniffs\ControlStructures\ClosingBraceNewlineSniffTest;
use Corpus\Sniffs\ControlStructures\OpeningOneTrueBraceSniffTest;

function Foo(
	ClosingBraceNewlineSniffTest $closingBraceNewlineSniffTest,
	OpeningOneTrueBraceSniffTest $openingOneTrueBraceSniffTest
) {
}

$foo = function (
	Corpus\Sniffs\ControlStructures\ClosingBraceNewlineSniff $closingBraceNewlineSniff,
	Corpus\Sniffs\ControlStructures\OpeningOneTrueBraceSniff $openingOneTrueBraceSniff
) { };

$di->set('closingBraceNewlineSniffTest', function (
	ClosingBraceNewlineSniff $dbRead,
	OpeningOneTrueBraceSniffTest $dbWrite
) : Corpus\Sniffs\ControlStructures\ClosingBraceNewlineSniff {

});

// testing indent handling
{
	function Bar(
		ClosingBraceNewlineSniffTest $closingBraceNewlineSniffTest,
		OpeningOneTrueBraceSniffTest $openingOneTrueBraceSniffTest
	) {
	}

	$bar = function (
		Corpus\Sniffs\ControlStructures\ClosingBraceNewlineSniff $closingBraceNewlineSniff,
		Corpus\Sniffs\ControlStructures\OpeningOneTrueBraceSniff $openingOneTrueBraceSniff
	) { };

	// slightly deeper indent handling while were here
	{
		$di->set('closingBraceNewlineSniffTest', function (
			ClosingBraceNewlineSniff $dbRead,
			OpeningOneTrueBraceSniffTest $dbWrite
		) : Corpus\Sniffs\ControlStructures\ClosingBraceNewlineSniff {

		});
	}
}
