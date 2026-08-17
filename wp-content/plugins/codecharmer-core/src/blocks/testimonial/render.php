<?php
/**
 * Testimonial render.
 *
 * Renders nothing when the quote is empty, so the block can sit in seeded
 * markup ahead of a permissioned client voice without shipping placeholder
 * copy. Attribution is only as specific as the permission allows.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

$cc_quote  = trim( (string) ( $attributes['quote'] ?? '' ) );
$cc_name   = (string) ( $attributes['name'] ?? '' );
$cc_role   = (string) ( $attributes['role'] ?? '' );
$cc_co     = (string) ( $attributes['company'] ?? '' );
$cc_source = (string) ( $attributes['sourceUrl'] ?? '' );

if ( '' === $cc_quote ) {
	return;
}

$cc_attribution = implode( ' · ', array_filter( array( $cc_role, $cc_co ) ) );
?>
<section class="section testimonial">
	<div class="container">
		<figure class="testimonial__figure reveal">
			<blockquote class="testimonial__quote">
				<p><?php echo esc_html( $cc_quote ); ?></p>
			</blockquote>
			<?php if ( '' !== $cc_name ) : ?>
				<figcaption class="testimonial__cite">
					<span class="testimonial__name"><?php echo esc_html( $cc_name ); ?></span>
					<?php if ( '' !== $cc_attribution ) : ?>
						<span class="testimonial__meta"><?php echo esc_html( $cc_attribution ); ?></span>
					<?php endif; ?>
					<?php if ( '' !== $cc_source ) : ?>
						<a class="link testimonial__source" href="<?php echo esc_url( $cc_source ); ?>" rel="noopener noreferrer"><?php esc_html_e( 'Source', 'codecharmer-core' ); ?></a>
					<?php endif; ?>
				</figcaption>
			<?php endif; ?>
		</figure>
	</div>
</section>
