<?php
/**
 * Content installer.
 *
 * Creates the site's pages (block markup from data/pages.php), the project
 * posts (data/projects.php, with media import), site options and the reading
 * settings. Idempotent: existing pages/projects are updated by seed slug, and
 * a completed run is stamped so accidental re-runs are cheap no-ops.
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
 * Seeds pages, projects, media and options.
 */
final class Installer {

	private const SEEDED_META = '_codecharmer_seeded';

	/**
	 * Run the full install: options, pages, projects, front page.
	 *
	 * @return array<string,int> Map of seed slug → page ID.
	 */
	public function install(): array {
		$this->install_options();
		$pages = $this->install_pages();
		$this->install_projects();
		$this->assign_front_page( $pages );

		update_option( 'codecharmer_installed_at', gmdate( 'c' ), false );
		return $pages;
	}

	/**
	 * Seed the settings option (only keys not already customized).
	 *
	 * @return void
	 */
	private function install_options(): void {
		$data = $this->load_data( 'settings' );

		$stored = get_option( Options::OPTION, array() );
		$stored = is_array( $stored ) ? $stored : array();
		update_option( Options::OPTION, array_merge( $data['settings'] ?? array(), $stored ) );

		if ( ! empty( $data['blogname'] ) ) {
			update_option( 'blogname', sanitize_text_field( (string) $data['blogname'] ) );
		}
		if ( ! empty( $data['blogdescription'] ) ) {
			update_option( 'blogdescription', sanitize_text_field( (string) $data['blogdescription'] ) );
		}
	}

	/**
	 * Create/update every page from data/pages.php.
	 *
	 * Pages are keyed by seed slug (path-style for children). A page that was
	 * seeded before is updated in place; a page the owner created manually
	 * with the same slug is left alone.
	 *
	 * @return array<string,int> Map of seed slug → page ID.
	 */
	private function install_pages(): array {
		$pages = $this->load_data( 'pages' );
		$map   = get_option( Options::PAGES_OPTION, array() );
		$map   = is_array( $map ) ? $map : array();

		// Two passes so children can reference their parent's new ID.
		foreach ( array( 'parents', 'children' ) as $pass ) {
			foreach ( $pages as $slug => $page ) {
				$is_child = str_contains( $slug, '/' );
				if ( ( 'parents' === $pass && $is_child ) || ( 'children' === $pass && ! $is_child ) ) {
					continue;
				}

				$parent_id = 0;
				$leaf_slug = $slug;
				if ( $is_child ) {
					list( $parent_slug, $leaf_slug ) = explode( '/', $slug, 2 );
					$parent_id                       = (int) ( $map[ $parent_slug ] ?? 0 );
				}

				$postarr = array(
					'post_title'   => (string) $page['title'],
					'post_name'    => $leaf_slug,
					'post_content' => (string) $page['content'],
					'post_status'  => 'publish',
					'post_type'    => 'page',
					'post_parent'  => $parent_id,
					'menu_order'   => (int) ( $page['order'] ?? 0 ),
				);
				if ( ! empty( $page['excerpt'] ) ) {
					$postarr['post_excerpt'] = (string) $page['excerpt'];
				}

				$existing_id = (int) ( $map[ $slug ] ?? 0 );
				if ( $existing_id && get_post( $existing_id ) ) {
					$postarr['ID'] = $existing_id;
					$page_id       = wp_update_post( wp_slash( $postarr ), true );
				} else {
					$page_id = wp_insert_post( wp_slash( $postarr ), true );
				}

				if ( is_wp_error( $page_id ) || 0 === $page_id ) {
					continue;
				}

				update_post_meta( $page_id, self::SEEDED_META, '1' );
				foreach ( (array) ( $page['meta'] ?? array() ) as $meta_key => $meta_value ) {
					update_post_meta( $page_id, $meta_key, $meta_value );
				}

				$map[ $slug ] = (int) $page_id;
			}
		}

		update_option( Options::PAGES_OPTION, $map );
		return $map;
	}

	/**
	 * Create/update project posts with imported screenshots.
	 *
	 * @return void
	 */
	private function install_projects(): void {
		$projects = $this->load_data( 'projects' );

		foreach ( $projects as $order => $project ) {
			$slug     = sanitize_title( (string) $project['name'] );
			$existing = new \WP_Query(
				array(
					'post_type'      => PostTypes::PROJECT,
					'name'           => $slug,
					'posts_per_page' => 1,
					'post_status'    => 'any',
					'no_found_rows'  => true,
					'fields'         => 'ids',
				)
			);

			$postarr = array(
				'post_title'  => (string) $project['name'],
				'post_name'   => $slug,
				'post_status' => 'publish',
				'post_type'   => PostTypes::PROJECT,
				'menu_order'  => (int) $order,
			);

			if ( $existing->posts ) {
				$postarr['ID'] = (int) $existing->posts[0];
				$post_id       = wp_update_post( wp_slash( $postarr ), true );
			} else {
				$post_id = wp_insert_post( wp_slash( $postarr ), true );
			}
			if ( is_wp_error( $post_id ) || 0 === $post_id ) {
				continue;
			}

			update_post_meta( $post_id, 'cc_url', esc_url_raw( (string) $project['url'] ) );
			update_post_meta( $post_id, 'cc_descriptor', sanitize_textarea_field( (string) $project['descriptor'] ) );
			update_post_meta( $post_id, 'cc_tags', array_map( 'sanitize_text_field', (array) $project['tags'] ) );

			if ( ! empty( $project['image'] ) ) {
				$attachment_id = MediaImporter::import(
					(string) $project['image'],
					sprintf(
						/* translators: %s: project name */
						__( 'Screenshot of the %s website', 'codecharmer-core' ),
						(string) $project['name']
					)
				);
				if ( $attachment_id > 0 ) {
					set_post_thumbnail( $post_id, $attachment_id );
				}
			}
		}
	}

	/**
	 * Point the reading settings at the seeded home page.
	 *
	 * @param array<string,int> $pages Seed slug → page ID map.
	 * @return void
	 */
	private function assign_front_page( array $pages ): void {
		if ( empty( $pages['home'] ) ) {
			return;
		}
		update_option( 'show_on_front', 'page' );
		update_option( 'page_on_front', (int) $pages['home'] );

		// Route parity with the original static site requires pretty permalinks.
		if ( '/%postname%/' !== get_option( 'permalink_structure' ) ) {
			update_option( 'permalink_structure', '/%postname%/' );
			flush_rewrite_rules(); // phpcs:ignore WordPressVIPMinimum.Functions.RestrictedFunctions.flush_rewrite_rules_flush_rewrite_rules -- One-time CLI seeding, not runtime.
		}
	}

	/**
	 * Load a data file from the brand layer.
	 *
	 * @param string $name Data file basename (pages, projects, settings).
	 * @return array<mixed>
	 */
	private function load_data( string $name ): array {
		$file = CODECHARMER_CORE_DIR . 'data/' . $name . '.php';
		if ( ! is_readable( $file ) ) {
			return array();
		}
		$data = include $file;
		return is_array( $data ) ? $data : array();
	}
}
