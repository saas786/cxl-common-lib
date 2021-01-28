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
	 * Singleton pattern
	 *
	 * @var null|Plugin
	 */
	private static $instance;

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

		// Load translations.
		add_action( 'plugins_loaded', [ $this, 'loadTextdomain' ], 1 );

		// Run.
		add_action( 'plugins_loaded', [ $this, 'init' ], 1 );

		if ( is_admin() ) {
			$this->initAdmin();
		}
	}

	/**
	 * Load the plugin textdomain.
	 *
	 * @since  2021.01.28
	 * @access public
	 * @return void
	 */
	public function loadTextdomain(): void {

		load_plugin_textdomain(
			'cxl-common-lib',
			false,
			trailingslashit( dirname( plugin_basename( CXL_COMMON_LIB_PLUGIN_FILE ) ) ) . '/public/lang'
		);
	}

	/**
	 * @inheritDoc
	 *
	 * @since 2021.01.01
	 */
	public function init(): void {}

	/**
	 * Only `wp-admin`.
	 *
	 * @since 2021.01.01
	 */
	private function initAdmin(): void {}

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
	public function logException( Exception $e, $data = [] ): bool {

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
	public static function getInstance(): Plugin {

		if ( ! self::$instance ) {
			/** @var Plugin $instance */
			self::$instance = new self();
		}

		return self::$instance;
	}

}
