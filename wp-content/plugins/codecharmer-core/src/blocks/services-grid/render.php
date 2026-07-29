<?php
/**
 * Services grid render — driven by the real service pages.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;
use CodeCharmer\Core\Setup\Options;

$cc_eyebrow  = (string) ( $attributes['eyebrow'] ?? '' );
$cc_heading  = (string) ( $attributes['heading'] ?? '' );
$cc_intro    = (string) ( $attributes['intro'] ?? '' );
$cc_services = Options::service_pages();
if ( ! $cc_services ) {
	return;
}
?>
<section class="section pillars">
	<div class="container">
		<header class="pillars__head reveal">
			<?php if ( '' !== $cc_eyebrow ) : ?>
				<p class="eyebrow"><?php echo esc_html( $cc_eyebrow ); ?></p>
			<?php endif; ?>
			<h2 class="pillars__title"><?php echo esc_html( $cc_heading ); ?></h2>
			<?php if ( '' !== $cc_intro ) : ?>
				<p class="lead pillars__intro"><?php echo esc_html( $cc_intro ); ?></p>
			<?php endif; ?>
		</header>

		<ul role="list" class="pillars__list">
			<?php foreach ( $cc_services as $cc_i => $cc_service ) : ?>
				<li class="reveal" style="--reveal-delay:<?php echo esc_attr( (string) ( $cc_i * 70 ) ); ?>ms">
					<a class="pillar" href="<?php echo esc_url( $cc_service['url'] ); ?>">
						<span class="pillar__icon"><?php Partials::icon( $cc_service['icon'], 26 ); ?></span>
						<span class="pillar__body">
							<span class="pillar__name"><?php echo esc_html( $cc_service['title'] ); ?></span>
							<span class="pillar__desc"><?php echo esc_html( $cc_service['descriptor'] ); ?></span>
						</span>
						<span class="pillar__go" aria-hidden="true"><?php Partials::icon( 'arrow', 20 ); ?></span>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
