<?php
/**
 * Demo access render — the try-it panel with credentials as a console well.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;

$cc_eyebrow  = (string) ( $attributes['eyebrow'] ?? '' );
$cc_heading  = (string) ( $attributes['heading'] ?? '' );
$cc_intro    = (string) ( $attributes['intro'] ?? '' );
$cc_url      = (string) ( $attributes['url'] ?? '' );
$cc_email    = (string) ( $attributes['email'] ?? '' );
$cc_password = (string) ( $attributes['password'] ?? '' );
$cc_note     = (string) ( $attributes['note'] ?? '' );
$cc_host     = preg_replace( '#^https?://#', '', $cc_url );
?>
<section class="section demo">
	<div class="container demo__grid">
		<header class="demo__head reveal">
			<?php if ( '' !== $cc_eyebrow ) : ?>
				<p class="eyebrow"><?php echo esc_html( $cc_eyebrow ); ?></p>
			<?php endif; ?>
			<h2 class="demo__title"><?php echo esc_html( $cc_heading ); ?></h2>
			<?php if ( '' !== $cc_intro ) : ?>
				<p class="lead demo__intro"><?php echo esc_html( $cc_intro ); ?></p>
			<?php endif; ?>
			<?php if ( '' !== $cc_url ) : ?>
				<div class="demo__cta">
					<?php
					Partials::button(
						array(
							'label'   => (string) ( $attributes['ctaLabel'] ?? '' ),
							'url'     => $cc_url,
							'variant' => 'primary',
							'size'    => 'lg',
							'icon'    => 'external',
						)
					);
					?>
				</div>
			<?php endif; ?>
		</header>

		<div class="demo__panel reveal" style="--reveal-delay:100ms">
			<dl class="demo__creds">
				<?php if ( '' !== $cc_url ) : ?>
					<div class="demo__row">
						<dt><?php esc_html_e( 'url', 'codecharmer-core' ); ?></dt>
						<dd><a class="link" href="<?php echo esc_url( $cc_url ); ?>" rel="noopener noreferrer"><?php echo esc_html( (string) $cc_host ); ?></a></dd>
					</div>
				<?php endif; ?>
				<?php if ( '' !== $cc_email ) : ?>
					<div class="demo__row">
						<dt><?php esc_html_e( 'email', 'codecharmer-core' ); ?></dt>
						<dd><?php echo esc_html( $cc_email ); ?></dd>
					</div>
				<?php endif; ?>
				<?php if ( '' !== $cc_password ) : ?>
					<div class="demo__row">
						<dt><?php esc_html_e( 'password', 'codecharmer-core' ); ?></dt>
						<dd><?php echo esc_html( $cc_password ); ?></dd>
					</div>
				<?php endif; ?>
			</dl>
			<?php if ( '' !== $cc_note ) : ?>
				<p class="demo__note"><?php echo esc_html( $cc_note ); ?></p>
			<?php endif; ?>
		</div>
	</div>
</section>
