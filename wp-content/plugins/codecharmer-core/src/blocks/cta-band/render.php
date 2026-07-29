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
					'label'   => Options::get( 'cta_label' ),
					'url'     => Options::page_url( 'contact' ),
					'variant' => 'primary',
					'size'    => 'lg',
				)
			);
			Partials::button(
				array(
					'label'   => __( 'Email us', 'codecharmer-core' ),
					'url'     => 'mailto:' . $cc_email,
					'variant' => 'secondary',
					'size'    => 'lg',
				)
			);
			?>
		</div>
	</div>
</section>
