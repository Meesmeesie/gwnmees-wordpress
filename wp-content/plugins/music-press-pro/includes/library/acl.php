<?php
namespace mp;
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;
require_once(ABSPATH . 'wp-admin/includes/screen.php');

if ( ! class_exists( 'mp\ACL' ) ) {


	/**
	 * Class Roles_Capabilities
	 * @package mp\core
	 */
	class ACL {
		var $mp_user_can;

		/**
		 * Roles_Capabilities constructor.
		 */
		function __construct() {
			add_filter( 'parse_query', array($this,'check_current_page') );

		}

		function check_current_page($query) {
			global $pagenow;
			$this->mp_user_can      =   MP()->roles()->get_user_role(get_current_user_id());

			switch ($query->query['post_type']) {
				case 'mp-song':
					break;
			}
		}

	}
}