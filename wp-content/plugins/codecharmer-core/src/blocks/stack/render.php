<?php
/**
 * Tech stack render — grouped mono chips.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;

$cc_eyebrow = (string) ( $attributes['eyebrow'] ?? '' );
$cc_heading = (string) ( $attributes['heading'] ?? '' );
$cc_intro   = (string) ( $attributes['intro'] ?? '' );

$cc_groups = Partials::inner_attrs(
	$block,
	'codecharmer/stack-group',
	array(
		'label' => '',
		'items' => '',
	)
);
if ( ! $cc_groups ) {
	return;
}
?>
<section class="section stack">
	<div class="container">
		<header class="stack__head reveal">
			<?php if ( '' !== $cc_eyebrow ) : ?>
				<p class="eyebrow"><?php echo esc_html( $cc_eyebrow ); ?></p>
			<?php endif; ?>
			<h2 class="stack__title"><?php echo esc_html( $cc_heading ); ?></h2>
			<?php if ( '' !== $cc_intro ) : ?>
				<p class="lead stack__intro"><?php echo esc_html( $cc_intro ); ?></p>
			<?php endif; ?>
		</header>

		<dl class="stack__groups reveal">
			<?php foreach ( $cc_groups as $cc_group ) : ?>
				<?php
				$cc_items = array_filter( array_map( 'trim', explode( "\n", (string) $cc_group['items'] ) ) );
				if ( ! $cc_items ) {
					continue;
				}
				?>
				<div class="stack__group">
					<dt class="stack__label"><?php echo esc_html( (string) $cc_group['label'] ); ?></dt>
					<dd class="stack__chips">
						<?php foreach ( $cc_items as $cc_item ) : ?>
							<span class="stack__chip"><?php echo esc_html( $cc_item ); ?></span>
						<?php endforeach; ?>
					</dd>
				</div>
			<?php endforeach; ?>
		</dl>
	</div>
</section>
