<?php
/**
 * Site options — the small set of brand facts blocks read at render time.
 *
 * Stored in one option so a single cached read serves every block. Seeded by
 * the installer; every value is filterable and has a safe default, so blocks
 * render sensibly even before seeding.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

namespace CodeCharmer\Core\Setup;

use CodeCharmer\Core\Contracts\Bootable;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Read/write facade for the site settings option.
 */
final class Options implements Bootable {

	public const OPTION = 'codecharmer_settings';

	/**
	 * Pages map option: slug → post ID, written by the installer.
	 */
	public const PAGES_OPTION = 'codecharmer_pages';

	/**
	 * No hooks needed; this service is a read/write facade.
	 *
	 * @return void
	 */
	public function boot(): void {}

	/**
	 * Default settings — the brand layer's runtime facts.
	 *
	 * @return array<string,string>
	 */
	public static function defaults(): array {
		return array(
			'email'          => 'codecharmer@codecharmer.io',
			'tagline'        => __( 'Digital systems that create business value.', 'codecharmer-core' ),
			'cta_label'      => __( 'Book a consultation', 'codecharmer-core' ),
			'cta_url'        => '/contact',
			'response_time'  => __( 'within one business day', 'codecharmer-core' ),
			'scheduling_url' => '',
		);
	}

	/**
	 * Read one setting with its default.
	 *
	 * @param string $key Setting key.
	 * @return string
	 */
	public static function get( string $key ): string {
		$defaults = self::defaults();
		$stored   = get_option( self::OPTION, array() );
		$value    = is_array( $stored ) && isset( $stored[ $key ] ) ? (string) $stored[ $key ] : ( $defaults[ $key ] ?? '' );

		/**
		 * Filter a Code Charmer site setting.
		 *
		 * @param string $value The resolved value.
		 * @param string $key   The setting key.
		 */
		return (string) apply_filters( 'codecharmer_setting', $value, $key );
	}

	/**
	 * Resolve a seeded page's permalink by its seed slug.
	 *
	 * Falls back to a root-relative path so links keep working even when the
	 * pages map has not been written (e.g. before first seed).
	 *
	 * @param string $slug Seed slug, e.g. "contact" or "services/wordpress".
	 * @return string
	 */
	public static function page_url( string $slug ): string {
		$map = get_option( self::PAGES_OPTION, array() );
		if ( is_array( $map ) && isset( $map[ $slug ] ) ) {
			$url = get_permalink( (int) $map[ $slug ] );
			if ( is_string( $url ) && '' !== $url ) {
				return $url;
			}
		}
		return home_url( '/' . ltrim( $slug, '/' ) . '/' );
	}

	/**
	 * The seeded service pages, in menu order.
	 *
	 * @return array<int,array{id:int,title:string,url:string,icon:string,descriptor:string,thesis:string}>
	 */
	public static function service_pages(): array {
		$map = get_option( self::PAGES_OPTION, array() );
		if ( ! is_array( $map ) || empty( $map['services'] ) ) {
			return array();
		}

		$query = new \WP_Query(
			array(
				'post_type'              => 'page',
				'post_parent'            => (int) $map['services'],
				'posts_per_page'         => 10,
				'orderby'                => 'menu_order',
				'order'                  => 'ASC',
				'no_found_rows'          => true,
				'update_post_term_cache' => false,
			)
		);

		$services = array();
		foreach ( $query->posts as $page ) {
			$services[] = array(
				'id'         => (int) $page->ID,
				'title'      => (string) get_the_title( $page ),
				'url'        => (string) get_permalink( $page ),
				'icon'       => (string) get_post_meta( $page->ID, 'cc_icon', true ),
				'descriptor' => (string) get_post_meta( $page->ID, 'cc_descriptor', true ),
				'thesis'     => (string) get_post_meta( $page->ID, 'cc_thesis', true ),
			);
		}
		return $services;
	}
}
