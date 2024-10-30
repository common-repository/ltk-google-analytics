<?php

use LTK\String\Unicode;

class UnicodeTest extends PHPUnit_Framework_TestCase {

	/**
    * @dataProvider data_caseTest
    */
	public function test_toLowerCase($input, $expected) {
		$output = Unicode::toLowerCase($input);
		$this->assertEquals($expected, $output);
	}

	/**
    * @dataProvider data_caseTest
    */
	public function test_toUpperCase($expected, $input) {
		$output = Unicode::toUpperCase($input);
		$this->assertEquals($expected, $output);
	}

	public function data_caseTest() {
		return [
			['AAA', 'aaa'],
			['ÄÁÂ', 'äáâ'],
			['ᾞᾬÑ', 'ᾖᾤñ'],
			['ЦЕ ПЕРЕВІРКА', 'це перевірка'],
			['ΑΥΤΌ ΕΊΝΑΙ ΈΝΑ ΤΕΣΤ', 'αυτό είναι ένα τεστ'],
			['¿Ê Ä?', '¿ê ä?']
		];
	}

}
