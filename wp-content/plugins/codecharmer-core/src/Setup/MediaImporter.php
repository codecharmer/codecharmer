<?php
/**
 * Media importer: turns bundled source images into attachments.
 *
 * Used only by the seeder (CLI / one-time install). Images live in
 * data/media/source/<key>.<ext>; an imported key is remembered so re-running
 * the installer never duplicates attachments.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

namespace CodeCharmer\Core\Setup;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Imports bundled source images as attachments.
 */
final class MediaImporter {

	private const REGISTRY_OPTION = 'codecharmer_media_map';

	/**
	 * Import (or find) the attachment for a media key.
	 *
	 * @param string $key  Media key — the source file's basename without extension.
	 * @param string $alt  Alt text for the attachment.
	 * @return int Attachment ID, or 0 on failure.
	 */
	public static function import( string $key, string $alt = '' ): int {
		$map = get_option( self::REGISTRY_OPTION, array() );
		if ( is_array( $map ) && ! empty( $map[ $key ] ) && get_post( (int) $map[ $key ] ) ) {
			return (int) $map[ $key ];
		}

		$source = self::source_path( $key );
		if ( '' === $source ) {
			return 0;
		}

		$attachment_id = self::sideload( $source, $alt );
		if ( $attachment_id > 0 ) {
			$map         = is_array( $map ) ? $map : array();
			$map[ $key ] = $attachment_id;
			update_option( self::REGISTRY_OPTION, $map, false );
		}
		return $attachment_id;
	}

	/**
	 * Locate the bundled source file for a key.
	 *
	 * @param string $key Media key.
	 * @return string Absolute path, or empty string.
	 */
	private static function source_path( string $key ): string {
		$base = CODECHARMER_CORE_DIR . 'data/media/source/';
		foreach ( array( 'jpg', 'jpeg', 'png', 'webp', 'svg' ) as $ext ) {
			$candidate = $base . $key . '.' . $ext;
			if ( is_readable( $candidate ) ) {
				return $candidate;
			}
		}
		return '';
	}

	/**
	 * Copy a local file into the uploads dir and register it as an attachment.
	 *
	 * @param string $source Absolute path to the bundled file.
	 * @param string $alt    Alt text.
	 * @return int Attachment ID, or 0 on failure.
	 */
	private static function sideload( string $source, string $alt ): int {
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/image.php';

		global $wp_filesystem;
		if ( ! $wp_filesystem ) {
			WP_Filesystem();
		}

		$uploads = wp_upload_dir();
		if ( ! empty( $uploads['error'] ) ) {
			return 0;
		}

		$filename    = wp_unique_filename( $uploads['path'], basename( $source ) );
		$destination = trailingslashit( $uploads['path'] ) . $filename;

		if ( ! $wp_filesystem || ! $wp_filesystem->copy( $source, $destination, true, FS_CHMOD_FILE ) ) {
			return 0;
		}

		$filetype = wp_check_filetype( $filename );

		$attachment_id = wp_insert_attachment(
			array(
				'post_mime_type' => (string) $filetype['type'],
				'post_title'     => sanitize_text_field( pathinfo( $filename, PATHINFO_FILENAME ) ),
				'post_status'    => 'inherit',
			),
			$destination
		);

		if ( is_wp_error( $attachment_id ) || 0 === $attachment_id ) {
			return 0;
		}

		$metadata = wp_generate_attachment_metadata( $attachment_id, $destination );
		wp_update_attachment_metadata( $attachment_id, $metadata );
		if ( '' !== $alt ) {
			update_post_meta( $attachment_id, '_wp_attachment_image_alt', $alt );
		}

		return (int) $attachment_id;
	}
}
