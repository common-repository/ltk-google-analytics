<?php

namespace LTK\String;

/**
 * Converts strings to ASCII and URL-safe chararacters
 *
 * Based on URLify (https://github.com/jbroadway/urlify) by jbroadway and
 * improved in some ways.
 */
class Transliterator {

	/** @var array Replacements map for transliteration */
	protected $transliterations = [

		/* German */
		'de' => [
			'Ä' => 'Ae', 'Ö' => 'Oe', 'Ü' => 'Ue', 'ä' => 'ae', 'ö' => 'oe',
			'ü' => 'ue', 'ß' => 'ss', 'ẞ' => 'SS'
		],

		'latin' => [
			'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'A',
			'Å' => 'A', 'Ă' => 'A', 'Æ' => 'AE', 'Ç' => 'C', 'È' => 'E',
			'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ì' => 'I', 'Í' => 'I',
			'Î' => 'I', 'Ï' => 'I', 'Ð' => 'D', 'Ñ' => 'N', 'Ò' => 'O',
			'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O', 'Ö' => 'O', 'Ő' => 'O',
			'Ø' => 'O', 'Œ' => 'OE', 'Ș' => 'S', 'Ț' => 'T', 'Ù' => 'U',
			'Ú' => 'U', 'Û' => 'U', 'Ü' => 'U', 'Ű' => 'U', 'Ý' => 'Y',
			'Þ' => 'TH', 'ß' => 'ss', 'à' => 'a', 'á' => 'a', 'â' => 'a',
			'ã' => 'a', 'ä' => 'a', 'å' => 'a', 'ă' => 'a', 'æ' => 'ae',
			'ç' => 'c', 'è' => 'e', 'é' => 'e', 'ê' => 'e', 'ë' => 'e',
			'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ð' => 'd',
			'ñ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o',
			'ö' => 'o', 'ő' => 'o', 'ø' => 'o', 'œ' => 'oe', 'ș' => 's',
			'ț' => 't', 'ù' => 'u', 'ú' => 'u', 'û' => 'u', 'ü' => 'u',
			'ű' => 'u', 'ý' => 'y', 'þ' => 'th', 'ÿ' => 'y'
		],

		'latin_symbols' => [
			'©' => '(c)', '¿' => '?', '®' => '(r)', '¼' => '1/4', '½' => '1/2',
			'¾' => '3/4', '¶' => 'P'
		],

		/* Greek */
		'el' => [
			'α' => 'a', 'β' => 'b', 'γ' => 'g', 'δ' => 'd', 'ε' => 'e',
			'ζ' => 'z', 'η' => 'h', 'θ' => '8', 'ι' => 'i', 'κ' => 'k',
			'λ' => 'l', 'μ' => 'm', 'ν' => 'n', 'ξ' => '3', 'ο' => 'o',
			'π' => 'p', 'ρ' => 'r', 'σ' => 's', 'τ' => 't', 'υ' => 'y',
			'φ' => 'f', 'χ' => 'x', 'ψ' => 'ps', 'ω' => 'w', 'ά' => 'a',
			'έ' => 'e', 'ί' => 'i', 'ό' => 'o', 'ύ' => 'y', 'ή' => 'h',
			'ώ' => 'w', 'ς' => 's', 'ϊ' => 'i', 'ΰ' => 'y', 'ϋ' => 'y',
			'ΐ' => 'i', 'Α' => 'A', 'Β' => 'B', 'Γ' => 'G', 'Δ' => 'D',
			'Ε' => 'E', 'Ζ' => 'Z', 'Η' => 'H', 'Θ' => '8', 'Ι' => 'I',
			'Κ' => 'K', 'Λ' => 'L', 'Μ' => 'M', 'Ν' => 'N', 'Ξ' => '3',
			'Ο' => 'O', 'Π' => 'P', 'Ρ' => 'R', 'Σ' => 'S', 'Τ' => 'T',
			'Υ' => 'Y', 'Φ' => 'F', 'Χ' => 'X', 'Ψ' => 'PS', 'Ω' => 'W',
			'Ά' => 'A', 'Έ' => 'E', 'Ί' => 'I', 'Ό' => 'O', 'Ύ' => 'Y',
			'Ή' => 'H', 'Ώ' => 'W', 'Ϊ' => 'I', 'Ϋ' => 'Y'
		],

		/* Turkish */
		'tr' => [
			'ş' => 's', 'Ş' => 'S', 'ı' => 'i', 'İ' => 'I', 'ç' => 'c',
			'Ç' => 'C', 'ü' => 'u', 'Ü' => 'U', 'ö' => 'o', 'Ö' => 'O',
			'ğ' => 'g', 'Ğ' => 'G'
		],

		/* Bulgarian */
		'bg' => [
			"Щ" => 'Sht', "Ш" => 'Sh', "Ч" => 'Ch', "Ц" => 'C', "Ю" => 'Yu',
			"Я" => 'Ya', "Ж" => 'J', "А" => 'A', "Б" => 'B', "В" => 'V',
			"Г" => 'G', "Д" => 'D', "Е" => 'E', "З" => 'Z', "И" => 'I',
			"Й" => 'Y', "К" => 'K', "Л" => 'L', "М" => 'M', "Н" => 'N',
			"О" => 'O', "П" => 'P', "Р" => 'R', "С" => 'S', "Т" => 'T',
			"У" => 'U', "Ф" => 'F', "Х" => 'H', "Ь" => '', "Ъ" => 'A',
			"щ" => 'sht', "ш" => 'sh', "ч" => 'ch', "ц" => 'c', "ю" => 'yu',
			"я" => 'ya', "ж" => 'j', "а" => 'a', "б" => 'b', "в" => 'v',
			"г" => 'g', "д" => 'd', "е" => 'e', "з" => 'z', "и" => 'i',
			"й" => 'y', "к" => 'k', "л" => 'l', "м" => 'm', "н" => 'n',
			"о" => 'o', "п" => 'p', "р" => 'r', "с" => 's', "т" => 't',
			"у" => 'u', "ф" => 'f', "х" => 'h', "ь" => '', "ъ" => 'a'
		],

		/* Russian */
		'ru' => [
			'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd',
			'е' => 'e', 'ё' => 'yo', 'ж' => 'zh', 'з' => 'z', 'и' => 'i',
			'й' => 'j', 'к' => 'k', 'л' => 'l', 'м' => 'm', 'н' => 'n',
			'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
			'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
			'ш' => 'sh', 'щ' => 'sh', 'ъ' => '', 'ы' => 'y', 'ь' => '',
			'э' => 'e', 'ю' => 'yu', 'я' => 'ya', 'А' => 'A', 'Б' => 'B',
			'В' => 'V', 'Г' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'Yo',
			'Ж' => 'Zh', 'З' => 'Z', 'И' => 'I', 'Й' => 'J', 'К' => 'K',
			'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O', 'П' => 'P',
			'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F',
			'Х' => 'H', 'Ц' => 'C', 'Ч' => 'Ch', 'Ш' => 'Sh', 'Щ' => 'Sh',
			'Ъ' => '', 'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'Yu',
			'Я' => 'Ya', '№' => ''
		],

		/* Ukrainian */
		'uk' => [
			'Є' => 'Ye', 'І' => 'I', 'Ї' => 'Yi', 'Ґ' => 'G', 'є' => 'ye',
			'і' => 'i', 'ї' => 'yi', 'ґ' => 'g'
		],

		/* Czech */
		'cs' => [
			'č' => 'c', 'ď' => 'd', 'ě' => 'e', 'ň' => 'n', 'ř' => 'r',
			'š' => 's', 'ť' => 't', 'ů' => 'u', 'ž' => 'z', 'Č' => 'C',
			'Ď' => 'D', 'Ě' => 'E', 'Ň' => 'N', 'Ř' => 'R', 'Š' => 'S',
			'Ť' => 'T', 'Ů' => 'U', 'Ž' => 'Z'
		],

		/* Polish */
		'pl' => [
			'ą' => 'a', 'ć' => 'c', 'ę' => 'e', 'ł' => 'l', 'ń' => 'n',
			'ó' => 'o', 'ś' => 's', 'ź' => 'z', 'ż' => 'z', 'Ą' => 'A',
			'Ć' => 'C', 'Ę' => 'e', 'Ł' => 'L', 'Ń' => 'N', 'Ó' => 'O',
			'Ś' => 'S', 'Ź' => 'Z', 'Ż' => 'Z'
		],

		/* Romanian */
		'ro' => [
			'ă' => 'a', 'â' => 'a', 'î' => 'i', 'ș' => 's', 'ț' => 't',
			'Ţ' => 'T', 'ţ' => 't'
		],

		/* Latvian */
		'lv' => [
			'ā' => 'a', 'č' => 'c', 'ē' => 'e', 'ģ' => 'g', 'ī' => 'i',
			'ķ' => 'k', 'ļ' => 'l', 'ņ' => 'n', 'š' => 's', 'ū' => 'u',
			'ž' => 'z', 'Ā' => 'A', 'Č' => 'C', 'Ē' => 'E', 'Ģ' => 'G',
			'Ī' => 'i', 'Ķ' => 'k', 'Ļ' => 'L', 'Ņ' => 'N', 'Š' => 'S',
			'Ū' => 'u', 'Ž' => 'Z'
		],

		/* Lithuanian */
		'lt' =>[
			'ą' => 'a', 'č' => 'c', 'ę' => 'e', 'ė' => 'e', 'į' => 'i',
			'š' => 's', 'ų' => 'u', 'ū' => 'u', 'ž' => 'z', 'Ą' => 'A',
			'Č' => 'C', 'Ę' => 'E', 'Ė' => 'E', 'Į' => 'I', 'Š' => 'S',
			'Ų' => 'U', 'Ū' => 'U', 'Ž' => 'Z'
		],

		/* Vietnamese */
		'vn' => [
			'Á' => 'A', 'À' => 'A', 'Ả' => 'A', 'Ã' => 'A', 'Ạ' => 'A',
			'Ă' => 'A', 'Ắ' => 'A', 'Ằ' => 'A', 'Ẳ' => 'A', 'Ẵ' => 'A',
			'Ặ' => 'A', 'Â' => 'A', 'Ấ' => 'A', 'Ầ' => 'A', 'Ẩ' => 'A',
			'Ẫ' => 'A', 'Ậ' => 'A', 'á' => 'a', 'à' => 'a', 'ả' => 'a',
			'ã' => 'a', 'ạ' => 'a', 'ă' => 'a', 'ắ' => 'a', 'ằ' => 'a',
			'ẳ' => 'a', 'ẵ' => 'a', 'ặ' => 'a', 'â' => 'a', 'ấ' => 'a',
			'ầ' => 'a', 'ẩ' => 'a', 'ẫ' => 'a', 'ậ' => 'a', 'É' => 'E',
			'È' => 'E', 'Ẻ' => 'E', 'Ẽ' => 'E', 'Ẹ' => 'E', 'Ê' => 'E',
			'Ế' => 'E', 'Ề' => 'E', 'Ể' => 'E', 'Ễ' => 'E', 'Ệ' => 'E',
			'é' => 'e', 'è' => 'e', 'ẻ' => 'e', 'ẽ' => 'e', 'ẹ' => 'e',
			'ê' => 'e', 'ế' => 'e', 'ề' => 'e', 'ể' => 'e', 'ễ' => 'e',
			'ệ' => 'e', 'Í' => 'I', 'Ì' => 'I', 'Ỉ' => 'I', 'Ĩ' => 'I',
			'Ị' => 'I', 'í' => 'i', 'ì' => 'i', 'ỉ' => 'i', 'ĩ' => 'i',
			'ị' => 'i', 'Ó' => 'O', 'Ò' => 'O', 'Ỏ' => 'O', 'Õ' => 'O',
			'Ọ' => 'O', 'Ô' => 'O', 'Ố' => 'O', 'Ồ' => 'O', 'Ổ' => 'O',
			'Ỗ' => 'O', 'Ộ' => 'O', 'Ơ' => 'O', 'Ớ' => 'O', 'Ờ' => 'O',
			'Ở' => 'O', 'Ỡ' => 'O', 'Ợ' => 'O', 'ó' => 'o', 'ò' => 'o',
			'ỏ' => 'o', 'õ' => 'o', 'ọ' => 'o', 'ô' => 'o', 'ố' => 'o',
			'ồ' => 'o', 'ổ' => 'o', 'ỗ' => 'o', 'ộ' => 'o', 'ơ' => 'o',
			'ớ' => 'o', 'ờ' => 'o', 'ở' => 'o', 'ỡ' => 'o', 'ợ' => 'o',
			'Ú' => 'U', 'Ù' => 'U', 'Ủ' => 'U', 'Ũ' => 'U', 'Ụ' => 'U',
			'Ư' => 'U', 'Ứ' => 'U', 'Ừ' => 'U', 'Ử' => 'U', 'Ữ' => 'U',
			'Ự' => 'U', 'ú' => 'u', 'ù' => 'u', 'ủ' => 'u', 'ũ' => 'u',
			'ụ' => 'u', 'ư' => 'u', 'ứ' => 'u', 'ừ' => 'u', 'ử' => 'u',
			'ữ' => 'u', 'ự' => 'u', 'Ý' => 'Y', 'Ỳ' => 'Y', 'Ỷ' => 'Y',
			'Ỹ' => 'Y', 'Ỵ' => 'Y', 'ý' => 'y', 'ỳ' => 'y', 'ỷ' => 'y',
			'ỹ' => 'y', 'ỵ' => 'y', 'Đ' => 'D', 'đ' => 'd'
		],

		/* Arabic */
		'ar' => [
			'أ' => 'a', 'ب' => 'b', 'ت' => 't', 'ث' => 'th', 'ج' => 'g',
			'ح' => 'h', 'خ' => 'kh', 'د' => 'd', 'ذ' => 'th', 'ر' => 'r',
			'ز' => 'z', 'س' => 's', 'ش' => 'sh', 'ص' => 's', 'ض' => 'd',
			'ط' => 't', 'ظ' => 'th', 'ع' => 'aa', 'غ' => 'gh', 'ف' => 'f',
			'ق' => 'k', 'ك' => 'k', 'ل' => 'l', 'م' => 'm', 'ن' => 'n',
			'ه' => 'h', 'و' => 'o', 'ي' => 'y'
		],

		/* Serbian */
		'sr' => [
			'ђ' => 'dj', 'ј' => 'j', 'љ' => 'lj', 'њ' => 'nj', 'ћ' => 'c',
			'џ' => 'dz', 'đ' => 'dj', 'Ђ' => 'Dj', 'Ј' => 'j', 'Љ' => 'Lj',
			'Њ' => 'Nj', 'Ћ' => 'C', 'Џ' => 'Dz', 'Đ' => 'Dj'
		],

		/* Azerbaijani */
		'az' => [
			'ç' => 'c', 'ə' => 'e', 'ğ' => 'g', 'ı' => 'i', 'ö' => 'o',
			'ş' => 's', 'ü' => 'u', 'Ç' => 'C', 'Ə' => 'E', 'Ğ' => 'G',
			'İ' => 'I', 'Ö' => 'O', 'Ş' => 'S', 'Ü' => 'U'
		]

	];

	/** @var type Processed maps */
	protected $maps = [];

	/** @var string The language being used for transliteration */
	protected $language = '';

	/** @var array Array of character maps being used for transliteration */
	protected $map = [];

	/** @var string Transliteration characters concatenated, for $this->regex */
	protected $chars = '';

	/** @var string Regex being used to match characters to replace in transliteration */
	protected $regex = '';

	/** @var array List of meaningless characters to remove */
	protected $remove = [

		'en' => [
			'a', 'an', 'as', 'at', 'before', 'but', 'by', 'for', 'from', 'is',
			'in', 'into', 'like', 'of', 'off', 'on', 'onto', 'per', 'since',
			'than', 'the', 'this', 'that', 'to', 'up', 'via', 'with'
		]

	];

	/**
	 * Builds the internal character map and replacement regex
	 *
	 * @param string $language ISO-639-1 code of a language
	 */
	protected function setLanguage($language = '') {

		if (count($this->map) > 0 && $language == $this->language) {
			return;
		}

		$this->maps = $this->transliterations;

		/* Move map to end to give it priority */
		if (isset($this->maps[$language]) && is_array($this->maps[$language])) {
			$m = $this->maps[$language];
			unset($this->maps[$language]);
			$this->maps[$language] = $m;
		}

		/* Reset static vars */
		$this->language = $language;
		$this->map = [];
		$this->chars = '';

		foreach ($this->maps as $map) {
			foreach ($map as $orig => $conv) {
				$this->map[$orig] = $conv;
				$this->chars .= $orig;
			}
		}

		$this->regex = '/[' . $this->chars . ']/u';

	}

	/**
	 * Transliterates characters to their ASCII equivalents
	 *
	 * The $language param is useful because different languages may have
	 * different rules for the same character. Specifying a language here gives
	 * it the priority so string is transliterated accordingly.
	 *
	 * @param string $text
	 * @param string $language ISO-639-1 code of a language
	 * @return string
	 */
	public function transliterate($text, $language = '') {

		$this->setLanguage($language);

		if (preg_match_all($this->regex, $text, $matches)) {
			$n = count($matches[0]);
			for ($i = 0; $i < $n; $i++) {
				$char = $matches[0][$i];
				if (isset ($this->map[$char])) {
					$text = str_replace($char, $this->map[$char], $text);
				}
			}
		}

		return $text;

	}

	/**
	 * Generate URL slug from a string
	 *
	 * @param string $text
	 * @param string $language ISO 639-1 of a language
	 * @return string
	 */
	public function slug($text, $language = '', $remove = false) {

		$text = $this->transliterate($text, $language);

		/* Remove specific characters */
		if ($remove && isset($this->remove[$language])) {
			$text = preg_replace('/\b(' . join('|', $this->remove[$language]) . ')\b/i', '', $text);
		}

		$pattern = '/[^\s_\-a-zA-Z0-9]/u';

		/* Remove everything else non-url-safe */
		$text = preg_replace($pattern, '', $text);
		$text = str_replace('_', ' ', $text); // Treat underscores as spaces
		$text = preg_replace('/^\s+|\s+$/u', '', $text); // Trim leading/trailing spaces
		$text = preg_replace('/[-\s]+/u', '-', $text); // Convert spaces to hyphens
		$text = trim($text, '-'); // Trim leading/trailing hyphens
		$text = strtolower($text); // Convert to lowercase

		return $text;

	}

}
