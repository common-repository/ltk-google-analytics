<?php

use LTK\String\Transliterator;

/**
 * Tests that the class is able to perform its job and to perform it
 * secuentially, alternating languages one after another. The original
 * library was NOT able to do this, since it used static methods and
 * properties and also did not refresh the languages when $language = ''.
 */
class TransliteratorTest extends PHPUnit_Framework_TestCase {

	protected $transliterations = [
		['SCHÄFFER', 'SCHAeFFER', 'de'],
		['Ää Áá', 'Aa Aa'],
		['Nuño Núñez', 'Nuno Nunez'],
		['Ψψ', 'PSps'],
		['ΦΞΠΏΣ', 'F3PWS'],
		['SCHÄFFER', 'SCHAFFER'],
		['Ää Áá', 'Aeae Aa', 'de']
	];

	protected $slugs = [
		['SCHÄFFER', 'schaeffer', 'de'],
		['Ää Áá', 'aa-aa'],
		['Nuño Núñez', 'nuno-nunez'],
		['Ψψ', 'psps'],
		['ΦΞΠΏΣ', 'f3pws'],
		['SCHÄFFER', 'schaffer'],
		['Ää Áá', 'aeae-aa', 'de'],
		['-a-b-c-', 'a-b-c'],
		['a - b  c', 'a-b-c'],
		['.a.', 'a'],
		['This is a test', 'test', 'en', true],
		['This is a test', 'this-is-a-test']
	];

	public function test_transliterate() {

		$t = new Transliterator();

		foreach ($this->transliterations as $input) {

			$language = '';
			if (isset($input[2])) {
				$language = $input[2];
			}

			$output = $t->transliterate($input[0], $language);
			$this->assertEquals($input[1], $output);

		}

	}

	public function test_slug() {

		$t = new Transliterator();

		foreach ($this->slugs as $input) {

			$language = '';
			if (isset($input[2])) {
				$language = $input[2];
			}

			$remove = false;
			if (isset($input[3])) {
				$remove = $input[3];
			}

			$output = $t->slug($input[0], $language, $remove);
			$this->assertEquals($input[1], $output);

		}

	}

}
