<?php
/**
 * CXL common functionality, integrations, features
 *
 * @package ConversionXL
 *
 * Plugin Name: CXL Common Lib
 * Plugin URI: https://cxl.com/
 * Description: Functionality, integrations, features.
 * Author: Leho Kraav
 * Author URI: https://cxl.com
 * Version: 2021.01.01
 */

use CXL\CommonLib\Plugin;

defined( 'ABSPATH' ) || exit;

require_once __DIR__ . '/vendor/autoload.php';

/**
 * Returns plugin instance.
 *
 * @return Plugin
 * @since 2021.01.01
 */
function cxl_common_lib() {

	return Plugin::get_instance();

}

add_action( 'plugins_loaded', 'cxl_common_lib', 0 );
