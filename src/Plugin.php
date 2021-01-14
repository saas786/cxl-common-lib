<?php
/**
 * CXL Common implementation
 *
 * @package ConversionXL
 */

namespace CXL\CommonLib;

use Exception;
use League\Plates\Engine;

defined( 'ABSPATH' ) || exit;

/**
 * Main class
 *
 * @psalm-suppress UndefinedTrait
 */
final class Plugin {

	/**
	 * Plugin dir path.
	 *
	 * @var string
	 */
	public $plugin_dir_path;

	/**
	 * Plugin dir url.
	 *
	 * @var string
	 */
	public $plugin_dir_url;

	/**
	 * Directory slug
	 *
	 * @var string
	 */
	public $slug;

	/**
	 * View (templates) engine.
	 *
	 * @var Engine
	 */
	private $view;

	/**
	 * Singleton pattern
	 *
	 * @var null|Plugin
	 */
	private static $instance;

	/**
	 * Hybrid Core Application instance / object.
	 *
	 * @var \Hybrid\Core\Application
	 */
	public $hybrid_core;

	/**
	 * Clone
	 */
	private function __clone() {}

	/**
	 * Constructor.
	 *
	 * @throws Exception
	 */
	private function __construct() {

		/**
		 * Provision plugin context info.
		 *
		 * @see https://developer.wordpress.org/reference/functions/plugin_dir_path/
		 * @see https://stackoverflow.com/questions/11094776/php-how-to-go-one-level-up-on-dirname-file
		 */
		$this->plugin_dir_path = trailingslashit( dirname( __DIR__, 1 ) );
		$this->plugin_dir_url  = plugin_dir_url( __FILE__ );
		$this->slug            = basename( $this->plugin_dir_path );

		// Run.
		add_action( 'plugins_loaded', [ $this, 'init' ], 1 );

		if ( is_admin() ) {
			$this->init_admin();
		}

	}

	/**
	 * Init
	 */
	public function init(): void {
		// $this->hybrid_core = new \Hybrid\Core\Application();
	}

	/**
	 * Only `wp-admin`.
	 *
	 * @SuppressWarnings(PHPMD.ExitExpression)
	 * @see https://github.com/WordPress-Coding-Standards/WordPress-Coding-Standards/issues/1205
	 * @since 2018.08.27
	 */
	private function init_admin(): void {

	}

	/**
	 * General exception logger.
	 *
	 * @SuppressWarnings(PHPMD.ShortVariable)
	 * @param Exception $e
	 * @param mixed     $data Additional data.
	 * @return bool
	 * @throws Exception
	 * @todo Sentry, not `error_log()`.
	 */
	public function log_exception( Exception $e, $data = [] ): bool {

		/**
		 * AS has built-in failure logger, avoid hijack.
		 *
		 * @see https://metabase.cxl.co/question/178
		 * @since 2019.05.11
		 */
		if ( did_action( 'action_scheduler_before_execute' ) ) {
			throw $e;
		}

		return error_log( sprintf( '%s - DATA: %s', $e->getMessage(), print_r( $data, true ) ) ); // phpcs:ignore WordPress.PHP.DevelopmentFunctions.error_log_error_log,WordPress.PHP.DevelopmentFunctions.error_log_print_r

	}

	/**
	 * Singleton pattern.
	 */
	public static function get_instance(): Plugin {

		if ( ! self::$instance ) {
			/** @var Plugin $instance */
			self::$instance = new self();
		}

		return self::$instance;

	}

}
