<?php
/**
 * Indexing policy: which views search engines should keep.
 *
 * Noindexes the thin archive surfaces (author, date, search), trims the core
 * sitemap to real content, and registers the per-page SEO meta the rest of
 * the Seo layer reads.
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
 * Robots, sitemap and SEO-meta registration.
 */
final class IndexingPolicy implements Bootable {

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public function boot(): void {
		add_action( 'init', array( $this, 'register_meta' ) );
		add_filter( 'wp_robots', array( $this, 'robots' ) );
		add_filter( 'wp_sitemaps_add_provider', array( $this, 'sitemap_providers' ), 10, 2 );
	}

	/**
	 * Register the per-page SEO meta seeded from data/pages.php.
	 *
	 * @return void
	 */
	public function register_meta(): void {
		foreach ( array( 'page', 'post' ) as $type ) {
			$capability = 'page' === $type ? 'edit_pages' : 'edit_posts';
			foreach ( array( 'cc_seo_title', 'cc_seo_description', 'cc_seo_image' ) as $key ) {
				register_post_meta(
					$type,
					$key,
					array(
						'type'              => 'string',
						'single'            => true,
						'sanitize_callback' => 'cc_seo_image' === $key ? 'esc_url_raw' : 'sanitize_text_field',
						'show_in_rest'      => true,
						'auth_callback'     => static function () use ( $capability ): bool {
							return current_user_can( $capability );
						},
					)
				);
			}
		}
	}

	/**
	 * Noindex thin archive views; keep links followable.
	 *
	 * @param array<string,bool> $robots Robots directives.
	 * @return array<string,bool>
	 */
	public function robots( array $robots ): array {
		if ( is_author() || is_search() || is_date() || is_404() ) {
			$robots['noindex'] = true;
			$robots['follow']  = true;
			unset( $robots['max-image-preview'] );
		}
		return $robots;
	}

	/**
	 * Drop the users and taxonomy sitemap providers — neither surfaces
	 * content worth crawling on this site.
	 *
	 * @param \WP_Sitemaps_Provider $provider The provider.
	 * @param string                $name     Provider name.
	 * @return \WP_Sitemaps_Provider|false
	 */
	public function sitemap_providers( \WP_Sitemaps_Provider $provider, string $name ) {
		if ( in_array( $name, array( 'users', 'taxonomies' ), true ) ) {
			return false;
		}
		return $provider;
	}
}
