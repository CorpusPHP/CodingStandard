<?php

use Corpus\PhpCsFixer\Config;
use PhpCsFixer\Finder;

$config = Config::php7x4();

return $config
	->setUnsupportedPhpVersionAllowed(true)
	->setRules(array_merge(
		[ '@PHPUnit84Migration:risky' => true ],
		$config->getRules(),
		[
			'return_type_declaration' => [ 'space_before' => 'one' ],
			'visibility_required'     => true,
		]
	))
	->setFinder(Finder::create()->in(__DIR__ . '/src'));
