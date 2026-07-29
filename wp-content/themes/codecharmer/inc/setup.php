<?php
/**
 * Theme supports, menus and editor configuration.
 *
 * @package CodeCharmer
 */

declare( strict_types=1 );

/**
 * Register theme supports and navigation menu locations.
 *
 * @return void
 */
function codecharmer_setup(): void {
	add_theme_support( 'wp-block-styles' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'editor-styles' );
	add_editor_style( array( 'assets/css/global.css', 'assets/css/rail.css' ) );

	register_nav_menus(
		array(
			'primary' => __( 'Primary navigation', 'codecharmer' ),
			'footer'  => __( 'Footer navigation', 'codecharmer' ),
		)
	);
}
add_action( 'after_setup_theme', 'codecharmer_setup' );

/**
 * Output the brand favicon (inline SVG data URI) unless a Site Icon is set.
 *
 * @return void
 */
function codecharmer_favicon(): void {
	if ( get_option( 'site_icon' ) ) {
		return;
	}
	$svg = "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='7' fill='%230f1720'/%3E%3Cpath d='M11 20 21 9' stroke='%23e8fbfe' stroke-width='2.4' stroke-linecap='round'/%3E%3Cpath d='M22 6c.3 2 .8 3 2.5 3.6C22.8 10.2 22.3 11.2 22 13c-.3-1.8-.8-2.8-2.5-3.4C21.2 9 21.7 8 22 6Z' fill='%2340d6e8'/%3E%3C/svg%3E";
	printf( '<link rel="icon" href="%s" />' . "\n", esc_attr( $svg ) );
}
add_action( 'wp_head', 'codecharmer_favicon', 5 );
