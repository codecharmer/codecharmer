<?php
/**
 * Site footer render.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;
use CodeCharmer\Core\Setup\Options;

$cc_services  = Options::service_pages();
$cc_email     = Options::get( 'email' );
$cc_tagline   = Options::get( 'tagline' );
$cc_cta_label = Options::get( 'cta_label' );
$cc_cta_url   = Options::page_url( 'contact' );
$cc_year      = gmdate( 'Y' );
?>
<div class="site-footer band-ink">
	<div class="container">
		<div class="footer__top">
			<div class="footer__brand">
				<?php Partials::logo( '' ); ?>
				<p class="footer__tagline"><?php echo esc_html( $cc_tagline ); ?></p>
				<a class="footer__email link" href="<?php echo esc_url( 'mailto:' . $cc_email ); ?>"><?php echo esc_html( $cc_email ); ?></a>
			</div>

			<nav class="footer__cols" aria-label="<?php esc_attr_e( 'Footer', 'codecharmer-core' ); ?>">
				<div class="footer__col">
					<h2 class="footer__heading"><?php esc_html_e( 'Services', 'codecharmer-core' ); ?></h2>
					<ul role="list">
						<?php foreach ( $cc_services as $cc_service ) : ?>
							<li><a href="<?php echo esc_url( $cc_service['url'] ); ?>"><?php echo esc_html( $cc_service['title'] ); ?></a></li>
						<?php endforeach; ?>
					</ul>
				</div>
				<div class="footer__col">
					<h2 class="footer__heading"><?php esc_html_e( 'Company', 'codecharmer-core' ); ?></h2>
					<ul role="list">
						<li><a href="<?php echo esc_url( Options::page_url( 'work' ) ); ?>"><?php esc_html_e( 'Work', 'codecharmer-core' ); ?></a></li>
						<li><a href="<?php echo esc_url( Options::page_url( 'process' ) ); ?>"><?php esc_html_e( 'Process', 'codecharmer-core' ); ?></a></li>
						<li><a href="<?php echo esc_url( Options::page_url( 'about' ) ); ?>"><?php esc_html_e( 'About', 'codecharmer-core' ); ?></a></li>
					</ul>
				</div>
				<div class="footer__col">
					<h2 class="footer__heading"><?php esc_html_e( 'Get started', 'codecharmer-core' ); ?></h2>
					<ul role="list">
						<li><a href="<?php echo esc_url( $cc_cta_url ); ?>"><?php echo esc_html( $cc_cta_label ); ?></a></li>
						<li><a href="<?php echo esc_url( 'mailto:' . $cc_email ); ?>"><?php esc_html_e( 'Email us', 'codecharmer-core' ); ?></a></li>
					</ul>
					<a class="footer__cta" href="<?php echo esc_url( $cc_cta_url ); ?>">
						<?php esc_html_e( 'Start a project', 'codecharmer-core' ); ?> <?php Partials::icon( 'arrow', 16 ); ?>
					</a>
				</div>
			</nav>
		</div>

		<div class="footer__bottom">
			<p>
				<?php
				printf(
					/* translators: 1: year, 2: site name */
					esc_html__( '© %1$s %2$s. Digital systems that earn their keep.', 'codecharmer-core' ),
					esc_html( $cc_year ),
					esc_html( get_bloginfo( 'name' ) )
				);
				?>
			</p>
			<a href="<?php echo esc_url( Options::page_url( 'privacy' ) ); ?>"><?php esc_html_e( 'Privacy', 'codecharmer-core' ); ?></a>
		</div>
	</div>
</div>
