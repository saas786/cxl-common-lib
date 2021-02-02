<?php
/**
 * CXL common functionality, integrations, features
 *
 * @package ConversionXL
 *
 * Plugin Name:       CXL Common Lib
 * Plugin URI:        https://cxl.com/
 * Description:       Functionality, integrations, features.
 * Author:            Leho Kraav
 * Author URI:        https://cxl.com
 * Version:           2021.02.03
 *
 * Requires at least: 5.6
 * Requires PHP:      7.4
 * Text Domain:       cxl-common-lib
 * Domain Path:       /public/lang
 */

use CXL\CommonLib\Plugin;

defined( 'ABSPATH' ) || exit;

define( 'CXL_COMMON_LIB_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'CXL_COMMON_LIB_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
define( 'CXL_COMMON_LIB_PLUGIN_FILE', __FILE__ );
define( 'CXL_COMMON_LIB_PLUGIN_BASE', plugin_basename( __FILE__ ) );

// ------------------------------------------------------------------------------
// Compatibility check.
// ------------------------------------------------------------------------------
//
// Check that the site meets the minimum requirements for the plugin.

if ( version_compare( $GLOBALS['wp_version'], '5.6', '<' ) || version_compare( PHP_VERSION, '7.4', '<' ) ) {

	require_once __DIR__ . '/src/bootstrap-compat.php';
	return;
}

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Returns plugin instance.
 *
 * @return Plugin
 * @since 2021.01.01
 */
function cxl_common_lib() {

	return Plugin::getInstance();

}

add_action( 'plugins_loaded', 'cxl_common_lib', 0 );
