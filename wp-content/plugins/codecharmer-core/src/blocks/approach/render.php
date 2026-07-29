<?php
/**
 * Approach render — the compact instrumented rail on the ink band.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;

$cc_eyebrow = (string) ( $attributes['eyebrow'] ?? '' );
$cc_heading = (string) ( $attributes['heading'] ?? '' );
$cc_intro   = (string) ( $attributes['intro'] ?? '' );

$cc_steps = Partials::inner_attrs(
	$block,
	'codecharmer/approach-step',
	array(
		'title'  => '',
		'body'   => '',
		'weight' => 1,
	)
);
if ( ! $cc_steps ) {
	return;
}
$cc_spans = Partials::rail_spans( array_map( static fn( array $s ): float => (float) $s['weight'], $cc_steps ) );
?>
<section class="section approach band-ink">
	<div class="approach__ambient" aria-hidden="true"></div>
	<div class="container approach__inner">
		<header class="approach__head reveal">
			<?php if ( '' !== $cc_eyebrow ) : ?>
				<p class="eyebrow"><?php echo esc_html( $cc_eyebrow ); ?></p>
			<?php endif; ?>
			<h2 class="approach__title"><?php echo esc_html( $cc_heading ); ?></h2>
			<?php if ( '' !== $cc_intro ) : ?>
				<p class="lead approach__intro"><?php echo esc_html( $cc_intro ); ?></p>
			<?php endif; ?>
		</header>

		<div class="approach__rail rail reveal" data-scrub="band">
			<div class="approach__ruler rail__ruler" aria-hidden="true"></div>

			<div class="approach__track rail__track" aria-hidden="true">
				<?php foreach ( $cc_steps as $cc_i => $cc_step ) : ?>
					<div class="rail__segment" style="--w:<?php echo esc_attr( (string) $cc_step['weight'] ); ?>" data-from="<?php echo esc_attr( (string) $cc_spans[ $cc_i ][0] ); ?>" data-to="<?php echo esc_attr( (string) $cc_spans[ $cc_i ][1] ); ?>">
						<i class="rail__run"></i>
						<span class="rail__node rail__node--astride" data-from="<?php echo esc_attr( (string) $cc_spans[ $cc_i ][0] ); ?>" data-to="<?php echo esc_attr( (string) $cc_spans[ $cc_i ][1] ); ?>"></span>
					</div>
				<?php endforeach; ?>
				<span class="rail__playhead"></span>
			</div>

			<ol role="list" class="approach__steps">
				<?php foreach ( $cc_steps as $cc_i => $cc_step ) : ?>
					<li class="approach__step" style="--w:<?php echo esc_attr( (string) $cc_step['weight'] ); ?>" data-from="<?php echo esc_attr( (string) $cc_spans[ $cc_i ][0] ); ?>" data-to="<?php echo esc_attr( (string) $cc_spans[ $cc_i ][1] ); ?>">
						<span class="approach__meta">
							<span class="rail__coord"><?php echo esc_html( str_pad( (string) ( $cc_i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
							<span class="rail__status" aria-hidden="true"></span>
						</span>
						<h3 class="approach__step-title"><?php echo esc_html( (string) $cc_step['title'] ); ?></h3>
						<p class="approach__step-body"><?php echo esc_html( (string) $cc_step['body'] ); ?></p>
					</li>
				<?php endforeach; ?>
			</ol>
		</div>
	</div>
</section>
