<?php

if ($foo->anyFoo([ Bar::BAZ ])
	|| ( ! $this->hasBaz(Baz::Boo) && $boo ) ) {
	//noop
}

if( $foo && (
		$bar
		|| $baz
	)
) {
	//noop
}

if(
	$foo


	|| $bar
) {
	//noop
}

// Who does this? No change
if(
	$foo

	||

	$bar
) {
	//noop
}


// no change
if( $foo && $bar ) {}
