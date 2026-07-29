<?php
/**
 * Feature list render.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;

$cc_eyebrow = (string) ( $attributes['eyebrow'] ?? '' );
$cc_heading = (string) ( $attributes['heading'] ?? '' );
$cc_intro   = (string) ( $attributes['intro'] ?? '' );
$cc_items   = Partials::inner_attrs( $block, 'codecharmer/feature-item', array( 'text' => '' ) );
if ( ! $cc_items ) {
	return;
}
?>
<section class="section featurelist">
	<div class="container">
		<header class="featurelist__head reveal">
			<?php if ( '' !== $cc_eyebrow ) : ?>
				<p class="eyebrow"><?php echo esc_html( $cc_eyebrow ); ?></p>
			<?php endif; ?>
			<h2 class="featurelist__title"><?php echo esc_html( $cc_heading ); ?></h2>
			<?php if ( '' !== $cc_intro ) : ?>
				<p class="lead featurelist__intro"><?php echo esc_html( $cc_intro ); ?></p>
			<?php endif; ?>
		</header>

		<ul role="list" class="featurelist__grid reveal">
			<?php foreach ( $cc_items as $cc_item ) : ?>
				<li class="featurelist__item">
					<span class="featurelist__mark" aria-hidden="true"><?php Partials::icon( 'check', 16 ); ?></span>
					<?php echo esc_html( (string) $cc_item['text'] ); ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
