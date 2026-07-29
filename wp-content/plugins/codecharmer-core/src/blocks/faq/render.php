<?php
/**
 * FAQ render.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;

$cc_heading = (string) ( $attributes['heading'] ?? '' );
$cc_items   = Partials::inner_attrs(
	$block,
	'codecharmer/faq-item',
	array(
		'question' => '',
		'answer'   => '',
	)
);
if ( ! $cc_items ) {
	return;
}
?>
<section class="section faq">
	<div class="container faq__inner">
		<h2 class="faq__title reveal"><?php echo esc_html( $cc_heading ); ?></h2>
		<div class="faq__list reveal">
			<?php foreach ( $cc_items as $cc_item ) : ?>
				<details class="faq__item">
					<summary class="faq__q">
						<span><?php echo esc_html( (string) $cc_item['question'] ); ?></span>
						<span class="faq__icon" aria-hidden="true"></span>
					</summary>
					<div class="faq__a"><p><?php echo esc_html( (string) $cc_item['answer'] ); ?></p></div>
				</details>
			<?php endforeach; ?>
		</div>
	</div>
</section>
