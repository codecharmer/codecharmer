<?php
/**
 * Minimal PSR-4 autoloader used when Composer's autoloader is absent.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

namespace CodeCharmer\Core\Support;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Minimal PSR-4 autoloader.
 */
final class Autoloader {

	/**
	 * Register a PSR-4 prefix → base directory mapping.
	 *
	 * @param string $prefix   Namespace prefix, e.g. "CodeCharmer\Core\".
	 * @param string $base_dir Absolute base directory for the prefix.
	 * @return void
	 */
	public static function register( string $prefix, string $base_dir ): void {
		$prefix   = rtrim( $prefix, '\\' ) . '\\';
		$base_dir = rtrim( $base_dir, '/\\' ) . '/';

		spl_autoload_register(
			static function ( string $class_name ) use ( $prefix, $base_dir ): void {
				if ( 0 !== strpos( $class_name, $prefix ) ) {
					return;
				}
				$relative = substr( $class_name, strlen( $prefix ) );
				$file     = $base_dir . str_replace( '\\', '/', $relative ) . '.php';
				if ( is_readable( $file ) ) {
					require_once $file;
				}
			}
		);
	}
}
