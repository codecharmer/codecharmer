<?php
/**
 * Process teaser render — the instrumented rail with build-run states.
 *
 * Segment width = stage weight (a design-authored proportion, never data).
 * Stage spans are emitted as data-from/data-to fractions; the theme's rail
 * driver compares scroll progress against them to set node/readout state.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;

$cc_tone    = 'ink' === ( $attributes['tone'] ?? 'light' ) ? 'ink' : 'light';
$cc_eyebrow = (string) ( $attributes['eyebrow'] ?? '' );
$cc_heading = (string) ( $attributes['heading'] ?? '' );
$cc_intro   = (string) ( $attributes['intro'] ?? '' );
$cc_cta     = array(
	'label'   => (string) ( $attributes['ctaLabel'] ?? '' ),
	'url'     => (string) ( $attributes['ctaUrl'] ?? '' ),
	'variant' => 'ghost',
);

$cc_stages = Partials::inner_attrs(
	$block,
	'codecharmer/process-stage',
	array(
		'name'        => '',
		'body'        => '',
		'deliverable' => '',
		'weight'      => 1,
	)
);
if ( ! $cc_stages ) {
	return;
}

$cc_spans = Partials::rail_spans( array_map( static fn( array $s ): float => (float) $s['weight'], $cc_stages ) );
?>
<section class="section process-teaser<?php echo 'ink' === $cc_tone ? ' band-ink' : ''; ?>">
	<div class="container">
		<header class="pt__head reveal">
			<div>
				<?php if ( '' !== $cc_eyebrow ) : ?>
					<p class="eyebrow"><?php echo esc_html( $cc_eyebrow ); ?></p>
				<?php endif; ?>
				<h2 class="pt__title"><?php echo esc_html( $cc_heading ); ?></h2>
			</div>
			<?php if ( '' !== $cc_intro ) : ?>
				<p class="lead pt__intro"><?php echo esc_html( $cc_intro ); ?></p>
			<?php endif; ?>
		</header>

		<div class="pt__rail rail reveal" data-scrub="band">
			<div class="pt__ruler rail__ruler" aria-hidden="true"></div>

			<div class="pt__track rail__track" aria-hidden="true">
				<?php foreach ( $cc_stages as $cc_i => $cc_stage ) : ?>
					<div class="rail__segment" style="--w:<?php echo esc_attr( (string) $cc_stage['weight'] ); ?>" data-from="<?php echo esc_attr( (string) $cc_spans[ $cc_i ][0] ); ?>" data-to="<?php echo esc_attr( (string) $cc_spans[ $cc_i ][1] ); ?>">
						<i class="rail__run"></i>
						<span class="rail__node rail__node--astride" data-from="<?php echo esc_attr( (string) $cc_spans[ $cc_i ][0] ); ?>" data-to="<?php echo esc_attr( (string) $cc_spans[ $cc_i ][1] ); ?>"></span>
					</div>
				<?php endforeach; ?>
				<span class="rail__playhead"></span>
			</div>

			<ol role="list" class="pt__stages">
				<?php foreach ( $cc_stages as $cc_i => $cc_stage ) : ?>
					<li class="pt__stage" style="--w:<?php echo esc_attr( (string) $cc_stage['weight'] ); ?>" data-from="<?php echo esc_attr( (string) $cc_spans[ $cc_i ][0] ); ?>" data-to="<?php echo esc_attr( (string) $cc_spans[ $cc_i ][1] ); ?>">
						<span class="rail__coord"><?php echo esc_html( str_pad( (string) ( $cc_i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></span>
						<span class="rail__label pt__name"><?php echo esc_html( (string) $cc_stage['name'] ); ?></span>
						<span class="rail__status pt__stage-status" aria-hidden="true"></span>
					</li>
				<?php endforeach; ?>
			</ol>

			<ul role="list" class="pt__readout">
				<?php foreach ( $cc_stages as $cc_i => $cc_stage ) : ?>
					<li class="pt__out" data-from="<?php echo esc_attr( (string) $cc_spans[ $cc_i ][0] ); ?>" data-to="<?php echo esc_attr( (string) $cc_spans[ $cc_i ][1] ); ?>">
						<span class="pt__out-label"><?php echo esc_html( str_pad( (string) ( $cc_i + 1 ), 2, '0', STR_PAD_LEFT ) . ' ' . (string) $cc_stage['name'] ); ?></span>
						<span class="pt__out-text" data-type><?php echo esc_html( (string) $cc_stage['deliverable'] ); ?></span>
					</li>
				<?php endforeach; ?>
			</ul>
		</div>

		<?php if ( '' !== $cc_cta['label'] && '' !== $cc_cta['url'] ) : ?>
			<div class="pt__cta reveal">
				<?php Partials::button( $cc_cta ); ?>
			</div>
		<?php endif; ?>
	</div>
</section>
