<?php
/**
 * Proof strip render.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;

$cc_eyebrow = (string) ( $attributes['eyebrow'] ?? '' );
$cc_heading = (string) ( $attributes['heading'] ?? '' );
$cc_intro   = (string) ( $attributes['intro'] ?? '' );
?>
<section class="section proof">
	<div class="container proof__inner reveal">
		<div>
			<?php if ( '' !== $cc_eyebrow ) : ?>
				<p class="eyebrow"><?php echo esc_html( $cc_eyebrow ); ?></p>
			<?php endif; ?>
			<h2 class="proof__title"><?php echo esc_html( $cc_heading ); ?></h2>
			<?php if ( '' !== $cc_intro ) : ?>
				<p class="lead proof__intro"><?php echo esc_html( $cc_intro ); ?></p>
			<?php endif; ?>
		</div>
		<?php
		Partials::button(
			array(
				'label'   => (string) ( $attributes['ctaLabel'] ?? '' ),
				'url'     => (string) ( $attributes['ctaUrl'] ?? '' ),
				'variant' => 'secondary',
				'size'    => 'lg',
				'icon'    => 'arrow',
			)
		);
		?>
	</div>
</section>
