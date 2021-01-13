<?php

function foo() {

	return;
}

function bar() {
	return 1;
}


class Foo {

	function foo() {
		if(true) {
			return;
		}

	}

	function bar() {
		return 1;
	}


}

function baz() {
	return 1;

	// This is fine
}

// nothing after this, ignore
return;