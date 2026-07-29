<?php
/**
 * Activation / deactivation lifecycle.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

namespace CodeCharmer\Core\Setup;

use CodeCharmer\Core\Content\PostTypes;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Activation and deactivation lifecycle handlers.
 */
final class Activator {

	/**
	 * On activation: register types so rewrite rules exist, then flush once.
	 *
	 * @return void
	 */
	public static function activate(): void {
		( new PostTypes() )->register_project_type();
		flush_rewrite_rules(); // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.flush_rewrite_rules_flush_rewrite_rules -- One-time activation hook, not runtime.
	}

	/**
	 * On deactivation: flush rules so the CPT's rules are removed.
	 *
	 * @return void
	 */
	public static function deactivate(): void {
		flush_rewrite_rules(); // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.flush_rewrite_rules_flush_rewrite_rules -- One-time deactivation hook, not runtime.
	}
}
