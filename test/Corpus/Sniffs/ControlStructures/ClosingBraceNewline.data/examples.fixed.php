<?php

class Foo {

	function bar() {
		if( true ) {
			echo "x";
		}

		if( false ) {
			echo "y";
		}
	}
}

while( false ) {
	echo "never!";
}

echo "ok";

try {
	echo "ok";
} catch( \Exception $ex ) {
	echo "exit";
}

echo "ok";

//don't fix
for(;;){
}
?>
<?php
