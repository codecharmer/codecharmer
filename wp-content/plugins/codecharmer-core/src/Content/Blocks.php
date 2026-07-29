<?php
/**
 * Block registration: every block manifest in the compiled build output.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

namespace CodeCharmer\Core\Content;

use CodeCharmer\Core\Contracts\Bootable;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Registers compiled blocks and the block category.
 */
final class Blocks implements Bootable {

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public function boot(): void {
		add_action( 'init', array( $this, 'register_blocks' ) );
		add_filter( 'block_categories_all', array( $this, 'register_category' ) );
		add_action( 'admin_notices', array( $this, 'missing_build_notice' ) );
	}

	/**
	 * Register every compiled block.
	 *
	 * @return void
	 */
	public function register_blocks(): void {
		$manifests = glob( CODECHARMER_CORE_DIR . 'build/blocks/*/block.json' );
		if ( ! is_array( $manifests ) ) {
			return;
		}
		foreach ( $manifests as $manifest ) {
			register_block_type( dirname( $manifest ) );
		}
	}

	/**
	 * Prepend the Code Charmer block category.
	 *
	 * @param array<int,array<string,string>> $categories Existing categories.
	 * @return array<int,array<string,string>>
	 */
	public function register_category( array $categories ): array {
		return array_merge(
			array(
				array(
					'slug'  => 'codecharmer',
					'title' => __( 'Code Charmer', 'codecharmer-core' ),
				),
			),
			$categories
		);
	}

	/**
	 * Surface a clear admin notice when the block build output is missing.
	 *
	 * @return void
	 */
	public function missing_build_notice(): void {
		if ( is_dir( CODECHARMER_CORE_DIR . 'build/blocks' ) ) {
			return;
		}
		if ( ! current_user_can( 'manage_options' ) ) {
			return;
		}
		echo '<div class="notice notice-warning"><p>';
		esc_html_e( 'Code Charmer Core: block build output is missing. Run "npm run build" in the plugin (or deploy a built artifact) to register the blocks.', 'codecharmer-core' );
		echo '</p></div>';
	}
}
