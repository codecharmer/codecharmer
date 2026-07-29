<?php
/**
 * WP-CLI commands: wp codecharmer install.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

namespace CodeCharmer\Core\Cli;

use CodeCharmer\Core\Contracts\Bootable;
use CodeCharmer\Core\Setup\Installer;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * WP-CLI command surface (wp codecharmer …).
 */
final class Commands implements Bootable {

	/**
	 * Register the command when running under WP-CLI.
	 *
	 * @return void
	 */
	public function boot(): void {
		if ( ! defined( 'WP_CLI' ) || ! WP_CLI ) {
			return;
		}
		\WP_CLI::add_command( 'codecharmer', $this );
	}

	/**
	 * Install the Code Charmer site content.
	 *
	 * Creates every page with its block markup, the project posts with their
	 * screenshots, the site options, and assigns the front page. Idempotent:
	 * previously seeded content is updated in place, never duplicated.
	 *
	 * ## EXAMPLES
	 *
	 *     wp codecharmer install
	 *
	 * @subcommand install
	 * @when after_wp_load
	 *
	 * @return void
	 */
	public function install(): void {
		$installer = new Installer();
		$pages     = $installer->install();

		\WP_CLI::success(
			sprintf(
				'Code Charmer content installed: %d pages, front page assigned.',
				count( $pages )
			)
		);
	}
}
