<?php
/**
 * Config Class.
 *
 * A simple class for grabbing and returning a configuration file from `/config`.
 *
 * @package   CXL Common Lib
 */

namespace CXL\CommonLib\Tools\Config;

/**
 * Config class.
 *
 * @since  1.0.0
 * @access public
 */
class Plugin {

	/**
	 * Includes and returns a given PHP config file. The file must return
	 * an array.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string $name
	 * @param  string $slug
	 * @param string $plugin_file The plugin file path (e.g. __FILE__) or blank string if no plugin is specified.
	 * @return array
	 */
	public static function get( $name, $slug, $plugin_file ) {

		$file = static::path( "{$name}.php", $plugin_file );

		return (array) apply_filters(
			"{$slug}/config/{$name}/",
			file_exists( $file ) ? include $file : []
		);
	}

	/**
	 * Returns the config path or file path if set.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string $file
	 * @param string $plugin_file The plugin file path (e.g. __FILE__) or blank string if no plugin is specified.
	 * @return string
	 */
	public static function path( $file = '', $plugin_file ) {

		$file = trim( $file, '/' );

		// Load from Parent / Child theme first.
		$file_path = get_theme_file_path( "config/{$file}" );
		if ( file_exists( $file_path ) ) {
			return $file_path;
		}

		return plugin_dir_path( $plugin_file ) . ( $file ? "config/{$file}" : 'config' );
	}
}
