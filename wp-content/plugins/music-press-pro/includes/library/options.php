<?php
namespace mp;
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'mp\Options' ) ) {


	/**
	 * Class Options
	 * @package mp\core
	 */
	class Options {


		/**
		 * @var array
		 */
		var $options = array();


		/**
		 * Options constructor.
		 */
		function __construct() {
			$this->init_variables();
		}


		/**
		 * Set variables
		 */
		function init_variables() {
			$this->options = get_option( 'mp_options' );
		}


		/**
		 * Get MP option value
		 *
		 * @param $option_id
		 * @return mixed|string|void
		 */
		function get( $option_id ) {
			if ( isset( $this->options[ $option_id ] ) ) {
				/**
				 * MP hook
				 *
				 * @type filter
				 * @title mp_get_option_filter__{$option_id}
				 * @description Change MP option on get by $option_id
				 * @input_vars
				 * [{"var":"$option","type":"array","desc":"Option Value"}]
				 * @change_log
				 * ["Since: 2.0"]
				 * @usage
				 * <?php add_filter( 'mp_get_option_filter__{$option_id}', 'function_name', 10, 1 ); ?>
				 * @example
				 * <?php
				 * add_filter( 'mp_get_option_filter__{$option_id}', 'my_get_option_filter', 10, 1 );
				 * function my_get_option_filter( $option ) {
				 *     // your code here
				 *     return $option;
				 * }
				 * ?>
				 */
				return apply_filters( "mp_get_option_filter__{$option_id}", $this->options[ $option_id ] );
			}

			switch ( $option_id ) {
				case 'site_name':
					return get_bloginfo( 'name' );
					break;
				case 'admin_email':
					return get_bloginfo( 'admin_email' );
					break;
				default:
					return '';
					break;
			}
		}


		/**
		 * Update MP option value
		 *
		 * @param $option_id
		 * @param $value
		 */
		function update( $option_id, $value ) {
			$this->options[ $option_id ] = $value;
			update_option( 'mp_options', $this->options );
		}


		/**
		 * Delete MP option
		 *
		 * @param $option_id
		 */
		function remove( $option_id ) {
			if ( ! empty( $this->options[ $option_id ] ) )
				unset( $this->options[ $option_id ] );

			update_option( 'mp_options', $this->options );
		}


		/**
		 * Get MP option default value
		 *
		 * @use MP()->config()
		 *
		 * @param $option_id
		 * @return bool
		 */
		function get_default( $option_id ) {
			$settings_defaults = MP()->config()->settings_defaults;
			if ( ! isset( $settings_defaults[ $option_id ] ) )
				return false;

			return $settings_defaults[ $option_id ];
		}


		/**
		 * Get core page ID
		 *
		 * @param string $key
		 *
		 * @return mixed|void
		 */
		function get_core_page_id( $key ) {
			/**
			 * MP hook
			 *
			 * @type filter
			 * @title mp_core_page_id_filter
			 * @description Change MP page slug
			 * @input_vars
			 * [{"var":"$slug","type":"array","desc":"MP page slug"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage
			 * <?php add_filter( 'mp_core_page_id_filter', 'function_name', 10, 1 ); ?>
			 * @example
			 * <?php
			 * add_filter( 'mp_core_page_id_filter', 'my_core_page_id', 10, 1 );
			 * function my_core_page_id( $slug ) {
			 *     // your code here
			 *     return $slug;
			 * }
			 * ?>
			 */
			return apply_filters( 'mp_core_page_id_filter', 'core_' . $key );
		}

	}
}