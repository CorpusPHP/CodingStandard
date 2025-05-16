<?php

require __DIR__ . '/../vendor/autoload.php';

$ruleset = new DOMDocument;
$ruleset->load(__DIR__ . '/../src/Corpus/ruleset.xml');

$rules = $ruleset->getElementsByTagName('rule');

$slevomatReadme = file_get_contents('https://raw.githubusercontent.com/slevomat/coding-standard/master/README.md');

function makeRefLink( string $ref ) : string {
	global $slevomatReadme;

	$parts = explode('.', $ref);

	if( in_array($parts[0], [ 'Generic', 'MySource', 'PEAR', 'PSR1', 'PSR12', 'PSR2', 'Squiz', 'Zend' ]) ) {
		return "[{$ref}](https://github.com/squizlabs/PHP_CodeSniffer/blob/master/src/Standards/{$parts[0]}/Sniffs/{$parts[1]}/{$parts[2]}Sniff.php)";
	}

	if( $parts[0] === 'SlevomatCodingStandard' ) {
		preg_match('/\['.preg_quote($ref).'\]\(([^)]+)\)/im', $slevomatReadme, $matches);
		if($matches) {
			return "[{$ref}](https://github.com/slevomat/coding-standard/blob/master/{$matches[1]})";
		}
	}

	return $ref;
}

/** @var \DOMElement $rule */
foreach( $rules as $rule ) {
	echo '- ' . makeRefLink($rule->attributes->getNamedItem('ref')->nodeValue);
	$properties = $rule->getElementsByTagName('property');
	foreach( $properties as $property ) {
		echo sprintf(' \[ %s=%s \]', $property->attributes->getNamedItem('name')->nodeValue, $property->attributes->getNamedItem('value')->nodeValue);
	}
	echo "\n";
}
