<?php

namespace LTK\Web;

use InvalidArgumentException;

class GoogleAnalytics {

	/** @var string Google Analytics base JavaScript code */
	protected $script = "\t(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){\n\t(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),\n\tm=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)\n\t})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');";

	/** @var string Property ID in the format UA-00000000-00 */
	protected $ua;

	/** @var string[] Generated Google Analytics commands */
	protected $ga = [];

	/**
	 * Initialize Google Analytics object with the property ID
	 *
	 * @param string $id Format: UA-0000000-00
	 * @throws InvalidArgumentException
	 */
	public function __construct($id) {

		if (! preg_match('/^ua-\d{4,9}-\d{1,4}$/i', $id)) {
			throw new InvalidArgumentException('Google Analytics ID does not seem to be valid.');
		}

		$this->id = strtoupper($id);

	}

	/**
	 * Generates an array of parameters for ga()
	 */
	protected function ga() {

		$args = func_get_args();

		array_walk($args, function(&$value) {

			$type = gettype($value);

			switch ($type) {
				case 'int':
				case 'float':
				case 'double':
					break;
				case 'string':
					$value = "'$value'";
					break;
				case 'NULL':
				case 'resource':
					$value = "''";
					break;
				case 'array':
				case 'object':
					$value = "'" . json_encode($value) . "'";
					break;
			}

		});

		$this->ga[] = $args;

	}

	/**
	 * Add a custom dimension, specified by its number
	 *
	 * @param int $id
	 * @param int|float|double|string $value
	 * @throws InvalidArgumentException
	 */
	public function dimension($id, $value) {

		if (! ctype_digit($id) && ! is_int($id)) {
			throw new InvalidArgumentException('Invalid dimension ID format.');
		}

		if ($id < 1 || $id > 200) {
			throw new InvalidArgumentException('Invalid dimension ID.');
		}

		if (! in_array(gettype($value), ['int', 'float', 'double', 'string'])) {
			throw new InvalidArgumentException('Invalid dimension value format.');
		}

		$this->ga('set', "dimension$id", $value);

	}

	/**
	 * Send pageview to GA
	 *
	 * Notice that default GA code does include this, while this library does NOT
	 * add it by default. You must add it manually.
	 */
	public function pageview() {
		$this->ga('send', 'pageview');
	}

	/**
	 * Generates Analytics <script> code
	 *
	 * @return string
	 */
	public function generate() {

		$output = "<script>\n{$this->script}\n\n";
		$output .= "\tga('create', '{$this->id}', 'auto');\n\n";

		foreach ($this->ga as $ga) {
			$output .= "\tga(" . implode(', ', $ga) . ");\n";
		}

		$output .= "\n</script>";

		return $output;

	}

}
