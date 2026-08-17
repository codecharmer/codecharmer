<?php
/**
 * SEO meta tags: title overrides, description + Open Graph / Twitter cards.
 * Deliberately small — no SEO plugin dependency.
 *
 * Per-page overrides come from the `cc_seo_title` / `cc_seo_description` /
 * `cc_seo_image` post meta (registered in IndexingPolicy, seeded from
 * data/pages.php). Every value degrades to the previous behavior when unset.
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
		add_filter( 'pre_get_document_title', array( $this, 'title_override' ) );
	}

	/**
	 * Replace the document title with the page's seeded SEO title, if any.
	 *
	 * Runs on `pre_get_document_title` so core never appends the "– Site Name"
	 * suffix to a title that already carries its own brand suffix.
	 *
	 * @param string $title Incoming (empty) title.
	 * @return string
	 */
	public function title_override( string $title ): string {
		$seo_title = $this->seo_meta( 'cc_seo_title' );
		return '' !== $seo_title ? $seo_title : $title;
	}

	/**
	 * Read one SEO meta value for the current singular view (front page included).
	 *
	 * @param string $key Meta key.
	 * @return string
	 */
	private function seo_meta( string $key ): string {
		if ( ! is_singular() && ! is_front_page() ) {
			return '';
		}
		$post = get_queried_object();
		if ( ! $post instanceof \WP_Post ) {
			return '';
		}
		return (string) get_post_meta( $post->ID, $key, true );
	}

	/**
	 * Resolve the description for the current view.
	 *
	 * @return string
	 */
	private function description(): string {
		$description = $this->seo_meta( 'cc_seo_description' );

		if ( '' === $description ) {
			$description = get_bloginfo( 'description' );
			if ( is_singular() ) {
				$post = get_queried_object();
				if ( $post instanceof \WP_Post && '' !== $post->post_excerpt ) {
					$description = $post->post_excerpt;
				}
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
	 * Resolve the social card image URL for the current view.
	 *
	 * Per-page `cc_seo_image` meta wins; otherwise the site-wide card that
	 * ships inside the plugin (no media-library import required).
	 *
	 * @return string
	 */
	private function image(): string {
		$image = $this->seo_meta( 'cc_seo_image' );
		if ( '' === $image ) {
			$image = plugins_url( 'assets/social-card.png', CODECHARMER_CORE_FILE );
		}

		/**
		 * Filter the social card image URL.
		 *
		 * @param string $image The image URL.
		 */
		return (string) apply_filters( 'codecharmer_social_image', $image );
	}

	/**
	 * Resolve the canonical URL for the current view, if determinable.
	 *
	 * @return string
	 */
	private function url(): string {
		if ( is_front_page() ) {
			return home_url( '/' );
		}
		if ( is_singular() ) {
			return (string) get_permalink();
		}
		return '';
	}

	/**
	 * Output the tags.
	 *
	 * @return void
	 */
	public function render(): void {
		$description = wp_strip_all_tags( $this->description() );
		$title       = wp_get_document_title();
		$image       = $this->image();
		$url         = $this->url();

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
		if ( '' !== $url ) {
			printf( '<meta property="og:url" content="%s" />' . "\n", esc_url( $url ) );
		}
		printf( '<meta property="og:image" content="%s" />' . "\n", esc_url( $image ) );
		echo '<meta property="og:image:width" content="1200" />' . "\n";
		echo '<meta property="og:image:height" content="630" />' . "\n";
		printf( '<meta property="og:image:alt" content="%s" />' . "\n", esc_attr( get_bloginfo( 'name' ) ) );
		echo '<meta name="twitter:card" content="summary_large_image" />' . "\n";
		printf( '<meta name="twitter:title" content="%s" />' . "\n", esc_attr( $title ) );
		if ( '' !== $description ) {
			printf( '<meta name="twitter:description" content="%s" />' . "\n", esc_attr( $description ) );
		}
		printf( '<meta name="twitter:image" content="%s" />' . "\n", esc_url( $image ) );
	}
}
