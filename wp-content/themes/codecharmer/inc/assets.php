<?php
/**
 * Front-end asset registration.
 *
 * Global stylesheet, the instrumented-rail layer, and the site runtime script
 * (header behavior, reveal-on-scroll, rail driver, contact form). Per-block
 * CSS ships with each block via block.json and is not enqueued here.
 *
 * @package CodeCharmer
 */

declare( strict_types=1 );

/**
 * Resolve a theme asset version from its file modification time.
 *
 * @param string $relative_path Path relative to the theme root.
 * @return string Version string for cache busting.
 */
function codecharmer_asset_version( string $relative_path ): string {
	$file = get_theme_file_path( $relative_path );
	$time = file_exists( $file ) ? filemtime( $file ) : false;
	return false !== $time ? (string) $time : wp_get_theme()->get( 'Version' );
}

/**
 * Enqueue global styles and the site runtime script.
 *
 * @return void
 */
function codecharmer_enqueue_assets(): void {
	wp_enqueue_style(
		'codecharmer-global',
		get_theme_file_uri( 'assets/css/global.css' ),
		array(),
		codecharmer_asset_version( 'assets/css/global.css' )
	);

	wp_enqueue_style(
		'codecharmer-rail',
		get_theme_file_uri( 'assets/css/rail.css' ),
		array( 'codecharmer-global' ),
		codecharmer_asset_version( 'assets/css/rail.css' )
	);

	wp_enqueue_script(
		'codecharmer-site',
		get_theme_file_uri( 'assets/js/site.js' ),
		array(),
		codecharmer_asset_version( 'assets/js/site.js' ),
		array(
			'in_footer' => true,
			'strategy'  => 'defer',
		)
	);
}
add_action( 'wp_enqueue_scripts', 'codecharmer_enqueue_assets' );

/**
 * Arm scroll reveals before first paint, but only when they can be delivered.
 *
 * IntersectionObserver callbacks ride rendering opportunities, so a tab that
 * starts hidden may never get one — arming the gate there would hide content
 * indefinitely. Motion off or document hidden: never gate.
 *
 * @return void
 */
function codecharmer_reveals_bootstrap(): void {
	?>
	<script>
		if (
			! window.matchMedia( '(prefers-reduced-motion: reduce)' ).matches &&
			document.visibilityState !== 'hidden'
		) {
			document.documentElement.classList.add( 'reveals-ready' );
		}
	</script>
	<?php
}
add_action( 'wp_head', 'codecharmer_reveals_bootstrap', 4 );
