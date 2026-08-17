<?php
/**
 * CTA band render.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;
use CodeCharmer\Core\Setup\Options;

$cc_heading = (string) ( $attributes['heading'] ?? '' );
$cc_body    = (string) ( $attributes['body'] ?? '' );
$cc_email   = Options::get( 'email' );

// Per-instance button overrides; empty values keep the site-wide defaults.
$cc_primary_label   = (string) ( $attributes['primaryLabel'] ?? '' );
$cc_primary_url     = (string) ( $attributes['primaryUrl'] ?? '' );
$cc_secondary_label = (string) ( $attributes['secondaryLabel'] ?? '' );
$cc_secondary_url   = (string) ( $attributes['secondaryUrl'] ?? '' );

if ( '' === $cc_primary_label || '' === $cc_primary_url ) {
	$cc_primary_label = Options::get( 'cta_label' );
	$cc_primary_url   = Options::page_url( 'contact' );
}
if ( '' === $cc_secondary_label || '' === $cc_secondary_url ) {
	$cc_secondary_label = __( 'Email us', 'codecharmer-core' );
	$cc_secondary_url   = 'mailto:' . $cc_email;
}
?>
<section class="cta band-ink">
	<div class="cta__glow" aria-hidden="true"></div>
	<div class="container cta__inner reveal">
		<h2 class="cta__heading"><?php echo esc_html( $cc_heading ); ?></h2>
		<?php if ( '' !== $cc_body ) : ?>
			<p class="cta__body"><?php echo wp_kses_post( $cc_body ); ?></p>
		<?php endif; ?>
		<div class="cta__actions">
			<?php
			Partials::button(
				array(
					'label'   => $cc_primary_label,
					'url'     => $cc_primary_url,
					'variant' => 'primary',
					'size'    => 'lg',
				)
			);
			Partials::button(
				array(
					'label'   => $cc_secondary_label,
					'url'     => $cc_secondary_url,
					'variant' => 'secondary',
					'size'    => 'lg',
				)
			);
			?>
		</div>
	</div>
</section>
