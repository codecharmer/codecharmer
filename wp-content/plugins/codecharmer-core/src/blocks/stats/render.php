<?php
/**
 * Stats render: the numeric proof strip.
 *
 * Renders nothing when no child stat carries a value, so the block can sit in
 * seeded markup ahead of verified numbers without shipping an empty band.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;

$cc_heading = (string) ( $attributes['heading'] ?? '' );
$cc_tone    = 'ink' === ( $attributes['tone'] ?? 'light' ) ? 'ink' : 'light';
$cc_stats   = Partials::inner_attrs(
	$block,
	'codecharmer/stat',
	array(
		'value' => '',
		'label' => '',
		'note'  => '',
	)
);

$cc_stats = array_values(
	array_filter(
		$cc_stats,
		static fn( array $cc_stat ): bool => '' !== trim( (string) $cc_stat['value'] )
	)
);
if ( ! $cc_stats ) {
	return;
}
?>
<section class="section stats<?php echo 'ink' === $cc_tone ? ' band-ink' : ''; ?>">
	<div class="container">
		<?php if ( '' !== $cc_heading ) : ?>
			<h2 class="stats__heading reveal"><?php echo esc_html( $cc_heading ); ?></h2>
		<?php endif; ?>
		<ul role="list" class="stats__grid">
			<?php foreach ( $cc_stats as $cc_i => $cc_stat ) : ?>
				<li class="stat reveal" style="--reveal-delay:<?php echo esc_attr( (string) ( $cc_i * 80 ) ); ?>ms">
					<p class="stat__value"><?php echo esc_html( (string) $cc_stat['value'] ); ?></p>
					<p class="stat__label"><?php echo esc_html( (string) $cc_stat['label'] ); ?></p>
					<?php if ( '' !== (string) $cc_stat['note'] ) : ?>
						<p class="stat__note"><?php echo esc_html( (string) $cc_stat['note'] ); ?></p>
					<?php endif; ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
