<?php
if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if( ! class_exists( 'WP_List_Table' ) )
	require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );


/**
 * Class MP_Roles_List_Table
 */
class MP_Roles_Model_List_Table extends WP_List_Table {


	/**
	 * @var string
	 */
	var $no_items_message = '';


	/**
	 * @var array
	 */
	var $sortable_columns = array();


	/**
	 * @var string
	 */
	var $default_sorting_field = '';


	/**
	 * @var array
	 */
	var $actions = array();


	/**
	 * @var array
	 */
	var $bulk_actions = array();


	/**
	 * @var array
	 */
	var $columns = array();


	/**
	 * MP_Roles_List_Table constructor.
	 *
	 * @param array $args
	 */
	function __construct( $args = array() ){
		$args = wp_parse_args( $args, array(
			'singular'  => __( 'item', 'music-press-pro' ),
			'plural'    => __( 'items', 'music-press-pro' ),
			'ajax'      => false
		) );

		$this->no_items_message = $args['plural'] . ' ' . __( 'not found.', 'music-press-pro' );

		parent::__construct( $args );
	}


	/**
	 * @param callable $name
	 * @param array $arguments
	 *
	 * @return mixed
	 */
//	function __call( $name, $arguments ) {
//		return call_user_func_array( array( $this, $name ), $arguments );
//	}


	/**
	 *
	 */
	function prepare_items() {
		$columns  = $this->get_columns();
		$hidden   = array();
		$sortable = $this->get_sortable_columns();
		$this->_column_headers = array( $columns, $hidden, $sortable );
	}


	/**
	 * @param object $item
	 * @param string $column_name
	 *
	 * @return string
	 */
	function column_default( $item, $column_name ) {
		if( isset( $item[ $column_name ] ) ) {
			return $item[ $column_name ];
		} else {
			return '';
		}
	}


	/**
	 *
	 */
	function no_items() {
		echo $this->no_items_message;
	}


	/**
	 * @param array $args
	 *
	 * @return $this
	 */
	function set_sortable_columns( $args = array() ) {
		$return_args = array();
		foreach( $args as $k=>$val ) {
			if( is_numeric( $k ) ) {
				$return_args[ $val ] = array( $val, $val == $this->default_sorting_field );
			} else if( is_string( $k ) ) {
				$return_args[ $k ] = array( $val, $k == $this->default_sorting_field );
			} else {
				continue;
			}
		}
		$this->sortable_columns = $return_args;
		return $this;
	}


	/**
	 * @return array
	 */
	function get_sortable_columns() {
		return $this->sortable_columns;
	}


	/**
	 * @param array $args
	 *
	 * @return $this
	 */
	function set_columns( $args = array() ) {
		if( count( $this->bulk_actions ) ) {
			$args = array_merge( array( 'cb' => '<input type="checkbox" />' ), $args );
		}
		$this->columns = $args;
		return $this;
	}


	/**
	 * @return array
	 */
	function get_columns() {
		return $this->columns;
	}


	/**
	 * @param array $args
	 *
	 * @return $this
	 */
	function set_actions( $args = array() ) {
		$this->actions = $args;
		return $this;
	}


	/**
	 * @return array
	 */
	function get_actions() {
		return $this->actions;
	}


	/**
	 * @param array $args
	 *
	 * @return $this
	 */
	function set_bulk_actions( $args = array() ) {
		$this->bulk_actions = $args;
		return $this;
	}


	/**
	 * @return array
	 */
	function get_bulk_actions() {
		return $this->bulk_actions;
	}


	/**
	 * @param object $item
	 *
	 * @return string
	 */
	function column_cb( $item ) {
		return sprintf( '<input type="checkbox" name="item[]" value="%s" />', $item['key'] );
	}


	/**
	 * @param $item
	 *
	 * @return string
	 */
	function column_title( $item ) {
		$actions = array();

		$actions['edit'] = '<a href="admin.php?page=mp_roles&action=edit&id=' . $item['key'] . '">' . __( 'Edit', 'music-press-pro' ). '</a>';

		if ( ! empty( $item['_mp_is_custom'] ) ) {
			$actions['delete'] = '<a href="admin.php?page=mp_roles&action=delete&id=' . $item['key'] . '&_wpnonce=' . wp_create_nonce( 'mp_role_delete' . $item['key'] . get_current_user_id() ) . '" onclick="return confirm( \'' . __( 'Are you sure you want to delete this role?', 'music-press-pro' ) . '\' );">' . __( 'Delete', 'music-press-pro' ). '</a>';
		} else {
			$role_meta = get_option( "mp_role_{$item['key']}_meta" );
			if ( ! empty( $role_meta ) ) {
				if (isset(MP()->classes['roles']->{$item['key'].'_roles'})) {
					$role_meta_default  =   MP()->classes['roles']->{$item['key'].'_roles'};
				} else {
					$role_meta_default  =   MP()->classes['roles']->mp_roles;
				}
				foreach ($role_meta_default as $key => $value) {
					if (!isset($role_meta[$key]) || $role_meta[$key] != $value) {
						$actions['reset'] = '<a href="admin.php?page=mp_roles&action=reset&id=' . $item['key'] . '&_wpnonce=' . wp_create_nonce( 'mp_role_reset' . $item['key'] . get_current_user_id() ) . '" onclick="return confirm( \'' . __( 'Are you sure you want to reset MP role meta?', 'music-press-pro' ) . '\' );">' . __( 'Reset default role settings', 'music-press-pro' ). '</a>';
						break;
					}
				}
			}
		}



		return sprintf('%1$s %2$s', '<strong><a class="row-title" href="admin.php?page=mp_roles&action=edit&id=' . $item['key'] . '">' . $item['name'] . '</a></strong>', $this->row_actions( $actions ) );
	}


	/**
	 * @param $item
	 *
	 * @return string
	 */
	function column_roleid( $item ) {
		return ! empty( $item['_mp_is_custom'] ) ? 'mp_' . $item['key'] : $item['key'];
	}


	/**
	 * @param $item
	 */
	function column_core( $item ) {
		echo ! empty( $item['_mp_is_custom'] ) ? __( 'Yes', 'music-press-pro' ) : __( 'No', 'music-press-pro' );
	}


	/**
	 * @param $item
	 */
	function column_admin_access( $item ) {
		echo ! empty( $item['_mp_can_access_wpadmin'] ) ? __( 'Yes', 'music-press-pro' ) : __( 'No', 'music-press-pro' );
	}


	/**
	 * @param $item
	 */
	function column_priority( $item ) {
		echo ! empty( $item['_mp_priority'] ) ? $item['_mp_priority'] : '-';
	}


	/**
	 * @param array $attr
	 */
	function mp_set_pagination_args( $attr = array() ) {
		$this->set_pagination_args( $attr );
	}
}