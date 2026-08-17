<?php
/**
 * Privacy-first analytics: Plausible.
 *
 * Cookieless, no personal data, no cross-site tracking, consistent with the
 * privacy page's promise. Ships inert: nothing is enqueued until the owner
 * sets the `plausible_domain` site setting. `plausible_host` supports a
 * self-hosted Plausible CE instance.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

namespace CodeCharmer\Core\Analytics;

use CodeCharmer\Core\Contracts\Bootable;
use CodeCharmer\Core\Setup\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Enqueues the Plausible script and the event queue shim.
 */
final class Plausible implements Bootable {

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public function boot(): void {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue' ) );
		add_filter( 'script_loader_tag', array( $this, 'defer_script' ), 10, 3 );
	}

	/**
	 * Enqueue the tracker when a domain is configured.
	 *
	 * @return void
	 */
	public function enqueue(): void {
		$domain = Options::get( 'plausible_domain' );
		if ( '' === $domain ) {
			return;
		}

		$host = untrailingslashit( Options::get( 'plausible_host' ) );
		if ( '' === $host ) {
			$host = 'https://plausible.io';
		}

		wp_enqueue_script(
			'codecharmer-plausible',
			$host . '/js/script.tagged-events.js',
			array(),
			null, // phpcs:ignore WordPress.WP.EnqueuedResourceParameters.MissingVersion -- Third-party evergreen script; versioning is the host's.
			false
		);

		// The custom-event queue shim, so track() calls made before the
		// script arrives are not lost.
		wp_add_inline_script(
			'codecharmer-plausible',
			'window.plausible=window.plausible||function(){(window.plausible.q=window.plausible.q||[]).push(arguments)};',
			'before'
		);
	}

	/**
	 * Add the defer + data-domain attributes to the tracker tag.
	 *
	 * @param string $tag    The script tag HTML.
	 * @param string $handle The script handle.
	 * @param string $src    The script source URL.
	 * @return string
	 */
	public function defer_script( string $tag, string $handle, string $src ): string {
		if ( 'codecharmer-plausible' !== $handle ) {
			return $tag;
		}

		$domain = Options::get( 'plausible_domain' );

		return str_replace(
			'<script src=',
			'<script defer data-domain="' . esc_attr( $domain ) . '" src=',
			$tag
		);
	}
}
