<?php
/**
 * Landing footer render: the essential exits only.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Setup\Options;

$cc_email = Options::get( 'email' );
$cc_year  = gmdate( 'Y' );
?>
<div class="landing-footer">
	<div class="container landing-footer__inner">
		<p class="landing-footer__legal">
			<?php
			printf(
				/* translators: 1: year, 2: site name */
				esc_html__( '© %1$s %2$s', 'codecharmer-core' ),
				esc_html( $cc_year ),
				esc_html( get_bloginfo( 'name' ) )
			);
			?>
		</p>
		<p class="landing-footer__links">
			<a class="link" href="<?php echo esc_url( 'mailto:' . $cc_email ); ?>"><?php echo esc_html( $cc_email ); ?></a>
			<a class="link" href="<?php echo esc_url( Options::page_url( 'privacy' ) ); ?>"><?php esc_html_e( 'Privacy', 'codecharmer-core' ); ?></a>
		</p>
	</div>
</div>
