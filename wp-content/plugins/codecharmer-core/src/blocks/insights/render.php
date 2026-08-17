<?php
/**
 * Insights hub render: published articles as cards.
 *
 * Renders an honest empty state until the first article is published:
 * never placeholder cards, never fake content.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

$cc_count = max( 1, min( 50, (int) ( $attributes['count'] ?? 24 ) ) );

$cc_query = new WP_Query(
	array(
		'post_type'              => 'post',
		'post_status'            => 'publish',
		'posts_per_page'         => $cc_count,
		'ignore_sticky_posts'    => true,
		'no_found_rows'          => true,
		'update_post_term_cache' => false,
	)
);
?>
<section class="section insights">
	<div class="container">
		<?php if ( ! $cc_query->posts ) : ?>
			<div class="insights__empty reveal">
				<p class="insights__empty-title"><?php esc_html_e( 'The first pieces are being written.', 'codecharmer-core' ); ?></p>
				<p class="insights__empty-body"><?php esc_html_e( 'Long-form, first-hand engineering notes from real builds: no thin content, no filler. They will appear here as they are finished.', 'codecharmer-core' ); ?></p>
			</div>
		<?php else : ?>
			<ul role="list" class="insights__grid">
				<?php foreach ( $cc_query->posts as $cc_i => $cc_post ) : ?>
					<?php
					$cc_words   = str_word_count( wp_strip_all_tags( (string) $cc_post->post_content ) );
					$cc_minutes = max( 1, (int) ceil( $cc_words / 220 ) );
					?>
					<li class="reveal" style="--reveal-delay:<?php echo esc_attr( (string) ( $cc_i * 60 ) ); ?>ms">
						<article class="insight-card">
							<p class="insight-card__meta">
								<time datetime="<?php echo esc_attr( (string) get_the_date( 'c', $cc_post ) ); ?>"><?php echo esc_html( (string) get_the_date( '', $cc_post ) ); ?></time>
								<span aria-hidden="true">·</span>
								<?php
								printf(
									/* translators: %d: estimated minutes of reading time */
									esc_html( _n( '%d min read', '%d min read', $cc_minutes, 'codecharmer-core' ) ),
									(int) $cc_minutes
								);
								?>
							</p>
							<h2 class="insight-card__title">
								<a href="<?php echo esc_url( (string) get_permalink( $cc_post ) ); ?>"><?php echo esc_html( (string) get_the_title( $cc_post ) ); ?></a>
							</h2>
							<?php if ( '' !== $cc_post->post_excerpt ) : ?>
								<p class="insight-card__excerpt"><?php echo esc_html( $cc_post->post_excerpt ); ?></p>
							<?php endif; ?>
						</article>
					</li>
				<?php endforeach; ?>
			</ul>
		<?php endif; ?>
	</div>
</section>
