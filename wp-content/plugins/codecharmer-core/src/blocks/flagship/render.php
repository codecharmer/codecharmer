<?php
/**
 * Flagship product band render.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;

$cc_eyebrow     = (string) ( $attributes['eyebrow'] ?? '' );
$cc_name        = (string) ( $attributes['name'] ?? '' );
$cc_tagline     = (string) ( $attributes['tagline'] ?? '' );
$cc_description = (string) ( $attributes['description'] ?? '' );
$cc_stack_line  = (string) ( $attributes['stackLine'] ?? '' );

$cc_highlights = Partials::inner_attrs( $block, 'codecharmer/feature-item', array( 'text' => '' ) );
?>
<section class="section flagship band-ink">
	<div class="flagship__ambient" aria-hidden="true"></div>
	<div class="container flagship__inner">
		<div class="flagship__copy reveal">
			<?php if ( '' !== $cc_eyebrow ) : ?>
				<p class="flagship__eyebrow eyebrow"><?php echo esc_html( $cc_eyebrow ); ?></p>
			<?php endif; ?>
			<h2 class="flagship__name">
				<?php echo esc_html( $cc_name ); ?>
				<?php
				if ( '' !== $cc_tagline ) :
					?>
					<span class="flagship__tagline"> <?php echo esc_html( $cc_tagline ); ?></span><?php endif; ?>
			</h2>
			<?php if ( '' !== $cc_description ) : ?>
				<p class="flagship__desc lead"><?php echo wp_kses_post( $cc_description ); ?></p>
			<?php endif; ?>

			<?php if ( $cc_highlights ) : ?>
				<ul role="list" class="flagship__points">
					<?php foreach ( $cc_highlights as $cc_point ) : ?>
						<li>
							<span class="flagship__mark" aria-hidden="true"><?php Partials::icon( 'check', 15 ); ?></span>
							<?php echo esc_html( (string) $cc_point['text'] ); ?>
						</li>
					<?php endforeach; ?>
				</ul>
			<?php endif; ?>

			<div class="flagship__actions">
				<?php
				Partials::button(
					array(
						'label'   => (string) ( $attributes['primaryLabel'] ?? '' ),
						'url'     => (string) ( $attributes['primaryUrl'] ?? '' ),
						'variant' => 'primary',
						'size'    => 'lg',
						'icon'    => 'external',
					)
				);
				Partials::button(
					array(
						'label'   => (string) ( $attributes['secondaryLabel'] ?? '' ),
						'url'     => (string) ( $attributes['secondaryUrl'] ?? '' ),
						'variant' => 'secondary',
						'size'    => 'lg',
						'icon'    => 'arrow',
					)
				);
				?>
			</div>

			<?php if ( '' !== $cc_stack_line ) : ?>
				<p class="flagship__stack"><?php echo esc_html( $cc_stack_line ); ?></p>
			<?php endif; ?>
		</div>

		<div class="flagship__visual reveal" style="--reveal-delay:120ms">
			<?php Partials::praxis_board(); ?>
		</div>
	</div>
</section>
