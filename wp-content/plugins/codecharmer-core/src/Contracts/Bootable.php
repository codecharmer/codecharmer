<?php
/**
 * Bootable service contract.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

namespace CodeCharmer\Core\Contracts;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

interface Bootable {

	/**
	 * Register the service's hooks. Called once, on `plugins_loaded` (priority 20).
	 *
	 * @return void
	 */
	public function boot(): void;
}
