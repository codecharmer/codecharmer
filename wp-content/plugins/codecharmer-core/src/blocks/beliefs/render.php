<?php
/**
 * Beliefs render — also serves the process page's "principles" variant.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;

$cc_heading = (string) ( $attributes['heading'] ?? '' );
$cc_intro   = (string) ( $attributes['intro'] ?? '' );
$cc_columns = max( 2, min( 4, (int) ( $attributes['columns'] ?? 4 ) ) );
$cc_items   = Partials::inner_attrs(
	$block,
	'codecharmer/belief-item',
	array(
		'title' => '',
		'body'  => '',
	)
);
?>
<section class="section beliefs band-ink beliefs--cols-<?php echo esc_attr( (string) $cc_columns ); ?>">
	<div class="beliefs__ambient" aria-hidden="true"></div>
	<div class="container beliefs__inner">
		<div class="beliefs__head reveal">
			<h2 class="beliefs__title"><?php echo esc_html( $cc_heading ); ?></h2>
			<?php if ( '' !== $cc_intro ) : ?>
				<p class="lead beliefs__intro"><?php echo esc_html( $cc_intro ); ?></p>
			<?php endif; ?>
		</div>

		<ul role="list" class="beliefs__grid">
			<?php foreach ( $cc_items as $cc_i => $cc_item ) : ?>
				<li class="belief reveal" style="--reveal-delay:<?php echo esc_attr( (string) ( $cc_i * 80 ) ); ?>ms">
					<span class="belief__mark" aria-hidden="true"><?php Partials::icon( 'spark', 18 ); ?></span>
					<h3 class="belief__title"><?php echo esc_html( (string) $cc_item['title'] ); ?></h3>
					<p class="belief__body"><?php echo esc_html( (string) $cc_item['body'] ); ?></p>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
