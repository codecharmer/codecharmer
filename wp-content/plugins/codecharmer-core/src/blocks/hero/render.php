<?php
/**
 * Hero render — parity with the original Astro Hero + SystemDiagram.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;

$cc_kicker    = (string) ( $attributes['kicker'] ?? '' );
$cc_before    = (string) ( $attributes['titleBefore'] ?? '' );
$cc_charm     = (string) ( $attributes['charm'] ?? '' );
$cc_sub       = (string) ( $attributes['sub'] ?? '' );
$cc_trust     = (string) ( $attributes['trust'] ?? '' );
$cc_primary   = array(
	'label'   => (string) ( $attributes['primaryLabel'] ?? '' ),
	'url'     => (string) ( $attributes['primaryUrl'] ?? '' ),
	'variant' => 'primary',
	'size'    => 'lg',
);
$cc_secondary = array(
	'label'   => (string) ( $attributes['secondaryLabel'] ?? '' ),
	'url'     => (string) ( $attributes['secondaryUrl'] ?? '' ),
	'variant' => 'secondary',
	'size'    => 'lg',
	'icon'    => 'arrow',
);
?>
<section class="hero band-ink">
	<div class="hero__ambient" aria-hidden="true"></div>
	<div class="container hero__inner">
		<div class="hero__copy">
			<?php if ( '' !== $cc_kicker ) : ?>
				<p class="hero__kicker eyebrow"><?php echo esc_html( $cc_kicker ); ?></p>
			<?php endif; ?>

			<h1 class="hero__title">
				<?php echo esc_html( $cc_before ); ?>
				<span class="charm">
					<?php echo esc_html( $cc_charm ); ?>
					<svg class="charm__line" viewBox="0 0 240 14" preserveAspectRatio="none" aria-hidden="true">
						<path d="M3 8c40-6 92-7 138-5 30 1 62 3 96 6" pathLength="1"/>
					</svg>
				</span>
			</h1>

			<?php if ( '' !== $cc_sub ) : ?>
				<p class="hero__sub"><?php echo wp_kses_post( $cc_sub ); ?></p>
			<?php endif; ?>

			<div class="hero__actions">
				<?php Partials::button( $cc_primary ); ?>
				<?php Partials::button( $cc_secondary ); ?>
			</div>

			<?php if ( '' !== $cc_trust ) : ?>
				<p class="hero__trust"><?php echo esc_html( $cc_trust ); ?></p>
			<?php endif; ?>
		</div>

		<div class="hero__visual">
			<?php Partials::system_diagram(); ?>
		</div>
	</div>
</section>
