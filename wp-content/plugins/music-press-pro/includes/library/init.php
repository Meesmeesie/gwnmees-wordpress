<?php if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'MP' ) ) {

	final class MP extends MP_Functions {


		/**
		 * @var MP the single instance of the class
		 */
		protected static $instance = null;


		/**
		 * @var array all plugin's classes
		 */
		public $classes = array();


		/**
		 * @var bool Old variable
		 *
		 * @todo deprecate this variable
		 */
		public $is_filtering;


		/**
		 * WP Native permalinks turned on?
		 *
		 * @var
		 */
		public $is_permalinks;


		/**
		 * MP Available Languages
		 *
		 * @var array
		 */
		var $available_languages;

		/**
		 * Main MP Instance
		 *
		 * Ensures only one instance of MP is loaded or can be loaded.
		 *
		 * @since 1.0
		 * @static
		 * @see MP()
		 * @return MP - Main instance
		 */
		static public function instance() {
			if ( is_null( self::$instance ) ) {
				self::$instance = new self();
				self::$instance->_mp_construct();
			}

			return self::$instance;
		}


		/**
		 * Create plugin classes - not sure if it needs!!!!!!!!!!!!!!!
		 *
		 * @since 1.0
		 * @see MP()
		 *
		 * @param $name
		 * @param array $params
		 * @return mixed
		 */
		public function __call( $name, array $params ) {

			if ( empty( $this->classes[ $name ] ) ) {

				/**
				 * MP hook
				 *
				 * @type filter
				 * @title mp_call_object_{$class_name}
				 * @description Extend call classes of Extensions for use MP()->class_name()->method|function
				 * @input_vars
				 * [{"var":"$class","type":"object","desc":"Class Instance"}]
				 * @change_log
				 * ["Since: 2.0"]
				 * @usage add_filter( 'mp_call_object_{$class_name}', 'function_name', 10, 1 );
				 * @example
				 * <?php
				 * add_filter( 'mp_call_object_{$class_name}', 'my_extension_class', 10, 1 );
				 * function my_extension_class( $class ) {
				 *     // your code here
				 *     return $class;
				 * }
				 * ?>
				 */
				$this->classes[ $name ] = apply_filters( 'mp_call_object_' . $name, false );
			}

			return $this->classes[ $name ];

		}


		/**
		 * Function for add classes to $this->classes
		 * for run using MP()
		 *
		 * @since 2.0
		 *
		 * @param string $class_name
		 * @param bool $instance
		 */
		public function set_class( $class_name, $instance = false ) {
			if ( empty( $this->classes[ $class_name ] ) ) {
				$class = 'MP_' . $class_name;
				$this->classes[ $class_name ] = $instance ? $class::instance() : new $class;
			}
		}


		/**
		 * Cloning is forbidden.
		 * @since 1.0
		 */
		public function __clone() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'music-press-pro' ), '1.0' );
		}


		/**
		 * Unserializing instances of this class is forbidden.
		 * @since 1.0
		 */
		public function __wakeup() {
			_doing_it_wrong( __FUNCTION__, __( 'Cheatin&#8217; huh?', 'music-press-pro' ), '1.0' );
		}


		/**
		 * MP constructor.
		 *
		 * @since 1.0
		 */
		function __construct() {
			parent::__construct();
		}


		/**
		 * MP pseudo-constructor.
		 *
		 * @since 2.0.18
		 */
		function _mp_construct() {
			//register autoloader for include MP classes
			spl_autoload_register( array( $this, 'mp__autoloader' ) );

			if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {

				if ( get_option( 'permalink_structure' ) ) {
					$this->is_permalinks = true;
				}

				$this->is_filtering = 0;
				$this->honeypot = 'request';

				$this->available_languages = array(
					'en_US' => 'English (US)',
					'es_ES' => 'Español',
					'es_MX' => 'Español (México)',
					'fr_FR' => 'Français',
					'it_IT' => 'Italiano',
					'de_DE' => 'Deutsch',
					'nl_NL' => 'Nederlands',
					'pt_BR' => 'Português do Brasil',
					'fi_FI' => 'Suomi',
					'ro_RO' => 'Română',
					'da_DK' => 'Dansk',
					'sv_SE' => 'Svenska',
					'pl_PL' => 'Polski',
					'cs_CZ' => 'Czech',
					'el'    => 'Greek',
					'id_ID' => 'Indonesian',
					'zh_CN' => '简体中文',
					'ru_RU' => 'Русский',
					'tr_TR' => 'Türkçe',
					'fa_IR' => 'Farsi',
					'he_IL' => 'Hebrew',
					'ar'    => 'العربية',
				);

				// textdomain loading
				$this->localize();

				// include MP classes
				$this->includes();

				// call roles
				$this->roles();

				// include hook files
				add_action( 'plugins_loaded', array( &$this, 'init' ), 0 );

				//run activation
				register_activation_hook( MUSIC_PRESS_PRO_PLUGIN_BASENAME, array( &$this, 'activation' ) );

				// init widgets
				add_action( 'widgets_init', array( &$this, 'widgets_init' ) );
			}
		}


		/**
		 * Loading MP textdomain
		 *
		 * 'music-press-pro' by default
		 */
		function localize() {
			$language_locale = ( get_locale() != '' ) ? get_locale() : 'en_US';

			/**
			 * MP hook
			 *
			 * @type filter
			 * @title mp_language_locale
			 * @description Change MP language locale
			 * @input_vars
			 * [{"var":"$locale","type":"string","desc":"MP language locale"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage add_filter( 'mp_language_locale', 'function_name', 10, 1 );
			 * @example
			 * <?php
			 * add_filter( 'mp_language_locale', 'my_language_locale', 10, 1 );
			 * function my_language_locale( $locale ) {
			 *     // your code here
			 *     return $locale;
			 * }
			 * ?>
			 */
			$language_locale = apply_filters( 'mp_language_locale', $language_locale );


			/**
			 * MP hook
			 *
			 * @type filter
			 * @title mp_language_textdomain
			 * @description Change MP textdomain
			 * @input_vars
			 * [{"var":"$domain","type":"string","desc":"MP Textdomain"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage add_filter( 'mp_language_textdomain', 'function_name', 10, 1 );
			 * @example
			 * <?php
			 * add_filter( 'mp_language_textdomain', 'my_textdomain', 10, 1 );
			 * function my_textdomain( $domain ) {
			 *     // your code here
			 *     return $domain;
			 * }
			 * ?>
			 */
			$language_domain = apply_filters( 'mp_language_textdomain', 'music-press-pro' );

			$language_file = WP_LANG_DIR . '/plugins/' . $language_domain . '-' . $language_locale . '.mo';

			/**
			 * MP hook
			 *
			 * @type filter
			 * @title mp_language_file
			 * @description Change MP language file path
			 * @input_vars
			 * [{"var":"$language_file","type":"string","desc":"MP language file path"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage add_filter( 'mp_language_file', 'function_name', 10, 1 );
			 * @example
			 * <?php
			 * add_filter( 'mp_language_file', 'my_language_file', 10, 1 );
			 * function my_language_file( $language_file ) {
			 *     // your code here
			 *     return $language_file;
			 * }
			 * ?>
			 */
			$language_file = apply_filters( 'mp_language_file', $language_file );

			load_textdomain( $language_domain, $language_file );
		}

		/**
		 * Autoload MP classes handler
		 *
		 * @since 2.0
		 *
		 * @param $class
		 */
		function mp__autoloader( $class ) {
			if ( strpos( $class, 'mp' ) === 0 ) {

				$array = explode( '\\', strtolower( $class ) );
				$array[ count( $array ) - 1 ] = end( $array );
				if ( strpos( $class, 'mp_ext' ) === 0 ) {
					$full_path = str_replace( 'music-press-pro', '', rtrim( MUSIC_PRESS_PRO_PLUGIN_DIR.'/', '/' ) ) . str_replace( '_', '-', $array[1] ) . '/includes/';
					unset( $array[0], $array[1] );
					$path = implode( DIRECTORY_SEPARATOR, $array );
					$path = str_replace( '_', '-', $path );
					$full_path .= $path . '.php';
				} else if ( strpos( $class, 'mp\\' ) === 0 ) {
					$class = implode( '\\', $array );
					$slash = DIRECTORY_SEPARATOR;
					$path = str_replace(
						array( 'mp\\', '_', '\\' ),
						array( $slash, '-', $slash ),
						$class );
					$full_path =  MUSIC_PRESS_PRO_PLUGIN_DIR.'/' . 'includes/library' . $path . '.php';
				}

				if( isset( $full_path ) && file_exists( $full_path ) ) {
					require_once $full_path;
				}
			}
		}

		function options() {
			if ( empty( $this->classes['options'] ) ) {
				$this->classes['options'] = new mp\Options();
			}
			return $this->classes['options'];
		}

		function roles() {
			if ( empty( $this->classes['roles'] ) ) {
				$this->classes['roles'] = new mp\Roles();
			}
			return $this->classes['roles'];
		}

		function acl() {
			if ( empty( $this->classes['acl'] ) ) {
				$this->classes['acl'] = new mp\ACL();
			}
			return $this->classes['acl'];
		}

		/**
		 * Include required core files used in admin and on the frontend.
		 *
		 * @since 2.0
		 *
		 * @return void
		 */
		public function includes() {

			if ( $this->is_request( 'ajax' ) ) {

			} elseif ( $this->is_request( 'admin' ) ) {

			} elseif ( $this->is_request( 'frontend' ) ) {

			}
		}

		/**
		 * Include files with hooked filters/actions
		 *
		 * @since 2.0
		 */
		function init() {
		}


		/**
		 * Init MP widgets
		 *
		 * @since 2.0
		 */
		function widgets_init() {

		}

	}
}


/**
 * Function for calling MP methods and variables
 *
 * @since 2.0
 *
 * @return MP
 */
function MP() {
	return MP::instance();
}


// Global for backwards compatibility.
$GLOBALS['musicpresspro'] = MP();