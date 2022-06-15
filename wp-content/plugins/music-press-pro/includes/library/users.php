<?php
namespace mp;

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'mp\Users' ) ) {


	/**
	 * Class User
	 * @package mp\Users
	 */
	class Users {


		/**
		 * User constructor.
		 */
		function __construct() {

			$this->id = 0;
			$this->usermeta = null;
			$this->data = null;
			$this->profile = null;
			$this->cannot_edit = null;
			$this->tabs = null;

			// a list of keys that should never be in wp_usermeta
			$this->update_user_keys = array(
				'user_email',
				'user_pass',
				'user_password',
				'display_name',
				'user_url',
				'role',
			);

			$this->target_id = null;

			add_action( 'show_user_profile', array( $this, 'profile_form_additional_section' ), 10 );
		}

		/**
		 * Additional section for WP Profile page with UM data fields
		 *
		 * @param \WP_User $userdata User data
		 * @return void
		 */
		function profile_form_additional_section( $userdata ) {

			/**
			 * MP hook
			 *
			 * @type filter
			 * @title mp_user_profile_additional_fields
			 * @description Make additional content section
			 * @input_vars
			 * [{"var":"$content","type":"array","desc":"Additional section content"},
			 * {"var":"$userdata","type":"array","desc":"Userdata"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage
			 * <?php add_filter( 'mp_user_profile_additional_fields', 'function_name', 10, 2 ); ?>
			 * @example
			 * <?php
			 * add_filter( 'mp_user_profile_additional_fields', 'my_admin_pending_queue', 10, 2 );
			 * function my_admin_pending_queue( $content, $userdata ) {
			 *     // your code here
			 *     return $content;
			 * }
			 * ?>
			 */
			$section_content = apply_filters( 'mp_user_profile_additional_fields', '', $userdata );

			if ( ! empty( $section_content ) && ! ( is_multisite() && is_network_admin() ) ) {
				if ( $userdata !== 'add-new-user' && $userdata !== 'add-existing-user' ) { ?>
                    <h2><?php esc_html_e( 'Music Press Pro', 'music-press-pro' ); ?></h2>
				<?php }

				echo $section_content;
			}
		}
	}
}