<?php
/**
 * Plugin Name:       Code Charmer Core
 * Plugin URI:        https://codecharmer.io/
 * Description:       Content model, Gutenberg blocks, inquiry endpoint, SEO tags and content seeding for Code Charmer. All business logic lives here — presentation lives in the codecharmer theme.
 * Version:           1.0.0
 * Requires at least: 6.8
 * Requires PHP:      8.3
 * Author:            Code Charmer
 * Author URI:        https://codecharmer.io/
 * License:           GPL-2.0-or-later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:       codecharmer-core
 * Domain Path:       /languages
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

namespace CodeCharmer\Core;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

define( 'CODECHARMER_CORE_VERSION', '1.0.0' );
define( 'CODECHARMER_CORE_FILE', __FILE__ );
define( 'CODECHARMER_CORE_DIR', plugin_dir_path( __FILE__ ) );
define( 'CODECHARMER_CORE_URL', plugin_dir_url( __FILE__ ) );
define( 'CODECHARMER_CORE_MIN_PHP', '8.3' );

/**
 * Prefer Composer's autoloader; fall back to a lightweight PSR-4 loader so the
 * plugin runs on a plain deploy without a `composer install` step.
 */
if ( is_readable( CODECHARMER_CORE_DIR . 'vendor/autoload.php' ) ) {
	require_once CODECHARMER_CORE_DIR . 'vendor/autoload.php';
} else {
	require_once CODECHARMER_CORE_DIR . 'src/Support/Autoloader.php';
	Support\Autoloader::register( 'CodeCharmer\\Core\\', CODECHARMER_CORE_DIR . 'src/' );
}

/**
 * Hard requirement guard: bail with an admin notice on unsupported PHP.
 */
if ( version_compare( PHP_VERSION, CODECHARMER_CORE_MIN_PHP, '<' ) ) {
	add_action(
		'admin_notices',
		static function (): void {
			echo '<div class="notice notice-error"><p>';
			printf(
				/* translators: 1: required PHP version, 2: current PHP version */
				esc_html__( 'Code Charmer Core requires PHP %1$s or newer. This server runs %2$s.', 'codecharmer-core' ),
				esc_html( CODECHARMER_CORE_MIN_PHP ),
				esc_html( PHP_VERSION )
			);
			echo '</p></div>';
		}
	);
	return;
}

// Activation / deactivation lifecycle.
register_activation_hook( __FILE__, array( Setup\Activator::class, 'activate' ) );
register_deactivation_hook( __FILE__, array( Setup\Activator::class, 'deactivate' ) );

/**
 * Boot the plugin once the plugin stack is ready.
 */
add_action(
	'plugins_loaded',
	static function (): void {
		Plugin::instance()->boot();
	},
	20
);
