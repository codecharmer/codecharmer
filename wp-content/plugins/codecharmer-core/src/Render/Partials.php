<?php
/**
 * Shared render partials for block render.php files.
 *
 * All methods ECHO markup and escape every dynamic value inline, so block
 * render files stay short and the escaping is auditable in one place.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

namespace CodeCharmer\Core\Render;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Shared, escape-audited render partials.
 */
final class Partials {

	/**
	 * Line-icon set. 24×24, 1.5px stroke, currentColor. Decorative by default.
	 *
	 * @param string $name       Icon name.
	 * @param int    $size       Rendered size in px.
	 * @param string $class_name Optional class attribute.
	 * @return void
	 */
	public static function icon( string $name, int $size = 24, string $class_name = '' ): void {
		$paths = array(
			'architecture' => '<path d="M12 3 3 7.5 12 12l9-4.5L12 3Z"/><path d="M3 12l9 4.5L21 12"/><path d="M3 16.5 12 21l9-4.5"/>',
			'blocks'       => '<rect x="3.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="13.5" y="3.5" width="7" height="7" rx="1.5"/><rect x="3.5" y="13.5" width="7" height="7" rx="1.5"/><path d="M17 13.5v7M13.5 17h7"/>',
			'terminal'     => '<rect x="3" y="4.5" width="18" height="15" rx="2.5"/><path d="m7.5 10 3 2.5-3 2.5"/><path d="M13 15h4"/>',
			'flow'         => '<circle cx="6" cy="6" r="2.5"/><circle cx="18" cy="6" r="2.5"/><circle cx="12" cy="18" r="2.5"/><path d="M8.2 7.4 10.5 16M15.8 7.4 13.5 16M8.5 6h7"/>',
			'arrow'        => '<path d="M4 12h15m-6-6 6 6-6 6"/>',
			'spark'        => '<path d="M12 3c.4 3.6 1.4 6.6 4.5 9-3.1 2.4-4.1 5.4-4.5 9-.4-3.6-1.4-6.6-4.5-9 3.1-2.4 4.1-5.4 4.5-9Z"/>',
			'check'        => '<path d="m4.5 12.5 4.5 4.5 10.5-11"/>',
			'external'     => '<path d="M8 6h10v10M18 6 6.5 17.5"/>',
			'calendar'     => '<rect x="3.5" y="5" width="17" height="15.5" rx="2.5"/><path d="M3.5 9.5h17M8 3v4m8-4v4"/>',
			'menu'         => '<path d="M4 7h16M4 12h16M4 17h16"/>',
			'close'        => '<path d="M6 6l12 12M18 6 6 18"/>',
		);
		if ( ! isset( $paths[ $name ] ) ) {
			return;
		}
		printf(
			'<svg class="%1$s" width="%2$d" height="%2$d" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true" focusable="false">%3$s</svg>',
			esc_attr( $class_name ),
			absint( $size ),
			$paths[ $name ] // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- Static SVG path literals defined in this method.
		);
	}

	/**
	 * Button / link primitive. Mirrors the theme's .btn classes.
	 *
	 * @param array{label:string,url:string,variant?:string,size?:string,icon?:string,extra_class?:string} $args Button args.
	 * @return void
	 */
	public static function button( array $args ): void {
		$label   = $args['label'] ?? '';
		$url     = $args['url'] ?? '';
		$variant = $args['variant'] ?? 'primary';
		$size    = $args['size'] ?? 'md';
		$icon    = $args['icon'] ?? '';
		$extra   = $args['extra_class'] ?? '';

		if ( '' === $label || '' === $url ) {
			return;
		}

		$classes = trim( sprintf( 'btn btn--%s btn--%s %s', $variant, $size, $extra ) );
		$is_ext  = 0 === strpos( $url, 'http' );

		printf(
			'<a class="%s" href="%s"%s><span class="btn__label">%s</span>',
			esc_attr( $classes ),
			esc_url( $url ),
			$is_ext ? ' rel="noopener noreferrer"' : '',
			esc_html( $label )
		);
		if ( '' !== $icon ) {
			self::icon( $icon, 18, 'btn__icon' );
		}
		echo '</a>';
	}

	/**
	 * The Code Charmer wordmark lockup.
	 *
	 * @param string $url Link target; empty renders a non-linked span.
	 * @return void
	 */
	public static function logo( string $url = '/' ): void {
		$tag = '' !== $url ? 'a' : 'span';
		printf(
			'<%s class="logo"%s aria-label="%s">',
			esc_attr( $tag ),
			'' !== $url ? ' href="' . esc_url( $url ) . '"' : '',
			esc_attr__( 'Code Charmer — home', 'codecharmer-core' )
		);
		?>
		<svg class="logo__mark" viewBox="0 0 44 28" width="44" height="28" aria-hidden="true" fill="none">
			<path d="M13 4C10.4 4 10.2 6 10.2 8.4C10.2 10.8 9.2 12 7 12.7C9.2 13.4 10.2 14.6 10.2 17C10.2 19.4 10.4 21.4 13 21.4" stroke="var(--logo-accent)" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M31 4C33.6 4 33.8 6 33.8 8.4C33.8 10.8 34.8 12 37 12.7C34.8 13.4 33.8 14.6 33.8 17C33.8 19.4 33.6 21.4 31 21.4" stroke="var(--logo-accent)" stroke-width="1.9" stroke-linecap="round" stroke-linejoin="round"/>
			<path d="M16.5 20L26.5 8.5" stroke="currentColor" stroke-width="2.2" stroke-linecap="round"/>
			<path d="M27.5 5.2C27.8 7.2 28.3 8.1 30 8.7C28.3 9.3 27.8 10.2 27.5 12.2C27.2 10.2 26.7 9.3 25 8.7C26.7 8.1 27.2 7.2 27.5 5.2Z" fill="var(--logo-accent)"/>
		</svg>
		<span class="logo__word"><span class="logo__code">code</span><span class="logo__charm">Charmer</span></span>
		<?php
		printf( '</%s>', esc_attr( $tag ) );
	}

	/**
	 * A project card (Selected Work / Work grid).
	 *
	 * @param \WP_Post $project The cc_project post.
	 * @return void
	 */
	public static function project_card( \WP_Post $project ): void {
		$url        = (string) get_post_meta( $project->ID, 'cc_url', true );
		$descriptor = (string) get_post_meta( $project->ID, 'cc_descriptor', true );
		$tags       = get_post_meta( $project->ID, 'cc_tags', true );
		$tags       = is_array( $tags ) ? $tags : array();
		$host       = preg_replace( '#^https?://#', '', $url );
		$case_url   = (string) get_post_meta( $project->ID, 'cc_case_url', true );
		?>
		<article class="project">
			<a class="project__shot" href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer" aria-label="
			<?php
			echo esc_attr(
				sprintf(
					/* translators: %s: project name */
					__( 'Visit the %s website', 'codecharmer-core' ),
					get_the_title( $project )
				)
			);
			?>
			">
				<?php
				if ( has_post_thumbnail( $project ) ) {
					echo get_the_post_thumbnail(
						$project,
						'large',
						array(
							'alt'     => sprintf(
								/* translators: %s: project name */
								__( 'Screenshot of the %s website', 'codecharmer-core' ),
								get_the_title( $project )
							),
							'loading' => 'lazy',
						)
					);
				}
				?>
				<span class="project__visit"><?php self::icon( 'external', 18 ); ?></span>
			</a>
			<div class="project__body">
				<div class="project__row">
					<h3 class="project__name">
						<a href="<?php echo esc_url( $url ); ?>" target="_blank" rel="noopener noreferrer"><?php echo esc_html( get_the_title( $project ) ); ?></a>
					</h3>
					<span class="project__host"><?php echo esc_html( (string) $host ); ?></span>
				</div>
				<p class="project__desc"><?php echo esc_html( $descriptor ); ?></p>
				<?php if ( $tags ) : ?>
					<ul role="list" class="project__tags">
						<?php foreach ( $tags as $tag ) : ?>
							<li><?php echo esc_html( (string) $tag ); ?></li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
				<?php if ( '' !== $case_url ) : ?>
					<a class="project__case" href="<?php echo esc_url( $case_url ); ?>">
						<?php esc_html_e( 'Read the case study', 'codecharmer-core' ); ?>
						<?php self::icon( 'arrow', 16 ); ?>
					</a>
				<?php endif; ?>
			</div>
		</article>
		<?php
	}

	/**
	 * Collect the attribute sets of a block's inner blocks, defaults merged.
	 *
	 * Serialized block comments omit attributes that equal their defaults, so
	 * render code must merge them back before use.
	 *
	 * @param \WP_Block           $block      The parent block instance.
	 * @param string              $child_name Fully-qualified child block name.
	 * @param array<string,mixed> $defaults   Default attribute values.
	 * @return array<int,array<string,mixed>>
	 */
	public static function inner_attrs( \WP_Block $block, string $child_name, array $defaults ): array {
		$items  = array();
		$parsed = $block->parsed_block['innerBlocks'] ?? array();
		foreach ( $parsed as $inner ) {
			if ( ( $inner['blockName'] ?? '' ) !== $child_name ) {
				continue;
			}
			$items[] = wp_parse_args( $inner['attrs'] ?? array(), $defaults );
		}
		return $items;
	}

	/**
	 * Compute cumulative [from, to] spans (0–1) for a list of weights.
	 *
	 * The instrumented rail's geometry: segment width encodes stage weight.
	 *
	 * @param float[] $weights Stage weights.
	 * @return array<int,array{0:float,1:float}>
	 */
	public static function rail_spans( array $weights ): array {
		$total = array_sum( $weights );
		if ( $total <= 0 ) {
			$total   = count( $weights );
			$weights = array_fill( 0, count( $weights ), 1.0 );
		}
		$spans  = array();
		$cursor = 0.0;
		foreach ( $weights as $weight ) {
			$from    = $cursor / $total;
			$cursor += (float) $weight;
			$spans[] = array( round( $from, 4 ), round( $cursor / $total, 4 ) );
		}
		return $spans;
	}

	/**
	 * The Praxis board vignette — flagship-product artwork in the house style.
	 *
	 * An honest schematic of what the product actually does: one board of
	 * mixed-provenance content (wp / ai / px origin badges), live search with
	 * a timing readout, and the AI cost meter. Cyan line-art on deep ink,
	 * mono labels as measurement — same register as the system diagram.
	 *
	 * @return void
	 */
	public static function praxis_board(): void {
		$line   = 'oklch(0.83 0.13 200 / 0.34)';
		$edge   = 'oklch(0.83 0.13 200 / 0.2)';
		$bright = 'oklch(0.83 0.13 200)';
		$raised = 'oklch(0.245 0.026 236)';
		$dark   = 'oklch(0.19 0.025 236)';
		$label  = 'oklch(0.72 0.015 216)';
		$tick   = 'oklch(1 0 0 / 0.16)';

		$columns = array(
			array( 30, __( 'draft', 'codecharmer-core' ) ),
			array( 186, __( 'review', 'codecharmer-core' ) ),
			array( 342, __( 'published', 'codecharmer-core' ) ),
		);
		?>
		<svg class="praxisboard" viewBox="0 0 490 420" fill="none" role="img"
			aria-label="<?php esc_attr_e( 'A schematic of the Praxis board: a search bar with a 90 millisecond timing readout above three workflow columns. Cards carry origin badges — wp for WordPress, ai for unreviewed AI drafts, px for platform content — and a meter reads the AI generation cost.', 'codecharmer-core' ); ?>">
			<!-- ruler: the house measure -->
			<g aria-hidden="true">
				<?php for ( $i = 0; $i < 44; $i++ ) : ?>
					<?php $y = 24 + $i * 9; ?>
					<line x1="6" y1="<?php echo esc_attr( (string) $y ); ?>" x2="<?php echo 6 === $i % 5 ? 17 : 12; ?>" y2="<?php echo esc_attr( (string) $y ); ?>" stroke="<?php echo esc_attr( $tick ); ?>" stroke-width="1"/>
				<?php endfor; ?>
			</g>

			<!-- search field -->
			<g>
				<rect x="30" y="24" width="332" height="40" rx="9" fill="<?php echo esc_attr( $raised ); ?>" stroke="<?php echo esc_attr( $line ); ?>" stroke-width="1.25"/>
				<circle cx="52" cy="44" r="6.5" stroke="<?php echo esc_attr( $bright ); ?>" stroke-width="1.5"/>
				<path d="M57 49l5 5" stroke="<?php echo esc_attr( $bright ); ?>" stroke-width="1.5" stroke-linecap="round"/>
				<text class="pb-mono" x="72" y="49" fill="<?php echo esc_attr( $label ); ?>"><?php esc_html_e( 'launch checklist', 'codecharmer-core' ); ?></text>
				<rect class="pb-hl" x="70" y="32" width="118" height="22" rx="4" fill="<?php echo esc_attr( $bright ); ?>" opacity="0.14"/>
				<rect x="376" y="24" width="84" height="40" rx="9" fill="<?php echo esc_attr( $dark ); ?>" stroke="<?php echo esc_attr( $edge ); ?>" stroke-width="1.25"/>
				<text class="pb-mono pb-bright" x="392" y="49" fill="<?php echo esc_attr( $bright ); ?>"><?php esc_html_e( '~90 ms', 'codecharmer-core' ); ?></text>
			</g>

			<!-- board frame -->
			<rect x="30" y="86" width="430" height="252" rx="12" stroke="<?php echo esc_attr( $edge ); ?>" stroke-width="1.25"/>

			<?php foreach ( $columns as $ci => $col ) : ?>
				<?php $cx = 30 + 16 + $ci * 146; ?>
				<text class="pb-mono pb-col" x="<?php echo esc_attr( (string) $cx ); ?>" y="112" fill="<?php echo esc_attr( $label ); ?>"><?php echo esc_html( $col[1] ); ?></text>
				<line x1="<?php echo esc_attr( (string) $cx ); ?>" y1="120" x2="<?php echo esc_attr( (string) ( $cx + 114 ) ); ?>" y2="120" stroke="<?php echo esc_attr( $edge ); ?>" stroke-width="1" stroke-dasharray="2 5"/>
			<?php endforeach; ?>

			<!-- cards: [x, y, badge, glow?] -->
			<?php
			$cards = array(
				array( 46, 134, 'wp', false ),
				array( 46, 200, 'px', false ),
				array( 192, 134, 'ai', true ),
				array( 192, 214, 'wp', false ),
				array( 338, 134, 'px', false ),
				array( 338, 200, 'wp', false ),
				array( 338, 266, 'px', false ),
			);
			?>
			<?php foreach ( $cards as $i => $card ) : ?>
				<?php list( $x, $y, $badge, $glow ) = $card; ?>
				<g class="pb-card" style="--d:<?php echo esc_attr( (string) ( 150 + $i * 90 ) ); ?>ms">
					<rect x="<?php echo esc_attr( (string) $x ); ?>" y="<?php echo esc_attr( (string) $y ); ?>" width="114" height="56" rx="8" fill="<?php echo esc_attr( $raised ); ?>" stroke="<?php echo $glow ? esc_attr( $bright ) : esc_attr( $line ); ?>" stroke-width="<?php echo $glow ? '1.5' : '1.25'; ?>"/>
					<path d="M<?php echo esc_attr( (string) ( $x + 12 ) ); ?> <?php echo esc_attr( (string) ( $y + 16 ) ); ?>h56M<?php echo esc_attr( (string) ( $x + 12 ) ); ?> <?php echo esc_attr( (string) ( $y + 26 ) ); ?>h72" stroke="<?php echo esc_attr( $line ); ?>" stroke-width="1.5" stroke-linecap="round"/>
					<rect class="<?php echo 'ai' === $badge ? 'pb-ai' : ''; ?>" x="<?php echo esc_attr( (string) ( $x + 12 ) ); ?>" y="<?php echo esc_attr( (string) ( $y + 36 ) ); ?>" width="26" height="13" rx="3" fill="<?php echo 'ai' === $badge ? esc_attr( $bright ) : 'none'; ?>" stroke="<?php echo esc_attr( 'ai' === $badge ? $bright : $edge ); ?>" stroke-width="1" opacity="<?php echo 'ai' === $badge ? '0.9' : '1'; ?>"/>
					<text class="pb-badge" x="<?php echo esc_attr( (string) ( $x + 25 ) ); ?>" y="<?php echo esc_attr( (string) ( $y + 46 ) ); ?>" text-anchor="middle" fill="<?php echo 'ai' === $badge ? esc_attr( $dark ) : esc_attr( $label ); ?>"><?php echo esc_html( $badge ); ?></text>
				</g>
			<?php endforeach; ?>

			<!-- cost meter -->
			<g>
				<rect x="30" y="358" width="430" height="40" rx="9" fill="<?php echo esc_attr( $dark ); ?>" stroke="<?php echo esc_attr( $edge ); ?>" stroke-width="1.25"/>
				<text class="pb-mono" x="46" y="383" fill="<?php echo esc_attr( $label ); ?>"><?php esc_html_e( 'ai spend · metered per generation', 'codecharmer-core' ); ?></text>
				<g class="pb-meter">
					<?php for ( $i = 0; $i < 10; $i++ ) : ?>
						<rect class="pb-bar" style="--i:<?php echo esc_attr( (string) $i ); ?>" x="<?php echo esc_attr( (string) ( 356 + $i * 9 ) ); ?>" y="370" width="5" height="16" rx="1" fill="<?php echo esc_attr( $bright ); ?>" opacity="<?php echo $i < 4 ? '0.9' : '0.22'; ?>"/>
					<?php endfor; ?>
				</g>
			</g>
		</svg>
		<?php
	}

	/**
	 * The hero system diagram — three labeled planes with live traffic.
	 *
	 * Static brand artwork; identical geometry to the original build.
	 *
	 * @return void
	 */
	public static function system_diagram(): void {
		$w        = 100;
		$surfaces = array(
			array( 90, __( 'site', 'codecharmer-core' ) ),
			array( 210, __( 'portal', 'codecharmer-core' ) ),
			array( 330, __( 'dashboard', 'codecharmer-core' ) ),
		);
		$stores   = array(
			array( 90, __( 'content', 'codecharmer-core' ) ),
			array( 210, __( 'records', 'codecharmer-core' ) ),
			array( 330, __( 'knowledge', 'codecharmer-core' ) ),
		);
		$planes   = array(
			array( 'INTERFACE', 44, 96 ),
			array( 'LOGIC', 172, 118 ),
			array( 'DATA', 322, 100 ),
		);

		$line      = 'oklch(0.83 0.13 200 / 0.34)';
		$edge      = 'oklch(0.83 0.13 200 / 0.22)';
		$bright    = 'oklch(0.83 0.13 200)';
		$fill_dark = 'oklch(0.19 0.025 236)';
		$raised    = 'oklch(0.245 0.026 236)';
		$label_c   = 'oklch(0.72 0.015 216)';
		$tick      = 'oklch(1 0 0 / 0.16)';
		?>
		<svg class="sysdiagram" viewBox="6 26 482 404" fill="none" role="img"
			aria-label="<?php esc_attr_e( 'A system diagram in three layers. An interface layer of site, portal and dashboard sits above a logic layer — an API, an orchestrating core, and automation — which sits above a data layer of content, records and knowledge. Signals flow between the layers.', 'codecharmer-core' ); ?>">
			<defs>
				<radialGradient id="sd-core-glow" cx="50%" cy="50%" r="50%">
					<stop offset="0%" stop-color="<?php echo esc_attr( $bright ); ?>" stop-opacity="0.5"/>
					<stop offset="100%" stop-color="<?php echo esc_attr( $bright ); ?>" stop-opacity="0"/>
				</radialGradient>
				<linearGradient id="sd-packet" x1="0" y1="0" x2="0" y2="1">
					<stop offset="0%" stop-color="<?php echo esc_attr( $bright ); ?>" stop-opacity="0"/>
					<stop offset="45%" stop-color="<?php echo esc_attr( $bright ); ?>" stop-opacity="1"/>
					<stop offset="100%" stop-color="<?php echo esc_attr( $bright ); ?>" stop-opacity="0"/>
				</linearGradient>
			</defs>
			<g class="sd-ruler" aria-hidden="true">
				<?php for ( $i = 0; $i < 48; $i++ ) : ?>
					<?php $y = 42 + $i * 8; ?>
					<line x1="10" y1="<?php echo esc_attr( (string) $y ); ?>" x2="<?php echo 2 === $y % 40 ? 22 : 16; ?>" y2="<?php echo esc_attr( (string) $y ); ?>" stroke="<?php echo esc_attr( $tick ); ?>" stroke-width="1"/>
				<?php endfor; ?>
			</g>
			<?php foreach ( $planes as $plane ) : ?>
				<?php list( $plabel, $py, $ph ) = $plane; ?>
				<g class="sd-plane">
					<path d="M40 <?php echo esc_attr( (string) ( $py + 12 ) ); ?>V<?php echo esc_attr( (string) $py ); ?>H52M468 <?php echo esc_attr( (string) $py ); ?>H480V<?php echo esc_attr( (string) ( $py + 12 ) ); ?> M40 <?php echo esc_attr( (string) ( $py + $ph - 12 ) ); ?>V<?php echo esc_attr( (string) ( $py + $ph ) ); ?>H52M468 <?php echo esc_attr( (string) ( $py + $ph ) ); ?>H480V<?php echo esc_attr( (string) ( $py + $ph - 12 ) ); ?>" stroke="<?php echo esc_attr( $edge ); ?>" stroke-width="1.25" fill="none"/>
					<line x1="52" y1="<?php echo esc_attr( (string) $py ); ?>" x2="468" y2="<?php echo esc_attr( (string) $py ); ?>" stroke="<?php echo esc_attr( $edge ); ?>" stroke-width="1" stroke-dasharray="2 6"/>
					<text class="sd-plane-label" x="40" y="<?php echo esc_attr( (string) ( $py - 8 ) ); ?>" fill="<?php echo esc_attr( $label_c ); ?>"><?php echo esc_html( $plabel ); ?></text>
				</g>
			<?php endforeach; ?>
			<g stroke="<?php echo esc_attr( $edge ); ?>" stroke-width="1.25">
				<?php foreach ( $surfaces as $s ) : ?>
					<path d="M<?php echo esc_attr( (string) ( $s[0] + $w / 2 ) ); ?> 128V172"/>
				<?php endforeach; ?>
				<?php foreach ( $stores as $s ) : ?>
					<path d="M<?php echo esc_attr( (string) ( $s[0] + $w / 2 ) ); ?> 290V346"/>
				<?php endforeach; ?>
			</g>
			<g class="sd-flow" stroke="url(#sd-packet)" stroke-width="2.5" stroke-linecap="round">
				<path class="sd-packet" style="--d:0ms" d="M140 128V172"/>
				<path class="sd-packet" style="--d:1100ms" d="M260 128V172"/>
				<path class="sd-packet" style="--d:600ms" d="M380 128V172"/>
				<path class="sd-packet sd-packet--up" style="--d:300ms" d="M140 290V346"/>
				<path class="sd-packet sd-packet--up" style="--d:1500ms" d="M260 290V346"/>
				<path class="sd-packet sd-packet--up" style="--d:900ms" d="M380 290V346"/>
			</g>
			<g class="sd-nodes">
				<?php foreach ( $surfaces as $i => $s ) : ?>
					<g class="sd-node" style="--d:<?php echo esc_attr( (string) ( 120 + $i * 90 ) ); ?>ms">
						<rect x="<?php echo esc_attr( (string) $s[0] ); ?>" y="72" width="<?php echo esc_attr( (string) $w ); ?>" height="56" rx="8" fill="<?php echo esc_attr( $raised ); ?>" stroke="<?php echo esc_attr( $line ); ?>" stroke-width="1.25"/>
						<path d="M<?php echo esc_attr( (string) ( $s[0] + 12 ) ); ?> 90H<?php echo esc_attr( (string) ( $s[0] + 50 ) ); ?>M<?php echo esc_attr( (string) ( $s[0] + 12 ) ); ?> 100H<?php echo esc_attr( (string) ( $s[0] + 70 ) ); ?>" stroke="<?php echo esc_attr( $line ); ?>" stroke-width="1.5" stroke-linecap="round"/>
						<text class="sd-node-label" x="<?php echo esc_attr( (string) ( $s[0] + 12 ) ); ?>" y="119" fill="<?php echo esc_attr( $label_c ); ?>"><?php echo esc_html( $s[1] ); ?></text>
					</g>
				<?php endforeach; ?>
			</g>
			<g class="sd-nodes">
				<g class="sd-node" style="--d:420ms">
					<rect x="46" y="204" width="<?php echo esc_attr( (string) $w ); ?>" height="54" rx="8" fill="<?php echo esc_attr( $raised ); ?>" stroke="<?php echo esc_attr( $line ); ?>" stroke-width="1.25"/>
					<text class="sd-node-label" x="60" y="226" fill="<?php echo esc_attr( $label_c ); ?>"><?php esc_html_e( 'api', 'codecharmer-core' ); ?></text>
					<path d="M60 238h72" stroke="<?php echo esc_attr( $line ); ?>" stroke-width="1.5" stroke-linecap="round"/>
				</g>
				<g class="sd-node" style="--d:620ms">
					<rect x="374" y="204" width="<?php echo esc_attr( (string) $w ); ?>" height="54" rx="8" fill="<?php echo esc_attr( $raised ); ?>" stroke="<?php echo esc_attr( $line ); ?>" stroke-width="1.25"/>
					<text class="sd-node-label" x="388" y="226" fill="<?php echo esc_attr( $label_c ); ?>"><?php esc_html_e( 'automation', 'codecharmer-core' ); ?></text>
					<path d="M388 238h72" stroke="<?php echo esc_attr( $line ); ?>" stroke-width="1.5" stroke-linecap="round"/>
				</g>
				<g stroke="<?php echo esc_attr( $edge ); ?>" stroke-width="1.25"><path d="M146 231H212"/><path d="M308 231H374"/></g>
				<path class="sd-lateral" d="M146 231H212" stroke="url(#sd-packet)" stroke-width="2.5" stroke-linecap="round"/>
				<path class="sd-lateral" style="--d:1400ms" d="M308 231H374" stroke="url(#sd-packet)" stroke-width="2.5" stroke-linecap="round"/>
				<circle class="sd-core-glow" cx="260" cy="231" r="62" fill="url(#sd-core-glow)"/>
				<g class="sd-core">
					<rect x="212" y="203" width="96" height="56" rx="10" fill="<?php echo esc_attr( $fill_dark ); ?>" stroke="<?php echo esc_attr( $bright ); ?>" stroke-width="1.5"/>
					<text class="sd-core-label" x="260" y="227" fill="oklch(0.95 0.02 200)" text-anchor="middle"><?php esc_html_e( 'core', 'codecharmer-core' ); ?></text>
					<g class="sd-meter">
						<?php for ( $i = 0; $i < 9; $i++ ) : ?>
							<rect class="sd-bar" style="--i:<?php echo esc_attr( (string) $i ); ?>" x="<?php echo esc_attr( (string) ( 224 + $i * 8 ) ); ?>" y="236" width="4" height="10" rx="1" fill="<?php echo esc_attr( $bright ); ?>"/>
						<?php endfor; ?>
					</g>
				</g>
			</g>
			<g class="sd-nodes">
				<?php foreach ( $stores as $i => $s ) : ?>
					<g class="sd-node" style="--d:<?php echo esc_attr( (string) ( 760 + $i * 90 ) ); ?>ms">
						<rect x="<?php echo esc_attr( (string) $s[0] ); ?>" y="346" width="<?php echo esc_attr( (string) $w ); ?>" height="52" rx="8" fill="<?php echo esc_attr( $raised ); ?>" stroke="<?php echo esc_attr( $line ); ?>" stroke-width="1.25"/>
						<path d="M<?php echo esc_attr( (string) ( $s[0] + 12 ) ); ?> 362h76M<?php echo esc_attr( (string) ( $s[0] + 12 ) ); ?> 372h76" stroke="<?php echo esc_attr( $line ); ?>" stroke-width="1" stroke-dasharray="3 4"/>
						<text class="sd-node-label" x="<?php echo esc_attr( (string) ( $s[0] + 12 ) ); ?>" y="390" fill="<?php echo esc_attr( $label_c ); ?>"><?php echo esc_html( $s[1] ); ?></text>
					</g>
				<?php endforeach; ?>
			</g>
		</svg>
		<?php
	}
}
