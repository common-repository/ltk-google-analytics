<?php

namespace LTK\String;

/**
 * UTF8 string manipulation
 *
 * This class includes common operations with strings and specific Unicode
 * procedures due to PHP limitations.
 */
class Unicode {

	/**
	 * Map of case correlations for UTF8
	 *
	 * @var array Unicode UPPER => lower characters
	 * @see http://php.net/manual/es/function.mb-strtolower.php
	 */
	protected static $case = [
		'ǅ' => 'ǆ', 'ǈ' => 'ǉ', 'ǋ' => 'ǌ', 'ǲ' => 'ǳ', 'Ϸ' => 'ϸ', 'Ϲ' => 'ϲ',
		'Ϻ' => 'ϻ', 'ᾈ' => 'ᾀ', 'ᾉ' => 'ᾁ', 'ᾊ' => 'ᾂ', 'ᾋ' => 'ᾃ', 'ᾌ' => 'ᾄ',
		'ᾍ' => 'ᾅ', 'ᾎ' => 'ᾆ', 'ᾏ' => 'ᾇ', 'ᾘ' => 'ᾐ', 'ᾙ' => 'ᾑ', 'ᾚ' => 'ᾒ',
		'ᾛ' => 'ᾓ', 'ᾜ' => 'ᾔ', 'ᾝ' => 'ᾕ', 'ᾞ' => 'ᾖ', 'ᾟ' => 'ᾗ', 'ᾨ' => 'ᾠ',
		'ᾩ' => 'ᾡ', 'ᾪ' => 'ᾢ', 'ᾫ' => 'ᾣ', 'ᾬ' => 'ᾤ', 'ᾭ' => 'ᾥ', 'ᾮ' => 'ᾦ',
		'ᾯ' => 'ᾧ', 'ᾼ' => 'ᾳ', 'ῌ' => 'ῃ', 'ῼ' => 'ῳ', 'Ⅰ' => 'ⅰ', 'Ⅱ' => 'ⅱ',
		'Ⅲ' => 'ⅲ', 'Ⅳ' => 'ⅳ', 'Ⅴ' => 'ⅴ', 'Ⅵ' => 'ⅵ', 'Ⅶ' => 'ⅶ', 'Ⅷ' => 'ⅷ',
		'Ⅸ' => 'ⅸ', 'Ⅹ' => 'ⅹ', 'Ⅺ' => 'ⅺ', 'Ⅻ' => 'ⅻ', 'Ⅼ' => 'ⅼ', 'Ⅽ' => 'ⅽ',
		'Ⅾ' => 'ⅾ', 'Ⅿ' => 'ⅿ', 'Ⓐ' => 'ⓐ', 'Ⓑ' => 'ⓑ', 'Ⓒ' => 'ⓒ', 'Ⓓ' => 'ⓓ',
		'Ⓔ' => 'ⓔ', 'Ⓕ' => 'ⓕ', 'Ⓖ' => 'ⓖ', 'Ⓗ' => 'ⓗ', 'Ⓘ' => 'ⓘ', 'Ⓙ' => 'ⓙ',
		'Ⓚ' => 'ⓚ', 'Ⓛ' => 'ⓛ', 'Ⓜ' => 'ⓜ', 'Ⓝ' => 'ⓝ', 'Ⓞ' => 'ⓞ', 'Ⓟ' => 'ⓟ',
		'Ⓠ' => 'ⓠ', 'Ⓡ' => 'ⓡ', 'Ⓢ' => 'ⓢ', 'Ⓣ' => 'ⓣ', 'Ⓤ' => 'ⓤ', 'Ⓥ' => 'ⓥ',
		'Ⓦ' => 'ⓦ', 'Ⓧ' => 'ⓧ', 'Ⓨ' => 'ⓨ', 'Ⓩ' => 'ⓩ', '𐐦' => '𐑎', '𐐧' => '𐑏'
	];

	/**
	 * Convert string to UTF8
	 *
	 * @param string $string
	 * @return string
	 */
	public static function toUTF8($string) {

		if (! mb_detect_encoding($string, 'UTF-8', true)) {
			$string = mb_convert_encoding_encoding($string, 'UTF-8');
		}

		return $string;

	}

	/**
	 * Make a string lowercase in a Unicode-safe manner
	 *
	 * @param string $string
	 * @return string
	 */
	public static function toLowerCase($string) {

		$string = mb_strtolower($string, 'UTF-8');
		$string = strtr($string, self::$case);

		return $string;

	}

	/**
	 * Make a string uppercase in a Unicode-safe manner
	 *
	 * @param string $string
	 * @return string
	 */
	public static function toUpperCase($string) {

		$string = mb_strtoupper($string, 'UTF-8');
		$string = strtr($string, array_flip(self::$case));

		return $string;

	}

}
