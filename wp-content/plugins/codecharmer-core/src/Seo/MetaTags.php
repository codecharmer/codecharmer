<?php
/**
 * SEO meta tags: description + Open Graph / Twitter card parity with the
 * original static build. Deliberately small — no SEO plugin dependency.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

namespace CodeCharmer\Core\Seo;

use CodeCharmer\Core\Contracts\Bootable;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Outputs description and social meta tags.
 */
final class MetaTags implements Bootable {

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public function boot(): void {
		add_action( 'wp_head', array( $this, 'render' ), 6 );
	}

	/**
	 * Resolve the description for the current view.
	 *
	 * @return string
	 */
	private function description(): string {
		$description = get_bloginfo( 'description' );
		if ( is_singular() ) {
			$post = get_queried_object();
			if ( $post instanceof \WP_Post && '' !== $post->post_excerpt ) {
				$description = $post->post_excerpt;
			}
		}

		/**
		 * Filter the rendered meta description.
		 *
		 * @param string $description The description.
		 */
		return (string) apply_filters( 'codecharmer_meta_description', $description );
	}

	/**
	 * Output the tags.
	 *
	 * @return void
	 */
	public function render(): void {
		$description = wp_strip_all_tags( $this->description() );
		$title       = wp_get_document_title();
		$url         = is_singular() ? (string) get_permalink() : home_url( add_query_arg( array(), (string) wp_parse_url( home_url(), PHP_URL_PATH ) ) );

		if ( '' !== $description ) {
			printf( '<meta name="description" content="%s" />' . "\n", esc_attr( $description ) );
		}
		printf( '<meta name="theme-color" content="%s" />' . "\n", esc_attr( '#0f1720' ) );
		echo '<meta property="og:type" content="website" />' . "\n";
		printf( '<meta property="og:site_name" content="%s" />' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
		printf( '<meta property="og:title" content="%s" />' . "\n", esc_attr( $title ) );
		if ( '' !== $description ) {
			printf( '<meta property="og:description" content="%s" />' . "\n", esc_attr( $description ) );
		}
		if ( is_singular() ) {
			printf( '<meta property="og:url" content="%s" />' . "\n", esc_url( (string) get_permalink() ) );
		}
		echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
	}
}
