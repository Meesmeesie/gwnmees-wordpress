<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class MP_ACL_Controller extends mp\mvc\MP_Controller {
    var $list_table =   null;
    var $data_edit  =   array();
    function __construct() {
	    parent::__construct();
	    if ( empty( $_GET['action'] ) ) {
		    $this->getListTable();
		    $this->display();
	    } elseif ( $_GET['action'] == 'add' || $_GET['action'] == 'edit' ) {
		    $this->acl_edit();
		    $this->display('edit');
	    } else {
		    if ( isset( $_GET['action'] ) ) {
			    switch ( $_GET['action'] ) {
				    /* delete action */
				    case 'delete': {
					    $this->delete();
					    break;
				    }
				    case 'reset': {
					    $this->reset();
					    break;
				    }
			    }
		    } else {
			    mp_js_redirect( get_admin_url(). 'admin.php?page=mp_roles' );
		    }

	    }
    }

    public function getListTable () {
	    global $wp_roles;
	    if ( isset( $_REQUEST['_wp_http_referer'] ) ) {
		    $redirect = remove_query_arg(array('_wp_http_referer' ), wp_unslash( $_REQUEST['_wp_http_referer'] ) );
	    } else {
		    $redirect = get_admin_url(). 'admin.php?page=mp_roles';
	    }

	    //remove extra query arg
	    if ( ! empty( $_GET['_wp_http_referer'] ) )
		    mp_js_redirect( remove_query_arg( array( '_wp_http_referer', '_wpnonce'), wp_unslash( $_SERVER['REQUEST_URI'] ) ) );

	    $order_by = 'name';
	    $order = ( isset( $_GET['order'] ) && 'asc' ==  strtolower( $_GET['order'] ) ) ? 'ASC' : 'DESC';

	    require_once MUSIC_PRESS_PRO_PLUGIN_DIR . '/includes/admin/models/acl/mp_roles_list_table.php';
	    $this->list_table = new MP_Roles_Model_List_Table( array(
		    'singular'  => __( 'Role', 'music-press-pro' ),
		    'plural'    => __( 'Roles', 'music-press-pro' ),
		    'ajax'      => false
	    ));

	    $per_page   = 20;
	    $paged      = $this->list_table->get_pagenum();

	    $this->list_table->set_bulk_actions( array(
		    'delete' => __( 'Delete', 'music-press-pro' )
	    ) );

	    $this->list_table->set_columns( array(
		    'title'         => __( 'Role Title', 'music-press-pro' ),
		    'roleid'        => __( 'Role ID', 'music-press-pro' ),
		    'users'         => __( 'No.of Members', 'music-press-pro' )
	    ) );

	    $this->list_table->set_sortable_columns( array(
		    'title' => 'title'
	    ) );

	    $users_count = count_users();

	    $roles = array();
	    $role_keys = get_option( 'mp_roles' );

	    if ( $role_keys ) {
		    foreach ( $role_keys as $role_key ) {
			    $role_meta = get_option( "mp_role_{$role_key}_meta" );
			    if ( $role_meta ) {

				    $roles['mp_' . $role_key] = array(
					    'key'   => $role_key,
					    'users' => ! empty( $users_count['avail_roles']['mp_' . $role_key] ) ? $users_count['avail_roles']['mp_' . $role_key] : 0
				    );
				    $roles['mp_' . $role_key] = array_merge( $roles['mp_' . $role_key], $role_meta );
			    }
		    }
	    }

	    foreach ( $wp_roles->roles as $roleID => $role_data ) {
		    if ( in_array( $roleID, array_keys( $roles ) ) )
			    continue;

		    $roles[$roleID] = array(
			    'key'   => $roleID,
			    'users' => ! empty( $users_count['avail_roles'][$roleID] ) ? $users_count['avail_roles'][$roleID] : 0,
			    'name' => $role_data['name']
		    );

		    $role_meta = get_option( "mp_role_{$roleID}_meta" );
		    if ( $role_meta )
			    $roles[$roleID] = array_merge( $roles[$roleID], $role_meta );
	    }

	    switch( strtolower( $order ) ) {
		    case 'asc':
			    uasort( $roles, function( $a, $b ) {
				    return strnatcmp( $a['name'], $b['name'] );
			    } );
			    break;
		    case 'desc':
			    uasort( $roles, function( $a, $b ) {
				    return strnatcmp( $a['name'], $b['name'] ) * -1;
			    } );
			    break;
	    }

	    $this->list_table->prepare_items();
	    $this->list_table->items = array_slice( $roles, ( $paged - 1 ) * $per_page, $per_page );
	    $this->list_table->mp_set_pagination_args( array( 'total_items' => count( $roles ), 'per_page' => $per_page ) );
    }

    public function acl_edit() {
	    wp_enqueue_script( 'postbox' );
	    wp_enqueue_media();

	    /**
	     * MP hook
	     *
	     * @type action
	     * @title mp_roles_add_meta_boxes
	     * @description Add meta boxes on add/edit MP Role
	     * @input_vars
	     * [{"var":"$meta","type":"string","desc":"Meta Box Key"}]
	     * @change_log
	     * ["Since: 2.0"]
	     * @usage add_action( 'mp_roles_add_meta_boxes', 'function_name', 10, 1 );
	     * @example
	     * <?php
	     * add_action( 'mp_roles_add_meta_boxes', 'my_roles_add_meta_boxes', 10, 1 );
	     * function my_roles_add_meta_boxes( $meta ) {
	     *     // your code here
	     * }
	     * ?>
	     */
	    require_once MUSIC_PRESS_PRO_PLUGIN_DIR . '/includes/admin/models/acl/acl_edit.php';
	    $this->data_edit['form']        =   new acl_edit();
	    $this->data_edit['form']->roles =   MP()->roles();
	    $this->data_edit['form']->add_metabox_role();
	    do_action( 'mp_roles_add_meta_boxes', 'mp_role_meta' );

	    $data = array();
	    $option = array();
	    global $wp_roles;

	    if ( ! empty( $_GET['id'] ) ) {
		    $data = get_option( "mp_role_{$_GET['id']}_meta" );
		    if ( empty( $data['_mp_is_custom'] ) )
			    $data['name'] = $wp_roles->roles[ $_GET['id'] ]['name'];
	    }


	    if ( ! empty( $_POST['role'] ) ) {

		    $data = $_POST['role'];

		    // Song data
			$data['edit_song'] = $data['read_song'] = $data['edit_songs'];
			$data['delete_song'] = $data['delete_songs'];

		    // genre data
		    $data['edit_genre'] = $data['read_genre'] = $data['edit_genres'];
		    $data['delete_genre'] = $data['delete_genres'];

		    // album data
		    $data['edit_album'] = $data['read_album'] = $data['edit_albums'];
		    $data['delete_album'] = $data['delete_albums'];

		    // band data
		    $data['edit_band'] = $data['read_band'] = $data['edit_bands'];
		    $data['delete_band'] = $data['delete_bands'];

		    // artist data
		    $data['edit_artist'] = $data['read_artist'] = $data['edit_artists'];
		    $data['delete_artist'] = $data['delete_artists'];

		    $id = '';
		    $redirect = '';
		    $error = '';

		    if ( empty( $data['name'] ) ) {

			    $error .= __( 'Title is empty!', 'music-press-pro' ) . '<br />';

		    } else {

			    if ( 'edit' == $_GET['action'] && ! empty( $_GET['id'] ) ) {
				    $id = $_GET['id'];
				    $redirect = add_query_arg( array( 'page' => 'mp_roles', 'action'=>'edit', 'id'=>$id, 'msg'=>'u' ), admin_url( 'admin.php' ) );
			    }

		    }

		    $all_roles = array_keys( get_editable_roles() );
		    if ( 'add' == $_GET['action'] ) {
			    if ( in_array( 'mp_' . $id, $all_roles ) || in_array( $id, $all_roles ) )
				    $error .= __( 'Role already exists!', 'music-press-pro' ) . '<br />';
		    }

		    if ( '' == $error ) {

			    if ( 'add' == $_GET['action'] ) {
				    $roles = get_option( 'mp_roles' );
				    $roles[] = $id;

				    update_option( 'mp_roles', $roles );
			    }

			    $role_meta = $data;
			    unset( $role_meta['id'] );
			    update_option( "mp_role_{$id}_meta", $role_meta );
			    MP()->classes['roles']->set_roles($id);

			    mp_js_redirect( $redirect );
		    }
	    }

	    global $current_screen;
	    $this->data_edit['screen_id']   =   $current_screen->id;
	    $this->data_edit['data']        =   $data;
	    $this->data_edit['option']      =   $option;

    }

	public function delete() {
		if ( isset( $_REQUEST['_wp_http_referer'] ) ) {
			$redirect = remove_query_arg(array('_wp_http_referer' ), wp_unslash( $_REQUEST['_wp_http_referer'] ) );
		} else {
			$redirect = get_admin_url(). 'admin.php?page=mp_roles';
		}
		$role_keys = array();
		if ( isset( $_REQUEST['id'] ) ) {
			check_admin_referer( 'mp_role_delete' .  $_REQUEST['id'] . get_current_user_id() );
			$role_keys = (array)$_REQUEST['id'];
		} elseif( isset( $_REQUEST['item'] ) )  {
			check_admin_referer( 'bulk-' . sanitize_key( __( 'Roles', 'music-press-pro' ) ) );
			$role_keys = $_REQUEST['item'];
		}

		if ( ! count( $role_keys ) )
			mp_js_redirect( $redirect );

		$mp_roles = get_option( 'mp_roles' );

		$mp_custom_roles = array();
		foreach ( $role_keys as $k => $role_key ) {
			$role_meta = get_option( "mp_role_{$role_key}_meta" );

			if ( empty( $role_meta['_mp_is_custom'] ) ) {
				continue;
			}

			delete_option( "mp_role_{$role_key}_meta" );
			$mp_roles = array_diff( $mp_roles, array( $role_key ) );

			$roleID = 'mp_' . $role_key;
			$mp_custom_roles[] = $roleID;

			//check if role exist before removing it
			if ( get_role( $roleID ) ) {
				remove_role( $roleID );
			}
		}

		//set for users with deleted roles role "Subscriber"
		$args = array(
			'blog_id'      => get_current_blog_id(),
			'role__in'     => $mp_custom_roles,
			'number'       => -1,
			'count_total'  => false,
			'fields'       => 'ids',
		);
		$users_to_subscriber = get_users( $args );
		if ( ! empty( $users_to_subscriber ) ) {
			foreach ( $users_to_subscriber as $user_id ) {
				$object_user = get_userdata( $user_id );

				if ( ! empty( $object_user ) ) {
					foreach ( $mp_custom_roles as $roleID ) {
						$object_user->remove_role( $roleID );
					}
				}

				//update user role if it's empty
				if ( empty( $object_user->roles ) )
					wp_update_user( array( 'ID' => $user_id, 'role' => 'subscriber' ) );
			}
		}

		update_option( 'mp_roles', $mp_roles );

		mp_js_redirect( add_query_arg( 'msg', 'd', $redirect ) );
	}
	public function reset() {
		if ( isset( $_REQUEST['_wp_http_referer'] ) ) {
			$redirect = remove_query_arg(array('_wp_http_referer' ), wp_unslash( $_REQUEST['_wp_http_referer'] ) );
		} else {
			$redirect = get_admin_url(). 'admin.php?page=mp_roles';
		}
		$role_keys = array();
		if ( isset( $_REQUEST['id'] ) ) {
			check_admin_referer( 'mp_role_reset' .  $_REQUEST['id'] . get_current_user_id() );
			$role_keys = (array)$_REQUEST['id'];
		} elseif( isset( $_REQUEST['item'] ) )  {
			check_admin_referer( 'bulk-' . sanitize_key( __( 'Roles', 'music-press-pro' ) ) );
			$role_keys = $_REQUEST['item'];
		}
		if ( ! count( $role_keys ) )
			mp_js_redirect( $redirect );

		foreach ( $role_keys as $k=>$role_key ) {
			MP()->classes['roles']->reset_default_role($role_key);
		}

		mp_js_redirect( add_query_arg( 'msg', 'reset', $redirect ) );
	}
}