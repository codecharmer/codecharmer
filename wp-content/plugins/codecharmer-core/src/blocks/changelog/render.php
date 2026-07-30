<?php
/**
 * Changelog render — versioned entries on the coordinate register.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;

$cc_eyebrow = (string) ( $attributes['eyebrow'] ?? '' );
$cc_heading = (string) ( $attributes['heading'] ?? '' );
$cc_intro   = (string) ( $attributes['intro'] ?? '' );

$cc_entries = Partials::inner_attrs(
	$block,
	'codecharmer/changelog-entry',
	array(
		'version' => '',
		'date'    => '',
		'title'   => '',
		'summary' => '',
		'items'   => '',
	)
);
if ( ! $cc_entries ) {
	return;
}
?>
<section class="section changelog">
	<div class="container">
		<header class="changelog__head reveal">
			<?php if ( '' !== $cc_eyebrow ) : ?>
				<p class="eyebrow"><?php echo esc_html( $cc_eyebrow ); ?></p>
			<?php endif; ?>
			<h2 class="changelog__title"><?php echo esc_html( $cc_heading ); ?></h2>
			<?php if ( '' !== $cc_intro ) : ?>
				<p class="lead changelog__intro"><?php echo esc_html( $cc_intro ); ?></p>
			<?php endif; ?>
		</header>

		<ol role="list" class="changelog__list">
			<?php foreach ( $cc_entries as $cc_entry ) : ?>
				<?php
				$cc_items = array_filter( array_map( 'trim', explode( "\n", (string) $cc_entry['items'] ) ) );
				?>
				<li class="clentry reveal">
					<div class="clentry__meta">
						<p class="clentry__coord" aria-hidden="true">
							<span class="clentry__tick"></span>
							<span class="clentry__version"><?php echo esc_html( (string) $cc_entry['version'] ); ?></span>
							<span class="clentry__measure"></span>
						</p>
						<p class="clentry__date"><?php echo esc_html( (string) $cc_entry['date'] ); ?></p>
					</div>
					<div class="clentry__body">
						<h3 class="clentry__name">
							<span class="visually-hidden"><?php echo esc_html( (string) $cc_entry['version'] ); ?> — </span>
							<?php echo esc_html( (string) $cc_entry['title'] ); ?>
						</h3>
						<?php if ( '' !== (string) $cc_entry['summary'] ) : ?>
							<p class="clentry__summary"><?php echo esc_html( (string) $cc_entry['summary'] ); ?></p>
						<?php endif; ?>
						<?php if ( $cc_items ) : ?>
							<ul role="list" class="clentry__items">
								<?php foreach ( $cc_items as $cc_item ) : ?>
									<li>
										<span class="clentry__mark" aria-hidden="true"></span>
										<?php echo esc_html( $cc_item ); ?>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				</li>
			<?php endforeach; ?>
		</ol>
	</div>
</section>
