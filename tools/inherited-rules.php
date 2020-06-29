<?php

require __DIR__ . '/../vendor/autoload.php';

$ruleset = new DOMDocument;
$ruleset->load(__DIR__ . '/../src/Corpus/ruleset.xml');

$rules = $ruleset->getElementsByTagName('rule');

$slevomatReadme = file_get_contents('https://github.com/slevomat/coding-standard/blob/master/README.md');

function makeRefLink( string $ref ) : string {
	global $slevomatReadme;

	$parts = explode('.', $ref);

	if( in_array($parts[0], [ 'Generic', 'MySource', 'PEAR', 'PSR1', 'PSR12', 'PSR2', 'Squiz', 'Zend' ]) ) {
		return "[{$ref}](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/{$parts[0]}/Sniffs/{$parts[1]}/{$parts[2]}Sniff.php)";
	}

	if( $parts[0] === 'SlevomatCodingStandard' ) {
		$anchor = strtolower($ref);
		$anchor = preg_replace('/\W/', '', $anchor);
		if( strpos($slevomatReadme, "#$anchor-\"") ) {
			return "[{$ref}](https://github.com/slevomat/coding-standard/blob/master/README.md#{$anchor}-)";
		}

		if( strpos($slevomatReadme, "#$anchor\"") ) {
			return "[{$ref}](https://github.com/slevomat/coding-standard/blob/master/README.md#{$anchor})";
		}
	}

	return $ref;
}

/** @var \DOMNode $rule */
foreach( $rules as $rule ) {
	echo '- ' . makeRefLink($rule->attributes->getNamedItem('ref')->nodeValue);
	echo "\n";
}