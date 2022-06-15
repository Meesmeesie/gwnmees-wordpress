<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class acl_edit extends mp\form\Admin_Forms {

	var $roles      =   null;
	/**
	 * Add role metabox
	 */
	function add_metabox_role() {
		add_filter( 'mp_admin_role_metaboxes', array($this, 'core_role_metaboxes'));
	}

	function core_role_metaboxes($roles_metaboxes) {

		$callback = array( &$this, 'load_metabox_role' );
		$roles_metaboxes = array_merge( $roles_metaboxes,  array(
			array(
				'id'        => 'mp-admin-form-composer',
				'title'     => __( 'Composer', 'music-press-pro' ),
				'callback'  => $callback,
				'screen'    => 'mp_role_meta',
				'context'   => 'normal',
				'priority'  => 'default'
			),
			array(
				'id'        => 'mp-admin-form-edit',
				'title'     => __( 'Editing', 'music-press-pro' ),
				'callback'  => $callback,
				'screen'    => 'mp_role_meta',
				'context'   => 'normal',
				'priority'  => 'default'
			),
			array(
				'id'        => 'mp-admin-form-delete',
				'title'     => __( 'Delete', 'music-press-pro' ),
				'callback'  => $callback,
				'screen'    => 'mp_role_meta',
				'context'   => 'normal',
				'priority'  => 'default'
			),
			array(
				'id'        => 'mp-admin-form-private',
				'title'     => __( 'Private', 'music-press-pro' ),
				'callback'  => $callback,
				'screen'    => 'mp_role_meta',
				'context'   => 'normal',
				'priority'  => 'default'
			),
			array(
				'id'        => 'mp-admin-form-subscriptions',
				'title'     => __( 'Subscriptions', 'music-press-pro' ),
				'callback'  => $callback,
				'screen'    => 'mp_role_meta',
				'context'   => 'normal',
				'priority'  => 'default'
			)
		));

		return $roles_metaboxes;
	}

	/**
	 * Load a role metabox
	 *
	 * @param $object
	 * @param $box
	 */
	function load_metabox_role( $object, $box ) {
		global $post;

		$box['id'] = str_replace( 'mp-admin-form-', '', $box['id'] );

		preg_match('#\{.*?\}#s', $box['id'], $matches);

		if ( isset($matches[0]) ){
			$path = $matches[0];
			$box['id'] = preg_replace('~(\\{[^}]+\\})~','', $box['id'] );
		} else {
			$path = MUSIC_PRESS_PRO_PLUGIN_DIR.'/';
		}

		$path = str_replace('{','', $path );
		$path = str_replace('}','', $path );

		include_once $path . 'includes/admin/templates/acl/'. $box['id'] . '.php';
		//wp_nonce_field( basename( __FILE__ ), 'mp_admin_save_metabox_role_nonce' );
	}
}