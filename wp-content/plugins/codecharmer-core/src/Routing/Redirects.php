<?php
/**
 * Legacy-URL routing: exact-path 301s and 410s.
 *
 * The static-era `/pricing.html` moves permanently to the seeded pricing
 * page; deleted default WordPress content answers 410 Gone rather than
 * redirecting to the homepage. One hop, no chains.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

namespace CodeCharmer\Core\Routing;

use CodeCharmer\Core\Contracts\Bootable;
use CodeCharmer\Core\Setup\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Handles legacy paths before the 404 template renders.
 */
final class Redirects implements Bootable {

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public function boot(): void {
		add_action( 'template_redirect', array( $this, 'handle' ), 1 );
	}

	/**
	 * Redirect map: legacy path → destination URL.
	 *
	 * @return array<string,string>
	 */
	private function redirect_map(): array {
		$map = array(
			'/pricing.html'             => Options::page_url( 'pricing' ),
			'/services'                 => Options::page_url( 'solutions' ),
			'/services/ai-strategy'     => Options::page_url( 'solutions/ai-strategy' ),
			'/services/wordpress'       => Options::page_url( 'solutions/wordpress' ),
			'/services/custom-software' => Options::page_url( 'solutions/custom-software' ),
			'/services/ai-automation'   => Options::page_url( 'solutions/ai-automation' ),
		);

		/**
		 * Filter the legacy redirect map (path → destination URL).
		 *
		 * @param array<string,string> $map The redirect map.
		 */
		return (array) apply_filters( 'codecharmer_redirects', $map );
	}

	/**
	 * Paths that are gone for good (deleted default WordPress content).
	 *
	 * @return string[]
	 */
	private function gone(): array {
		$paths = array( '/hello-world', '/sample-page' );

		/**
		 * Filter the list of paths answering 410 Gone.
		 *
		 * @param string[] $paths Root-relative paths, no trailing slash.
		 */
		return (array) apply_filters( 'codecharmer_gone_paths', $paths );
	}

	/**
	 * Match the requested path against the maps and answer early.
	 *
	 * @return void
	 */
	public function handle(): void {
		if ( ! is_404() ) {
			return;
		}

		$request = isset( $_SERVER['REQUEST_URI'] ) ? (string) wp_unslash( $_SERVER['REQUEST_URI'] ) : ''; // phpcs:ignore WordPress.Security.ValidatedSanitizedInput.InputNotSanitized -- Parsed and compared against a fixed map only.
		$path    = (string) wp_parse_url( $request, PHP_URL_PATH );
		if ( '' === $path ) {
			return;
		}
		$normalized = '/' . trim( $path, '/' );

		foreach ( $this->redirect_map() as $legacy => $destination ) {
			if ( '/' . trim( $legacy, '/' ) === $normalized && '' !== $destination ) {
				wp_safe_redirect( $destination, 301 );
				exit;
			}
		}

		if ( in_array( $normalized, $this->gone(), true ) ) {
			status_header( 410 );
			nocache_headers();
			exit;
		}
	}
}
