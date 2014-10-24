<?php

require_once 'ImageToAscii.php';

$ascii = new ImageToAscii(array(
	'image' =>  'http://www.dotafire.com/images/hero/icon/crystal-maiden.png',
	'scale' => .50
));

echo $ascii->convertImage();
