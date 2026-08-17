<?php
/**
 * Engagement models render.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;

$cc_eyebrow = (string) ( $attributes['eyebrow'] ?? '' );
$cc_heading = (string) ( $attributes['heading'] ?? '' );
$cc_intro   = (string) ( $attributes['intro'] ?? '' );
$cc_variant = 'pricing' === ( $attributes['variant'] ?? '' ) ? 'pricing' : '';
$cc_models  = Partials::inner_attrs(
	$block,
	'codecharmer/engagement-model',
	array(
		'bestFor'   => '',
		'name'      => '',
		'body'      => '',
		'price'     => '',
		'timeframe' => '',
		'detail'    => '',
	)
);
if ( ! $cc_models ) {
	return;
}
?>
<section class="section engage<?php echo 'pricing' === $cc_variant ? ' engage--pricing' : ''; ?>">
	<div class="container">
		<header class="engage__head reveal">
			<?php if ( '' !== $cc_eyebrow ) : ?>
				<p class="eyebrow"><?php echo esc_html( $cc_eyebrow ); ?></p>
			<?php endif; ?>
			<h2 class="engage__title"><?php echo esc_html( $cc_heading ); ?></h2>
			<?php if ( '' !== $cc_intro ) : ?>
				<p class="lead engage__intro"><?php echo esc_html( $cc_intro ); ?></p>
			<?php endif; ?>
		</header>

		<ul role="list" class="engage__grid">
			<?php foreach ( $cc_models as $cc_i => $cc_model ) : ?>
				<li class="engage__card reveal" style="--reveal-delay:<?php echo esc_attr( (string) ( $cc_i * 80 ) ); ?>ms">
					<p class="engage__best"><?php echo esc_html( (string) $cc_model['bestFor'] ); ?></p>
					<h3 class="engage__name"><?php echo esc_html( (string) $cc_model['name'] ); ?></h3>
					<?php if ( '' !== (string) $cc_model['price'] ) : ?>
						<p class="engage__price"><?php echo esc_html( (string) $cc_model['price'] ); ?></p>
					<?php endif; ?>
					<?php if ( '' !== (string) $cc_model['timeframe'] ) : ?>
						<p class="engage__time"><?php echo esc_html( (string) $cc_model['timeframe'] ); ?></p>
					<?php endif; ?>
					<p class="engage__body"><?php echo esc_html( (string) $cc_model['body'] ); ?></p>
					<?php if ( '' !== (string) $cc_model['detail'] ) : ?>
						<p class="engage__detail"><?php echo esc_html( (string) $cc_model['detail'] ); ?></p>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
