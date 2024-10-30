<?php

namespace LTK\WordPress\GoogleAnalytics;

class GoogleAnalytics_Admin {

	/**
	 * Opens and returns template file's contents
	 *
	 * @param string $template Name of the template
	 * @return string
	 */
	protected function load_template($template) {

		$file = LTK_GOOGLE_ANALYTICS_PATH . 'templates' . LTK_DS . 'admin' . LTK_DS . $template . '.php';

		if ( is_file( $file ) ) {
			require $file;
		}

	}

	/**
	 * Hooks code into WordPress
	 */
	public function init() {
		add_action( 'admin_init', [ $this, 'register_settings' ] );
		add_action( 'admin_menu', [ $this, 'settings_page' ] );
	}

	/**
	 * Create Google Analytics options sub-menu (ltk-google-analytics)
	 */
	public function settings_page() {
		add_options_page( 'Google Analytics', 'Google Analytics',
			'manage_options',
			'ltk-google-analytics',
			function() {
				$this->load_template('ltk-google-analytics');
			}
		);
	}

	/**
	 * Create and register settings and settings sections
	 */
	public function register_settings() {

		/* Property */

		add_settings_section(
			'ltk-google-analytics-property',
			__( 'Property configuration', 'ltk-google-analytics' ),
			function() { _e( 'Enable Google Analytics by introducing your property ID.', 'ltk-google-analytics' ); },
			'ltk-google-analytics'
		);

		register_setting(
			'ltk-google-analytics',
			'ltk-google-analytics-property',
			[ $this, 'sanitize_property' ]
		);

		add_settings_field(
			'ltk-google-analytics-property',
			__( 'Property ID', 'ltk-google-analytics'),
			[ $this, 'setting_property' ],
			'ltk-google-analytics',
			'ltk-google-analytics-property'
		);

		/* Dimensions */

		add_settings_section(
			'ltk-google-analytics-dimensions',
			__( 'Custom dimensions', 'ltk-google-analytics' ),
			function() {
				$str = __('You can specify Google Analytics dimension IDs which correspond with the following data. This way you can get reports in the form of "page views per author" or "most viewed categories". For this to work, create your dimensions first at Google Analytics, [url]learn how here[/url]. When you are done setting them up, introduce their IDs here. In order to get your reports, you must regex on the dimensions: <code>my-category\\s</code> will match any post with that exact category, whereas <code>my-category_</code> will match any post in any subcategory of that one.', 'ltk-google-analytics');
				echo preg_replace(
					'/\[url](.*?)\[\/url\]/i',
					'<a href="https://support.google.com/analytics/answer/2709829" target="_blank">$1</a>',
					$str
				);
			},
			'ltk-google-analytics'
		);

		register_setting(
			'ltk-google-analytics',
			'ltk-google-analytics-dimension-author',
			[ $this, 'sanitize_dimension_author' ]
		);

		add_settings_field(
			'ltk-google-analytics-property-author',
			__( 'Author dimension', 'ltk-google-analytics'),
			[ $this, 'setting_dimension_author' ],
			'ltk-google-analytics',
			'ltk-google-analytics-dimensions'
		);

		register_setting(
			'ltk-google-analytics',
			'ltk-google-analytics-dimension-category',
			[ $this, 'sanitize_dimension_category' ]
		);

		add_settings_field(
			'ltk-google-analytics-property-category',
			__( 'Category dimension', 'ltk-google-analytics'),
			[ $this, 'setting_dimension_category' ],
			'ltk-google-analytics',
			'ltk-google-analytics-dimensions'
		);

		register_setting(
			'ltk-google-analytics',
			'ltk-google-analytics-dimension-tag',
			[ $this, 'sanitize_dimension_tag' ]
		);

		add_settings_field(
			'ltk-google-analytics-property-tag',
			__( 'Tag dimension', 'ltk-google-analytics'),
			[ $this, 'setting_dimension_tag' ],
			'ltk-google-analytics',
			'ltk-google-analytics-dimensions'
		);

	}

	/**
	 * Display ltk-google-analytics-property
	 */
	public function setting_property() {

		$option = get_option( 'ltk-google-analytics-property' );
		$description = sprintf( __( 'Format: %s'), 'UA-XXXXXXXX-Y' );

		$input = "<input name=\"ltk-google-analytics-property\" value=\"$option\" class=\"regular-text\" type=\"text\"><p class=\"description\">$description</p>";

		echo $input;

	}

	/**
	 * Display ltk-google-analytics-dimension-author
	 */
	public function setting_dimension_author() {

		$option = get_option( 'ltk-google-analytics-dimension-author' );

		$input = "<input name=\"ltk-google-analytics-dimension-author\" value=\"$option\" class=\"regular-text\" style=\"width: 5em;\" type=\"number\">";

		echo $input;

	}

	/**
	 * Display ltk-google-analytics-dimension-category
	 */
	public function setting_dimension_category() {

		$option = get_option( 'ltk-google-analytics-dimension-category' );

		$input = "<input name=\"ltk-google-analytics-dimension-category\" value=\"$option\" class=\"regular-text\" style=\"width: 5em;\" type=\"number\">";

		echo $input;

	}

	/**
	 * Display ltk-google-analytics-dimension-tag
	 */
	public function setting_dimension_tag() {

		$option = get_option( 'ltk-google-analytics-dimension-tag' );

		$input = "<input name=\"ltk-google-analytics-dimension-tag\" value=\"$option\" class=\"regular-text\" style=\"width: 5em;\" type=\"number\">";

		echo $input;

	}

	/**
	 * Sanitize and validate ltk-google-analytics-property
	 *
	 * @param string $input
	 * @return string
	 */
	public function sanitize_property($input) {

		$input = sanitize_text_field($input);

		if ( ! empty($input) && ! preg_match( '/^ua-\d{4,9}-\d{1,4}$/i', $input ) ) {

			add_settings_error(
				'ltk-google-analytics-property',
				'ltk-google-analytics-property',
				__( 'Invalid Google Analytics Property ID.', 'ltk-google-analytics') ,
				'error'
			);

			return get_option( 'ltk-google-analytics-property' );

		}

		return $input;

	}

	/**
	 * Sanitize and validate ltk-google-analytics-dimension-*
	 *
	 * @param string $input
	 * @param string $type
	 * @return int
	 */
	protected function sanitize_dimension($input, $type) {

		if ( empty( $input ) ) {
			return '';
		}

		if ( ( ctype_digit( $input ) || is_int( $input ) ) && $input >= 1 && $input <= 20) {
			return (int) $input;
		}

		add_settings_error(
			"ltk-google-analytics-dimension-$type",
			"ltk-google-analytics-dimension-$type",
			__( sprintf( 'Invalid dimension for %s.', __( $type, 'ltk-google-analytics' ) ), 'ltk-google-analytics' ) ,
			'error'
		);

		return get_option( "ltk-google-analytics-dimension-$type" );

	}

	/**
	 * Common entry point for sanitize_dimension()
	 *
	 * @param string $input
	 * @return int
	 */
	public function sanitize_dimension_author($input) {
		__('author', 'ltk-google-analytics');
		return $this->sanitize_dimension($input, 'author');
	}

	/**
	 * Common entry point for sanitize_dimension()
	 *
	 * @param string $input
	 * @return int
	 */
	public function sanitize_dimension_category($input) {
		__('category', 'ltk-google-analytics');
		return $this->sanitize_dimension($input, 'category');
	}

	/**
	 * Common entry point for sanitize_dimension()
	 *
	 * @param string $input
	 * @return int
	 */
	public function sanitize_dimension_tag($input) {
		__('tag', 'ltk-google-analytics');
		return $this->sanitize_dimension($input, 'tag');
	}

}
