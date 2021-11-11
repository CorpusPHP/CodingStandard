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

if(true) {

}echo "it's not on it's own line";

if(true) {  } // don't fix
echo "there's junk at the end of the previous line";

//don't fix
for(;;){
}
?>
<?php
