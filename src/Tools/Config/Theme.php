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
class Theme {

	/**
	 * Includes and returns a given PHP config file. The file must return
	 * an array.
	 *
	 * @since  1.0.0
	 * @access public
	 * @param  string $name
	 * @param  string $slug
	 * @return array
	 */
	public static function get( $name, $slug ) {

		$file = static::path( "{$name}.php" );

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
	 * @return string
	 */
	public static function path( $file = '' ) {

		$file = trim( $file, '/' );

		return get_theme_file_path( $file ? "config/{$file}" : 'config' );
	}
}
