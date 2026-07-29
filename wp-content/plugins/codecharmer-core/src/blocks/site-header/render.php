<?php
/**
 * Site header render.
 *
 * Nav items come from the 'primary' menu when the owner has assigned one;
 * otherwise the structural default (Services / Work / Process / About) built
 * from the seeded pages map. The services mega-menu always reflects the real
 * service pages.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

use CodeCharmer\Core\Render\Partials;
use CodeCharmer\Core\Setup\Options;

$cc_services  = Options::service_pages();
$cc_cta_label = Options::get( 'cta_label' );
$cc_cta_url   = Options::page_url( 'contact' );

$cc_nav_items = array();
$cc_locations = get_nav_menu_locations();
if ( ! empty( $cc_locations['primary'] ) ) {
	$cc_menu_items = wp_get_nav_menu_items( (int) $cc_locations['primary'] );
	if ( is_array( $cc_menu_items ) ) {
		foreach ( $cc_menu_items as $cc_menu_item ) {
			$cc_nav_items[] = array(
				'label'    => (string) $cc_menu_item->title,
				'url'      => (string) $cc_menu_item->url,
				'has_menu' => 'services' === sanitize_title( (string) $cc_menu_item->title ),
			);
		}
	}
}
if ( ! $cc_nav_items ) {
	$cc_nav_items = array(
		array(
			'label'    => __( 'Services', 'codecharmer-core' ),
			'url'      => Options::page_url( 'services' ),
			'has_menu' => true,
		),
		array(
			'label'    => __( 'Work', 'codecharmer-core' ),
			'url'      => Options::page_url( 'work' ),
			'has_menu' => false,
		),
		array(
			'label'    => __( 'Process', 'codecharmer-core' ),
			'url'      => Options::page_url( 'process' ),
			'has_menu' => false,
		),
		array(
			'label'    => __( 'About', 'codecharmer-core' ),
			'url'      => Options::page_url( 'about' ),
			'has_menu' => false,
		),
	);
}
?>
<a class="skip-link" href="#main"><?php esc_html_e( 'Skip to content', 'codecharmer-core' ); ?></a>
<div class="site-header" data-header>
	<div class="container header__bar">
		<?php Partials::logo( home_url( '/' ) ); ?>

		<nav class="header__nav" aria-label="<?php esc_attr_e( 'Primary', 'codecharmer-core' ); ?>">
			<ul role="list" class="nav">
				<?php foreach ( $cc_nav_items as $cc_item ) : ?>
					<?php if ( $cc_item['has_menu'] && $cc_services ) : ?>
						<li class="nav__item nav__item--menu" data-menu-root>
							<button class="nav__link nav__trigger" aria-expanded="false" aria-controls="services-menu" data-menu-trigger>
								<?php echo esc_html( $cc_item['label'] ); ?>
								<svg class="nav__chevron" viewBox="0 0 12 12" width="12" height="12" fill="none" aria-hidden="true">
									<path d="m3 4.5 3 3 3-3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
								</svg>
							</button>
							<div class="mega" id="services-menu" data-menu-panel hidden>
								<div class="mega__inner">
									<p class="mega__eyebrow eyebrow"><?php esc_html_e( 'What we build', 'codecharmer-core' ); ?></p>
									<ul role="list" class="mega__grid">
										<?php foreach ( $cc_services as $cc_service ) : ?>
											<li>
												<a class="mega__card" href="<?php echo esc_url( $cc_service['url'] ); ?>">
													<span class="mega__icon"><?php Partials::icon( $cc_service['icon'], 22 ); ?></span>
													<span class="mega__text">
														<span class="mega__name"><?php echo esc_html( $cc_service['title'] ); ?></span>
														<span class="mega__desc"><?php echo esc_html( $cc_service['descriptor'] ); ?></span>
													</span>
												</a>
											</li>
										<?php endforeach; ?>
									</ul>
									<div class="mega__foot">
										<a class="mega__link" href="<?php echo esc_url( Options::page_url( 'services' ) ); ?>"><?php esc_html_e( 'All services', 'codecharmer-core' ); ?> <?php Partials::icon( 'arrow', 15 ); ?></a>
										<a class="mega__link" href="<?php echo esc_url( Options::page_url( 'process' ) ); ?>"><?php esc_html_e( 'How we work', 'codecharmer-core' ); ?> <?php Partials::icon( 'arrow', 15 ); ?></a>
									</div>
								</div>
							</div>
						</li>
					<?php else : ?>
						<li class="nav__item">
							<a class="nav__link" href="<?php echo esc_url( $cc_item['url'] ); ?>"><?php echo esc_html( $cc_item['label'] ); ?></a>
						</li>
					<?php endif; ?>
				<?php endforeach; ?>
			</ul>
		</nav>

		<div class="header__actions">
			<span class="header__cta">
				<?php
				Partials::button(
					array(
						'label'   => $cc_cta_label,
						'url'     => $cc_cta_url,
						'variant' => 'primary',
					)
				);
				?>
			</span>
			<button class="nav__toggle" data-nav-toggle aria-expanded="false" aria-controls="mobile-nav" aria-label="<?php esc_attr_e( 'Open menu', 'codecharmer-core' ); ?>">
				<span class="nav__toggle-open"><?php Partials::icon( 'menu', 24 ); ?></span>
				<span class="nav__toggle-close"><?php Partials::icon( 'close', 24 ); ?></span>
			</button>
		</div>
	</div>
</div>

<div class="mobile-nav band-ink" id="mobile-nav" data-mobile-nav hidden>
	<nav class="mobile-nav__inner container" aria-label="<?php esc_attr_e( 'Mobile', 'codecharmer-core' ); ?>">
		<a class="mobile-nav__section-label eyebrow" href="<?php echo esc_url( Options::page_url( 'services' ) ); ?>"><?php esc_html_e( 'Services', 'codecharmer-core' ); ?></a>
		<ul role="list" class="mobile-nav__pillars">
			<?php foreach ( $cc_services as $cc_service ) : ?>
				<li>
					<a class="mobile-nav__pillar" href="<?php echo esc_url( $cc_service['url'] ); ?>">
						<?php Partials::icon( $cc_service['icon'], 20 ); ?> <?php echo esc_html( $cc_service['title'] ); ?>
					</a>
				</li>
			<?php endforeach; ?>
		</ul>
		<ul role="list" class="mobile-nav__links">
			<?php foreach ( $cc_nav_items as $cc_item ) : ?>
				<?php if ( ! $cc_item['has_menu'] ) : ?>
					<li><a href="<?php echo esc_url( $cc_item['url'] ); ?>"><?php echo esc_html( $cc_item['label'] ); ?></a></li>
				<?php endif; ?>
			<?php endforeach; ?>
		</ul>
		<?php
		Partials::button(
			array(
				'label'       => $cc_cta_label,
				'url'         => $cc_cta_url,
				'variant'     => 'primary',
				'size'        => 'lg',
				'extra_class' => 'mobile-nav__cta',
			)
		);
		?>
	</nav>
</div>
