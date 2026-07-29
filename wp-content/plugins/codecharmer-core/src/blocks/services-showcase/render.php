<?php
/**
 * Services showcase render — alternating splits from the service pages.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;
use CodeCharmer\Core\Setup\Options;

$cc_services = Options::service_pages();
if ( ! $cc_services ) {
	return;
}
?>
<section class="section pillar-sections">
	<div class="container">
		<div class="pillar-sections__list">
			<?php foreach ( $cc_services as $cc_i => $cc_service ) : ?>
				<?php
				$cc_caps       = get_post_meta( $cc_service['id'], 'cc_caps', true );
				$cc_caps       = is_array( $cc_caps ) ? array_slice( $cc_caps, 0, 3 ) : array();
				$cc_first_word = explode( ' ', $cc_service['title'] )[0];
				?>
				<article class="psplit reveal"<?php echo 1 === $cc_i % 2 ? ' data-flip' : ''; ?>>
					<div class="psplit__text">
						<p class="psplit__kicker" aria-hidden="true">
							<span class="psplit__tick"></span>
							<span class="rail__coord"><?php echo esc_html( '0' . ( $cc_i + 1 ) ); ?></span>
							<span class="psplit__measure"></span>
						</p>
						<h2 class="psplit__name"><?php echo esc_html( $cc_service['title'] ); ?></h2>
						<p class="psplit__thesis"><?php echo esc_html( $cc_service['thesis'] ); ?></p>
						<a class="psplit__link" href="<?php echo esc_url( $cc_service['url'] ); ?>">
							<?php
							printf(
								/* translators: %s: first word of the service name */
								esc_html__( 'Explore %s', 'codecharmer-core' ),
								esc_html( $cc_first_word )
							);
							?>
							<?php Partials::icon( 'arrow', 18 ); ?>
						</a>
					</div>

					<div class="psplit__panel" aria-hidden="true">
						<div class="psplit__grid"></div>
						<span class="psplit__icon"><?php Partials::icon( $cc_service['icon'], 30 ); ?></span>
						<?php if ( $cc_caps ) : ?>
							<ul role="list" class="psplit__caps">
								<?php foreach ( $cc_caps as $cc_cap ) : ?>
									<li><?php Partials::icon( 'check', 14 ); ?> <?php echo esc_html( (string) $cc_cap ); ?></li>
								<?php endforeach; ?>
							</ul>
						<?php endif; ?>
					</div>
				</article>
			<?php endforeach; ?>
		</div>
	</div>
</section>
