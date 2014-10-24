image-to-ascii-php
==================

A simple image to ascii converter.

## Usage ##
```php
// Declare new ImageToAscii object and pass image and scale option
$ascii = new ImageToAscii(array(
	'image' =>  'http://www.dotafire.com/images/hero/icon/crystal-maiden.png',
	'scale' => .50
));

// Print out ascii art
echo $ascii->convertImage();
```
