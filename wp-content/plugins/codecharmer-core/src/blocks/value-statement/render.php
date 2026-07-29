<?php
/**
 * Value statement render.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;

$cc_lead   = (string) ( $attributes['lead'] ?? '' );
$cc_points = Partials::inner_attrs(
	$block,
	'codecharmer/value-point',
	array(
		'title' => '',
		'body'  => '',
	)
);

// The emphasized phrase uses <em>; keep it and nothing else.
$cc_lead_kses = array( 'em' => array() );
?>
<section class="section value">
	<div class="container">
		<div class="value__statement reveal">
			<p class="value__lead"><?php echo wp_kses( $cc_lead, $cc_lead_kses ); ?></p>
		</div>

		<?php if ( $cc_points ) : ?>
			<ul role="list" class="value__points">
				<?php foreach ( $cc_points as $cc_i => $cc_point ) : ?>
					<li class="value__point reveal" style="--reveal-delay:<?php echo esc_attr( (string) ( $cc_i * 90 ) ); ?>ms">
						<span class="value__marker" aria-hidden="true"></span>
						<h3 class="value__k"><?php echo esc_html( (string) $cc_point['title'] ); ?></h3>
						<p class="value__v"><?php echo esc_html( (string) $cc_point['body'] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
