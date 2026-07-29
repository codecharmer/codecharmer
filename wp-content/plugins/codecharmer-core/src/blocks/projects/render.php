<?php
/**
 * Projects render — teaser (with header) or the full grid.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Content\PostTypes;
use CodeCharmer\Core\Render\Partials;

$cc_variant = 'grid' === ( $attributes['variant'] ?? 'teaser' ) ? 'grid' : 'teaser';
$cc_count   = (int) ( $attributes['count'] ?? 3 );
$cc_eyebrow = (string) ( $attributes['eyebrow'] ?? '' );
$cc_heading = (string) ( $attributes['heading'] ?? '' );
$cc_cta     = array(
	'label'   => (string) ( $attributes['ctaLabel'] ?? '' ),
	'url'     => (string) ( $attributes['ctaUrl'] ?? '' ),
	'variant' => 'ghost',
);

$cc_query = new WP_Query(
	array(
		'post_type'              => PostTypes::PROJECT,
		'posts_per_page'         => $cc_count > 0 ? $cc_count : 24,
		'orderby'                => 'menu_order',
		'order'                  => 'ASC',
		'no_found_rows'          => true,
		'update_post_term_cache' => false,
	)
);
if ( ! $cc_query->posts ) {
	return;
}
?>
<section class="section <?php echo 'teaser' === $cc_variant ? 'work' : 'work-grid'; ?>">
	<div class="container">
		<?php if ( 'teaser' === $cc_variant ) : ?>
			<header class="work__head reveal">
				<div>
					<?php if ( '' !== $cc_eyebrow ) : ?>
						<p class="eyebrow"><?php echo esc_html( $cc_eyebrow ); ?></p>
					<?php endif; ?>
					<h2 class="work__title"><?php echo esc_html( $cc_heading ); ?></h2>
				</div>
				<?php Partials::button( $cc_cta ); ?>
			</header>
		<?php endif; ?>

		<ul role="list" class="<?php echo 'teaser' === $cc_variant ? 'work__list' : 'work-grid__list'; ?>">
			<?php foreach ( $cc_query->posts as $cc_i => $cc_project ) : ?>
				<li class="reveal" style="--reveal-delay:<?php echo esc_attr( (string) ( ( $cc_i % 3 ) * 80 ) ); ?>ms">
					<?php Partials::project_card( $cc_project ); ?>
				</li>
			<?php endforeach; ?>
		</ul>
	</div>
</section>
