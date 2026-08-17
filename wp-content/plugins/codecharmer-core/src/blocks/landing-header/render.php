<?php
/**
 * Landing header render: logo and trust line, deliberately no navigation.
 *
 * Campaign pages keep the visitor on the offer; the logo is the only exit
 * upward, per the playbook's conversion spec.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;

$cc_trust = (string) ( $attributes['trustLine'] ?? '' );
?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'codecharmer-core' ); ?></a>
<div class="landing-header">
	<div class="container landing-header__bar">
		<?php Partials::logo( home_url( '/' ) ); ?>
		<?php if ( '' !== $cc_trust ) : ?>
			<p class="landing-header__trust"><?php echo esc_html( $cc_trust ); ?></p>
		<?php endif; ?>
	</div>
</div>
