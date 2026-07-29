<?php
/**
 * Plugin container & bootstrapper.
 *
 * Instantiates and boots each Bootable service. Services are declared in one
 * ordered list; missing classes are skipped so the plugin degrades gracefully
 * rather than fataling if a module is absent.
 *
 * @package CodeCharmer\Core
 */

declare( strict_types=1 );

namespace CodeCharmer\Core;

use CodeCharmer\Core\Contracts\Bootable;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * The plugin container: instantiates and boots every service.
 */
final class Plugin {

	/**
	 * Singleton instance.
	 *
	 * @var Plugin|null
	 */
	private static ?Plugin $instance = null;

	/**
	 * Resolved service instances, keyed by class name.
	 *
	 * @var array<string,object>
	 */
	private array $services = array();

	/**
	 * Whether boot() has already run.
	 *
	 * @var bool
	 */
	private bool $booted = false;

	/**
	 * Fetch (and lazily create) the singleton.
	 *
	 * @return Plugin
	 */
	public static function instance(): Plugin {
		if ( null === self::$instance ) {
			self::$instance = new self();
		}
		return self::$instance;
	}

	/**
	 * Private constructor — use instance().
	 */
	private function __construct() {}

	/**
	 * The ordered service map. Order matters: options first, then the content
	 * model, then delivery surfaces (REST, SEO, CLI).
	 *
	 * @return class-string[]
	 */
	private function service_classes(): array {
		return array(
			Setup\Options::class,

			// Content model.
			Content\PostTypes::class,
			Content\Blocks::class,

			// Delivery.
			Rest\InquiryController::class,
			Seo\MetaTags::class,
			Cli\Commands::class,
		);
	}

	/**
	 * Boot all available services exactly once.
	 *
	 * @return void
	 */
	public function boot(): void {
		if ( $this->booted ) {
			return;
		}
		$this->booted = true;

		load_plugin_textdomain( 'codecharmer-core', false, dirname( plugin_basename( CODECHARMER_CORE_FILE ) ) . '/languages' );

		foreach ( $this->service_classes() as $class ) {
			if ( ! class_exists( $class ) ) {
				continue;
			}
			$service = new $class();
			if ( $service instanceof Bootable ) {
				$service->boot();
			}
			$this->services[ $class ] = $service;
		}

		/**
		 * Fires after all core services have booted.
		 *
		 * @param Plugin $plugin The plugin container.
		 */
		do_action( 'codecharmer_core_booted', $this );
	}

	/**
	 * Fetch a booted service instance.
	 *
	 * @param string $class_name Fully-qualified class name.
	 * @return object|null
	 */
	public function get( string $class_name ): ?object {
		return $this->services[ $class_name ] ?? null;
	}
}
