<?php

namespace LTK\WordPress\GoogleAnalytics;

use LTK\Web\GoogleAnalytics as AnalyticsJS;

class GoogleAnalytics {

	/**
	 * Hooks code into WordPress
	 */
	public function init() {
		add_action( 'wp_footer', [ $this, 'display_analytics' ] );
	}

	/**
	 * Generates the GA code and writes it
	 *
	 * @global WP_Post $post
	 */
	public function display_analytics() {

		$ua = get_option( 'ltk-google-analytics-property' );

		if ( empty( $ua ) ) {
			return;
		}

		$ga = null;

		try {
			$ga = new AnalyticsJS( $ua );
		} catch ( InvalidArgumentException $iae ) {
			return;
		}

		if ( is_single() ) {

			global $post;

			/* Author dimension */

			try {
				$author_dim = get_option( 'ltk-google-analytics-dimension-author' );
				if ( ! empty( $author_dim ) ) {
					$author = get_the_author_meta( 'display_name' );
					$ga->dimension( $author_dim, $author );
				}
			} catch ( InvalidArgumentException $iae ) {
				// Discard
			}

			/* Category dimension */

			try {
				$category_dim = get_option( 'ltk-google-analytics-dimension-category' );
				if ( ! empty( $category_dim ) ) {
					$category = $this->buildCategoryList( $post->ID );
					if ( strlen( $category ) ) {
						$ga->dimension( $category_dim, $category );
					}
				}
			} catch ( InvalidArgumentException $iae ) {
				// Discard
			}

			/* Tag dimension */

			try {
				$tag_dim = get_option( 'ltk-google-analytics-dimension-tag' );
				if ( ! empty( $tag_dim ) ) {
					$tag = $this->buildTagList( $post->ID );
					if ( ! empty( $tag ) ) {
						$ga->dimension( $tag_dim, $tag );
					}
				}
			} catch ( InvalidArgumentException $iae ) {
				// Discard
			}

		}

		$ga->pageview();
		$js = $ga->generate();

		echo $js;

	}

	/**
	 * Generates a string with a list of category slugs for the GA dimension
	 *
	 * The string contains always a blank space after any category, even the last
	 * one, allowing you to regex like category-name\s. If the category is a
	 * child category, the parents will be put before, followed by an underscore.
	 * Being that said, it's not recommended to use underscores in category name.
	 * Also, you can regex for parent categories like parent-category_*.
	 *
	 * Examples:
	 *
	 * parent-category_child-category
	 *
	 * @see http://stackoverflow.com/questions/18403334/universal-analytics-push-multiple-values-for-one-dimension-and-one-pageview
	 * @param int $post_id
	 * @return string
	 */
	protected function buildCategoryList($post_id) {

		$list = wp_get_post_categories( $post_id );

		$string = '';
		foreach ( $list as $category_id ) {
			$string .= $this->retrieveCategoryParent( $category_id );
		}

		return $string;

	}

	/**
	 * Generates the category slug string following category tree. Recursive.
	 *
	 * @param int $category_id
	 * @param int $child Just used to check if the category has a child
	 * @return string
	 */
	private function retrieveCategoryParent($category_id, $child = null) {

		$WP_Term = get_category( $category_id );

		if ( $WP_Term === null ) {
			return '';
		}

		if ( $WP_Term->parent === 0 ) {
			$string = $WP_Term->slug;
			if ($child === null) {
				$string .= ' ';
			}
			return $string;
		} else {
			$string = $this->retrieveCategoryParent( $WP_Term->parent, $WP_Term->cat_ID ) . '_' . $WP_Term->slug;
			if ($child === null) {
				$string .= ' ';
			}
			return $string;
		}

	}

	/**
	 * Generates a string with a list of tag slugs for the GA dimension
	 *
	 * The string contains always a blank space after any tag, even the last one,
	 * allowing you to regex like tag-name\s.
	 *
	 * @see http://stackoverflow.com/questions/18403334/universal-analytics-push-multiple-values-for-one-dimension-and-one-pageview
	 * @param int $post_id
	 * @return string
	 */
	protected function buildTagList($post_id) {

		$list = wp_get_post_tags( $post_id );

		$string = '';
		foreach ( $list as $WP_Term ) {
			$string .= $WP_Term->slug . ' ';
		}

		return $string;

	}

}
