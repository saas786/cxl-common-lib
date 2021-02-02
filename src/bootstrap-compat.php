<?php
/**
 * WP and PHP compatibility.
 *
 * Functions used to gracefully fail when a plugin doesn't meet the minimum WP or
 * PHP versions required. Note that only code that will work on PHP 5.3.0 should
 * go into this file. Otherwise, it'll break on sites not meeting the minimum
 * PHP requirement. Only call this file after initially checking that the site
 * doesn't meet either the WP or PHP requirement.
 *
 * @since  2021.01.27
 */

namespace CXL\CommonLib;

defined( 'ABSPATH' ) || exit;

// Add actions to fail at certain points in the load process.
add_action( 'plugins_loaded', __NAMESPACE__ . '\init_deactivation' );

/**
 * Initialise deactivation.
 *
 * @since  2021.01.27
 * @return void
 */
function init_deactivation() {
	if ( ! current_user_can( 'activate_plugins' ) ) {
		return;
	}

	add_action( 'admin_init', __NAMESPACE__ . '\deactivate' );
	add_action( 'admin_notices', __NAMESPACE__ . '\upgrade_notice' );
}

/**
 * Deactivate the plugin.
 *
 * @since  2021.01.27
 * @return void
 */
function deactivate() {
	deactivate_plugins( plugin_basename( CXL_BLOCKS_PLUGIN_FILE ) );
}

/**
 * Outputs an admin notice with the compatibility issue.
 *
 * @since  2021.01.27
 * @return void
 */
function upgrade_notice() {

	// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- not using value, only checking if it is set.
	if ( isset( $_GET['activate'] ) ) {
		// phpcs:ignore WordPress.Security.NonceVerification.Recommended -- not using value, only checking if it is set.
		unset( $_GET['activate'] );
	}

	printf( '<div class="error _updated"><p>%s</p></div>', esc_html( compat_message() ) );
}

/**
 * Returns the compatibility messaged based on whether the WP or PHP minimum
 * requirement wasn't met.
 *
 * @since  2021.01.27
 * @return string
 */
function compat_message() {

	if ( version_compare( $GLOBALS['wp_version'], '5.6', '<' ) ) {

		return sprintf(
		// Translators: 1 is the required WordPress version and 2 is the user's current version.
			__( 'CXL Common Lib requires at least WordPress version %1$s. You are running version %2$s. Please upgrade and try again.', 'cxl-common-lib' ),
			'5.6',
			$GLOBALS['wp_version']
		);

	} elseif ( version_compare( PHP_VERSION, '7.4', '<' ) ) {

		return sprintf(
		// Translators: 1 is the required PHP version and 2 is the user's current version.
			__( 'CXL Common Lib requires at least PHP version %1$s. You are running version %2$s. Please upgrade and try again.', 'cxl-common-lib' ),
			'7.4',
			PHP_VERSION
		);
	}

	return '';
}
