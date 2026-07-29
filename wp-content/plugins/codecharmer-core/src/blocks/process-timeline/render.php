<?php
/**
 * Process timeline render — the vertical instrumented rail.
 *
 * Stage markers carry data-auto: on tall timelines a stage's extent follows
 * how much copy it has, so the driver measures spans off the layout instead
 * of the authored weights.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;

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
?>
<section class="section timeline-sec">
	<div class="container">
		<ol role="list" class="timeline rail" data-scrub="through">
			<?php foreach ( $cc_stages as $cc_i => $cc_stage ) : ?>
				<li class="tstage reveal">
					<div class="tstage__rail" aria-hidden="true">
						<span class="tstage__seg" data-auto></span>
						<span class="tstage__node rail__node" data-auto></span>
						<span class="rail__ruler rail__ruler--v tstage__ruler"></span>
					</div>
					<div class="tstage__content">
						<p class="tstage__coord rail__coord"><?php echo esc_html( str_pad( (string) ( $cc_i + 1 ), 2, '0', STR_PAD_LEFT ) ); ?></p>
						<h2 class="tstage__name"><?php echo esc_html( (string) $cc_stage['name'] ); ?></h2>
						<p class="tstage__body"><?php echo esc_html( (string) $cc_stage['body'] ); ?></p>
						<?php if ( '' !== (string) $cc_stage['deliverable'] ) : ?>
							<p class="tstage__deliverable">
								<span class="tstage__deliverable-label"><?php esc_html_e( 'You get', 'codecharmer-core' ); ?></span>
								<?php echo esc_html( (string) $cc_stage['deliverable'] ); ?>
							</p>
						<?php endif; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
