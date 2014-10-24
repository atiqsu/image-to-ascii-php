<?php

class ImageToAscii
{

	/**
	 * Image resource of passed in image
	 *
	 * @var resource
	 */
	protected $image;

	/**
	 * Height of the image
	 *
	 * @var mixed
	 */
	protected $height;

	/**
	 * Width of the image
	 *
	 * @var mixed
	 */
	protected $width;

	/**
	 * Character set to generate ascii art with
	 *
	 * @var mixed
	 */
	protected $characters;


	/**
	 * Constructor.
	 *
	 * Initializes the image resource object and sets the image height and width.
	 * Takes in an options array with the following options:
	 * image => the image to convert  -- REQUIRED
	 * characters => the set of characters to use during ascii generation  -- OPTIONAL
	 * scale => the amount to scale the image (as a decimal e.g. .50 = 50%, 1.25 = 125% ) -- OPTIONAL
	 *
	 * @param mixed $options
	 */
	public function __construct($options)
	{
		$this->image = imagecreatefromstring(file_get_contents($options['image']));

		$dimensions = getimagesize($options['image']);

		$this->width = $dimensions[0];
		$this->height = $dimensions[1];

		// Define the character set for ascii generation
		if (isset($options['characters'])) {

			$this->characters = $options['characters'];
		} else {

			$this->setCharacters();
		}

		// Scale if necessary
		if (isset($options['scale'])) {
			$scaleWidth = $this->width * $options['scale'];
			$scaleHeight = $this->height * $options['scale'];

			$this->width = $scaleWidth;
			$this->height = $scaleHeight;

			$this->image = imagescale($this->image, $scaleWidth, $scaleHeight);
		}
	}


	/**
	 * Convert Image to Ascii Art
	 *
	 * @return string ascii art
	 */
	public function convertImage()
	{
		$output = '';
		$output = '<pre>';

		for ($y = 0; $y < $this->height; $y++) {
            for ($x = 0; $x <= $this->width; $x++) {

                $rgb = @imagecolorat($this->image, $x, $y);
                $r = ($rgb >> 16) & 0xFF;
                $g = ($rgb >> 8) & 0xFF;
                $b = $rgb & 0xFF;

                if ($x == $this->width) {
                    $output .= '<br />';
                } else {
                    $output .= '<span style="color: rgb(' . $r . ', ' . $g . ', ' . $b . '); ">' . $this->getCharacter() . '</span>';
                }
            }
        }

		$output .= '</pre>';

		return $output;
	}


	/**
	 * Get a random character from the character set.
	 *
	 * @return string
	 */
	public function getCharacter()
	{
		return $this->characters[rand(0, (sizeof($this->characters) -1))];
	}


	/**
	 * Sets the default character set
	 *
	 * @return void
	 */
	public function setCharacters()
	{

		$this->characters = array(
			'#', '/', '@', '$', '%', '&',
		);
	}
}
