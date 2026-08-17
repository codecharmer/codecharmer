<?php
/**
 * Page hero render.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;

$cc_tone    = 'ink' === ( $attributes['tone'] ?? 'light' ) ? 'ink' : 'light';
$cc_eyebrow = (string) ( $attributes['eyebrow'] ?? '' );
$cc_title   = (string) ( $attributes['title'] ?? '' );
$cc_intro   = (string) ( $attributes['intro'] ?? '' );
$cc_note    = (string) ( $attributes['note'] ?? '' );

$cc_primary_label   = (string) ( $attributes['primaryLabel'] ?? '' );
$cc_primary_url     = (string) ( $attributes['primaryUrl'] ?? '' );
$cc_secondary_label = (string) ( $attributes['secondaryLabel'] ?? '' );
$cc_secondary_url   = (string) ( $attributes['secondaryUrl'] ?? '' );

$cc_classes = 'page-hero page-hero--' . $cc_tone . ( 'ink' === $cc_tone ? ' band-ink' : '' );
?>
<section class="<?php echo esc_attr( $cc_classes ); ?>">
	<?php if ( 'ink' === $cc_tone ) : ?>
		<div class="page-hero__ambient" aria-hidden="true"></div>
	<?php endif; ?>
	<div class="container page-hero__inner">
		<?php
		// Nested pages show the ancestor trail in the eyebrow slot; the
		// trail's terminal item carries the page name, so orientation
		// survives without stacking two mono lines.
		$cc_hero_post   = get_queried_object();
		$cc_show_crumbs = is_page()
			&& $cc_hero_post instanceof WP_Post
			&& $cc_hero_post->post_parent > 0
			&& get_the_ID() === $cc_hero_post->ID;

		if ( $cc_show_crumbs ) {
			Partials::breadcrumbs( $cc_hero_post );
		} elseif ( '' !== $cc_eyebrow ) {
			?>
			<p class="eyebrow"><?php echo esc_html( $cc_eyebrow ); ?></p>
			<?php
		}
		?>
		<h1 class="page-hero__title"><?php echo esc_html( $cc_title ); ?></h1>
		<?php if ( '' !== $cc_intro ) : ?>
			<p class="page-hero__intro lead"><?php echo wp_kses_post( $cc_intro ); ?></p>
		<?php endif; ?>
		<?php if ( '' !== $cc_primary_label || '' !== $cc_secondary_label ) : ?>
			<div class="page-hero__actions">
				<?php
				Partials::button(
					array(
						'label'   => $cc_primary_label,
						'url'     => $cc_primary_url,
						'variant' => 'primary',
						'size'    => 'lg',
					)
				);
				Partials::button(
					array(
						'label'   => $cc_secondary_label,
						'url'     => $cc_secondary_url,
						'variant' => 'secondary',
						'size'    => 'lg',
						'icon'    => 'arrow',
					)
				);
				?>
			</div>
		<?php endif; ?>
		<?php if ( '' !== $cc_note ) : ?>
			<p class="page-hero__note"><?php echo esc_html( $cc_note ); ?></p>
		<?php endif; ?>
	</div>
</section>
