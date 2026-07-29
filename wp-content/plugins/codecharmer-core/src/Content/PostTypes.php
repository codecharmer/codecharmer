<?php
/**
 * Content model: the cc_project CPT and the page meta service pages carry.
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
 * Registers the project post type and page meta.
 */
final class PostTypes implements Bootable {

	public const PROJECT = 'cc_project';

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public function boot(): void {
		add_action( 'init', array( $this, 'register_project_type' ) );
		add_action( 'init', array( $this, 'register_meta' ) );
	}

	/**
	 * Selected-work projects.
	 *
	 * @return void
	 */
	public function register_project_type(): void {
		register_post_type(
			self::PROJECT,
			array(
				'labels'       => array(
					'name'          => __( 'Projects', 'codecharmer-core' ),
					'singular_name' => __( 'Project', 'codecharmer-core' ),
					'add_new_item'  => __( 'Add project', 'codecharmer-core' ),
					'edit_item'     => __( 'Edit project', 'codecharmer-core' ),
				),
				'public'       => false,
				'show_ui'      => true,
				'show_in_rest' => true,
				'menu_icon'    => 'dashicons-portfolio',
				'supports'     => array( 'title', 'editor', 'thumbnail', 'page-attributes', 'custom-fields' ),
				'hierarchical' => false,
			)
		);
	}

	/**
	 * Registered meta: project fields + the service-page fields.
	 *
	 * @return void
	 */
	public function register_meta(): void {
		$string_meta = array( 'sanitize_callback' => 'sanitize_text_field' );

		register_post_meta(
			self::PROJECT,
			'cc_url',
			array(
				'type'              => 'string',
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		register_post_meta(
			self::PROJECT,
			'cc_descriptor',
			array(
				'type'              => 'string',
				'single'            => true,
				'show_in_rest'      => true,
				'sanitize_callback' => 'sanitize_textarea_field',
			)
		);
		register_post_meta(
			self::PROJECT,
			'cc_tags',
			array(
				'type'              => 'array',
				'single'            => true,
				'show_in_rest'      => array(
					'schema' => array(
						'type'  => 'array',
						'items' => array( 'type' => 'string' ),
					),
				),
				'sanitize_callback' => static function ( $value ): array {
					return array_map( 'sanitize_text_field', (array) $value );
				},
			)
		);

		// Service pages: icon slug, short descriptor and thesis line.
		foreach ( array( 'cc_icon', 'cc_descriptor', 'cc_thesis' ) as $key ) {
			register_post_meta(
				'page',
				$key,
				array_merge(
					$string_meta,
					array(
						'type'         => 'string',
						'single'       => true,
						'show_in_rest' => true,
					)
				)
			);
		}
	}
}
