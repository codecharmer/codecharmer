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
$cc_models  = Partials::inner_attrs(
	$block,
	'codecharmer/engagement-model',
	array(
		'bestFor' => '',
		'name'    => '',
		'body'    => '',
	)
);
if ( ! $cc_models ) {
	return;
}
?>
<section class="section engage">
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
					<p class="engage__body"><?php echo esc_html( (string) $cc_model['body'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
