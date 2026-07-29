<?php
/**
 * Partners render.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

$cc_groups = array(
	array(
		'label' => (string) ( $attributes['partnersLabel'] ?? '' ),
		'items' => (array) ( $attributes['partners'] ?? array() ),
	),
	array(
		'label' => (string) ( $attributes['collaboratorsLabel'] ?? '' ),
		'items' => (array) ( $attributes['collaborators'] ?? array() ),
	),
);
?>
<section class="section partners">
	<div class="container">
		<?php foreach ( $cc_groups as $cc_group ) : ?>
			<?php if ( $cc_group['items'] ) : ?>
				<div class="partners__group reveal">
					<p class="partners__label eyebrow"><?php echo esc_html( $cc_group['label'] ); ?></p>
					<ul role="list" class="partners__cloud">
						<?php foreach ( $cc_group['items'] as $cc_name ) : ?>
							<li class="partners__name"><?php echo esc_html( (string) $cc_name ); ?></li>
						<?php endforeach; ?>
					</ul>
				</div>
			<?php endif; ?>
		<?php endforeach; ?>
	</div>
</section>
