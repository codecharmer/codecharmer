<?php
/**
 * JSON-LD structured data.
 *
 * Front page: Organization + WebSite. Nested pages: BreadcrumbList matching
 * the visible page hierarchy. Posts (future insights): Article. FAQ markup is
 * deliberately omitted — visible FAQs matter more than the rich result.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

namespace CodeCharmer\Core\Seo;

use CodeCharmer\Core\Contracts\Bootable;
use CodeCharmer\Core\Setup\Options;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Emits one JSON-LD graph per view.
 */
final class StructuredData implements Bootable {

	/**
	 * Register hooks.
	 *
	 * @return void
	 */
	public function boot(): void {
		add_action( 'wp_head', array( $this, 'render' ), 7 );
	}

	/**
	 * Build and print the JSON-LD graph for the current view.
	 *
	 * @return void
	 */
	public function render(): void {
		$graph = array();

		if ( is_front_page() ) {
			$graph[] = $this->organization();
			$graph[] = $this->website();
		} elseif ( is_singular( 'post' ) ) {
			$article = $this->article();
			if ( array() !== $article ) {
				$graph[] = $article;
			}
		} elseif ( is_page() ) {
			$breadcrumb = $this->breadcrumb();
			if ( array() !== $breadcrumb ) {
				$graph[] = $breadcrumb;
			}
		}

		/**
		 * Filter the structured data graph before output.
		 *
		 * @param array<int,array<string,mixed>> $graph The schema.org nodes.
		 */
		$graph = (array) apply_filters( 'codecharmer_structured_data', $graph );
		if ( array() === $graph ) {
			return;
		}

		$data = array(
			'@context' => 'https://schema.org',
			'@graph'   => array_values( $graph ),
		);
		printf(
			'<script type="application/ld+json">%s</script>' . "\n",
			wp_json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE ) // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped -- wp_json_encode output inside a JSON script tag.
		);
	}

	/**
	 * Organization node.
	 *
	 * @return array<string,mixed>
	 */
	private function organization(): array {
		$node = array(
			'@type' => 'Organization',
			'@id'   => home_url( '/#organization' ),
			'name'  => get_bloginfo( 'name' ),
			'url'   => home_url( '/' ),
			'logo'  => plugins_url( 'assets/social-card.png', CODECHARMER_CORE_FILE ),
		);

		$email = Options::get( 'email' );
		if ( '' !== $email ) {
			$node['email'] = $email;
		}

		$same_as = $this->same_as();
		if ( array() !== $same_as ) {
			$node['sameAs'] = $same_as;
		}

		return $node;
	}

	/**
	 * WebSite node.
	 *
	 * @return array<string,mixed>
	 */
	private function website(): array {
		return array(
			'@type'     => 'WebSite',
			'@id'       => home_url( '/#website' ),
			'name'      => get_bloginfo( 'name' ),
			'url'       => home_url( '/' ),
			'publisher' => array( '@id' => home_url( '/#organization' ) ),
		);
	}

	/**
	 * BreadcrumbList for nested pages, matching the visible hierarchy.
	 *
	 * @return array<string,mixed> Empty for top-level pages.
	 */
	private function breadcrumb(): array {
		$post = get_queried_object();
		if ( ! $post instanceof \WP_Post || 0 === $post->post_parent ) {
			return array();
		}

		// Same source as the visible trail (Partials::breadcrumbs), so the
		// markup and the structured data can never diverge.
		$trail   = \CodeCharmer\Core\Render\Partials::breadcrumb_items( $post );
		$trail[] = array(
			'name' => (string) get_the_title( $post ),
			'url'  => (string) get_permalink( $post ),
		);

		$items = array();
		foreach ( $trail as $i => $crumb ) {
			$items[] = array(
				'@type'    => 'ListItem',
				'position' => $i + 1,
				'name'     => $crumb['name'],
				'item'     => $crumb['url'],
			);
		}

		return array(
			'@type'           => 'BreadcrumbList',
			'itemListElement' => $items,
		);
	}

	/**
	 * Article node for future insights posts.
	 *
	 * @return array<string,mixed> Empty when the view is not a post.
	 */
	private function article(): array {
		$post = get_queried_object();
		if ( ! $post instanceof \WP_Post ) {
			return array();
		}

		$node = array(
			'@type'         => 'Article',
			'headline'      => (string) get_the_title( $post ),
			'url'           => (string) get_permalink( $post ),
			'datePublished' => (string) get_the_date( 'c', $post ),
			'dateModified'  => (string) get_the_modified_date( 'c', $post ),
			'publisher'     => array( '@id' => home_url( '/#organization' ) ),
		);

		$author = get_the_author_meta( 'display_name', (int) $post->post_author );
		if ( '' !== $author ) {
			$node['author'] = array(
				'@type' => 'Person',
				'name'  => $author,
			);
		}

		$image = get_the_post_thumbnail_url( $post, 'full' );
		if ( is_string( $image ) && '' !== $image ) {
			$node['image'] = $image;
		}

		return $node;
	}

	/**
	 * External identity URLs from the newline-delimited `sameas_urls` setting.
	 *
	 * @return string[]
	 */
	private function same_as(): array {
		$raw = Options::get( 'sameas_urls' );
		if ( '' === trim( $raw ) ) {
			return array();
		}

		$lines = preg_split( '/[\r\n]+/', $raw );
		if ( false === $lines ) {
			return array();
		}

		$urls = array();
		foreach ( $lines as $line ) {
			$url = esc_url_raw( trim( $line ) );
			if ( '' !== $url ) {
				$urls[] = $url;
			}
		}
		return $urls;
	}
}
