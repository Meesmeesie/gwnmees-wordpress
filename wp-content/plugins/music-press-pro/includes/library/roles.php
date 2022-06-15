<?php
namespace mp;
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;


if ( ! class_exists( 'mp\Roles' ) ) {


	/**
	 * Class Roles_Capabilities
	 * @package mp\core
	 */
	class Roles {
		var $mp_roles   =   array(
			'edit_song' => 0,
			'edit_songs' => 0,
			'edit_others_songs' => 0,
			'read_song' => 0,
			'delete_song' => 0,
			'publish_songs' => 0,
			'read_private_songs' => 0,
			'delete_songs' => 0,
			'delete_private_songs' => 0,
			'delete_published_songs' => 0,
			'delete_others_songs' => 0,
			'edit_private_songs' => 0,
			'edit_published_songs' => 0,

			'edit_genre' => 0,
			'edit_genres' => 0,
			'edit_others_genres' => 0,
			'read_genre' => 0,
			'delete_genre' => 0,
			'publish_genres' => 0,
			'read_private_genres' => 0,
			'delete_genres' => 0,
			'delete_private_genres' => 0,
			'delete_published_genres' => 0,
			'delete_others_genres' => 0,
			'edit_private_genres' => 0,
			'edit_published_genres' => 0,

			'edit_album' => 0,
			'edit_albums' => 0,
			'edit_others_albums' => 0,
			'read_album' => 0,
			'delete_album' => 0,
			'publish_albums' => 0,
			'read_private_albums' => 0,
			'delete_albums' => 0,
			'delete_private_albums' => 0,
			'delete_published_albums' => 0,
			'delete_others_albums' => 0,
			'edit_private_albums' => 0,
			'edit_published_albums' => 0,

			'edit_band' => 0,
			'edit_bands' => 0,
			'edit_others_bands' => 0,
			'read_band' => 0,
			'delete_band' => 0,
			'publish_bands' => 0,
			'read_private_bands' => 0,
			'delete_bands' => 0,
			'delete_private_bands' => 0,
			'delete_published_bands' => 0,
			'delete_others_bands' => 0,
			'edit_private_bands' => 0,
			'edit_published_bands' => 0,

			'edit_artist' => 0,
			'edit_artists' => 0,
			'edit_others_artists' => 0,
			'read_artist' => 0,
			'delete_artist' => 0,
			'publish_artists' => 0,
			'read_private_artists' => 0,
			'delete_artists' => 0,
			'delete_private_artists' => 0,
			'delete_published_artists' => 0,
			'delete_others_artists' => 0,
			'edit_private_artists' => 0,
			'edit_published_artists' => 0
		);

		var $administrator_roles   =   array(
			'edit_song' => 1,
			'edit_songs' => 1,
			'edit_others_songs' => 1,
			'read_song' => 1,
			'delete_song' => 1,
			'publish_songs' => 1,
			'read_private_songs' => 1,
			'delete_songs' => 1,
			'delete_private_songs' => 1,
			'delete_published_songs' => 1,
			'delete_others_songs' => 1,
			'edit_private_songs' => 1,
			'edit_published_songs' => 1,

			'edit_genre' => 1,
			'edit_genres' => 1,
			'edit_others_genres' => 1,
			'read_genre' => 1,
			'delete_genre' => 1,
			'publish_genres' => 1,
			'read_private_genres' => 1,
			'delete_genres' => 1,
			'delete_private_genres' => 1,
			'delete_published_genres' => 1,
			'delete_others_genres' => 1,
			'edit_private_genres' => 1,
			'edit_published_genres' => 1,

			'edit_album' => 1,
			'edit_albums' => 1,
			'edit_others_albums' => 1,
			'read_album' => 1,
			'delete_album' => 1,
			'publish_albums' => 1,
			'read_private_albums' => 1,
			'delete_albums' => 1,
			'delete_private_albums' => 1,
			'delete_published_albums' => 1,
			'delete_others_albums' => 1,
			'edit_private_albums' => 1,
			'edit_published_albums' => 1,

			'edit_band' => 1,
			'edit_bands' => 1,
			'edit_others_bands' => 1,
			'read_band' => 1,
			'delete_band' => 1,
			'publish_bands' => 1,
			'read_private_bands' => 1,
			'delete_bands' => 1,
			'delete_private_bands' => 1,
			'delete_published_bands' => 1,
			'delete_others_bands' => 1,
			'edit_private_bands' => 1,
			'edit_published_bands' => 1,

			'edit_artist' => 1,
			'edit_artists' => 1,
			'edit_others_artists' => 1,
			'read_artist' => 1,
			'delete_artist' => 1,
			'publish_artists' => 1,
			'read_private_artists' => 1,
			'delete_artists' => 1,
			'delete_private_artists' => 1,
			'delete_published_artists' => 1,
			'delete_others_artists' => 1,
			'edit_private_artists' => 1,
			'edit_published_artists' => 1
		);

		var $editor_roles   =   array(
			'edit_song' => 1,
			'edit_songs' => 1,
			'edit_others_songs' => 1,
			'read_song' => 1,
			'delete_song' => 1,
			'publish_songs' => 1,
			'read_private_songs' => 1,
			'delete_songs' => 1,
			'delete_private_songs' => 1,
			'delete_published_songs' => 1,
			'delete_others_songs' => 1,
			'edit_private_songs' => 1,
			'edit_published_songs' => 1,

			'edit_genre' => 1,
			'edit_genres' => 1,
			'edit_others_genres' => 1,
			'read_genre' => 1,
			'delete_genre' => 1,
			'publish_genres' => 1,
			'read_private_genres' => 1,
			'delete_genres' => 1,
			'delete_private_genres' => 1,
			'delete_published_genres' => 1,
			'delete_others_genres' => 1,
			'edit_private_genres' => 1,
			'edit_published_genres' => 1,

			'edit_album' => 1,
			'edit_albums' => 1,
			'edit_others_albums' => 1,
			'read_album' => 1,
			'delete_album' => 1,
			'publish_albums' => 1,
			'read_private_albums' => 1,
			'delete_albums' => 1,
			'delete_private_albums' => 1,
			'delete_published_albums' => 1,
			'delete_others_albums' => 1,
			'edit_private_albums' => 1,
			'edit_published_albums' => 1,

			'edit_band' => 1,
			'edit_bands' => 1,
			'edit_others_bands' => 1,
			'read_band' => 1,
			'delete_band' => 1,
			'publish_bands' => 1,
			'read_private_bands' => 1,
			'delete_bands' => 1,
			'delete_private_bands' => 1,
			'delete_published_bands' => 1,
			'delete_others_bands' => 1,
			'edit_private_bands' => 1,
			'edit_published_bands' => 1,

			'edit_artist' => 1,
			'edit_artists' => 1,
			'edit_others_artists' => 1,
			'read_artist' => 1,
			'delete_artist' => 1,
			'publish_artists' => 1,
			'read_private_artists' => 1,
			'delete_artists' => 1,
			'delete_private_artists' => 1,
			'delete_published_artists' => 1,
			'delete_others_artists' => 1,
			'edit_private_artists' => 1,
			'edit_published_artists' => 1
		);

		var $author_roles   =   array(
			'edit_song' => 1,
			'edit_songs' => 1,
			'edit_others_songs' => 0,
			'read_song' => 1,
			'delete_song' => 1,
			'publish_songs' => 1,
			'read_private_songs' => 0,
			'delete_songs' => 1,
			'delete_private_songs' => 0,
			'delete_published_songs' => 1,
			'delete_others_songs' => 0,
			'edit_private_songs' => 0,
			'edit_published_songs' => 1,

			'edit_genre' => 1,
			'edit_genres' => 1,
			'edit_others_genres' => 0,
			'read_genre' => 1,
			'delete_genre' => 1,
			'publish_genres' => 1,
			'read_private_genres' => 0,
			'delete_genres' => 1,
			'delete_private_genres' => 0,
			'delete_published_genres' => 1,
			'delete_others_genres' => 0,
			'edit_private_genres' => 0,
			'edit_published_genres' => 1,

			'edit_album' => 1,
			'edit_albums' => 1,
			'edit_others_albums' => 0,
			'read_album' => 1,
			'delete_album' => 1,
			'publish_albums' => 1,
			'read_private_albums' => 0,
			'delete_albums' => 1,
			'delete_private_albums' => 0,
			'delete_published_albums' => 1,
			'delete_others_albums' => 0,
			'edit_private_albums' => 0,
			'edit_published_albums' => 1,

			'edit_band' => 1,
			'edit_bands' => 1,
			'edit_others_bands' => 0,
			'read_band' => 1,
			'delete_band' => 1,
			'publish_bands' => 1,
			'read_private_bands' => 0,
			'delete_bands' => 1,
			'delete_private_bands' => 0,
			'delete_published_bands' => 1,
			'delete_others_bands' => 0,
			'edit_private_bands' => 0,
			'edit_published_bands' => 1,

			'edit_artist' => 1,
			'edit_artists' => 1,
			'edit_others_artists' => 0,
			'read_artist' => 1,
			'delete_artist' => 1,
			'publish_artists' => 1,
			'read_private_artists' => 0,
			'delete_artists' => 1,
			'delete_private_artists' => 0,
			'delete_published_artists' => 1,
			'delete_others_artists' => 0,
			'edit_private_artists' => 0,
			'edit_published_artists' => 1
		);

		var $contributor_roles   =   array(
			'edit_song' => 1,
			'edit_songs' => 1,
			'edit_others_songs' => 0,
			'read_song' => 1,
			'delete_song' => 0,
			'publish_songs' => 0,
			'read_private_songs' => 0,
			'delete_songs' => 0,
			'delete_private_songs' => 0,
			'delete_published_songs' => 0,
			'delete_others_songs' => 0,
			'edit_private_songs' => 0,
			'edit_published_songs' => 0,

			'edit_genre' => 1,
			'edit_genres' => 1,
			'edit_others_genres' => 0,
			'read_genre' => 1,
			'delete_genre' => 0,
			'publish_genres' => 0,
			'read_private_genres' => 0,
			'delete_genres' => 0,
			'delete_private_genres' => 0,
			'delete_published_genres' => 0,
			'delete_others_genres' => 0,
			'edit_private_genres' => 0,
			'edit_published_genres' => 0,

			'edit_album' => 1,
			'edit_albums' => 1,
			'edit_others_albums' => 0,
			'read_album' => 1,
			'delete_album' => 0,
			'publish_albums' => 0,
			'read_private_albums' => 0,
			'delete_albums' => 0,
			'delete_private_albums' => 0,
			'delete_published_albums' => 0,
			'delete_others_albums' => 0,
			'edit_private_albums' => 0,
			'edit_published_albums' => 0,

			'edit_band' => 1,
			'edit_bands' => 1,
			'edit_others_bands' => 0,
			'read_band' => 1,
			'delete_band' => 0,
			'publish_bands' => 0,
			'read_private_bands' => 0,
			'delete_bands' => 0,
			'delete_private_bands' => 0,
			'delete_published_bands' => 0,
			'delete_others_bands' => 0,
			'edit_private_bands' => 0,
			'edit_published_bands' => 0,

			'edit_artist' => 1,
			'edit_artists' => 1,
			'edit_others_artists' => 0,
			'read_artist' => 1,
			'delete_artist' => 0,
			'publish_artists' => 0,
			'read_private_artists' => 0,
			'delete_artists' => 0,
			'delete_private_artists' => 0,
			'delete_published_artists' => 0,
			'delete_others_artists' => 0,
			'edit_private_artists' => 0,
			'edit_published_artists' => 0
		);

		/**
		 * Roles_Capabilities constructor.
		 */
		function __construct() {
			// include hook files
			add_action( 'wp_roles_init', array( &$this, 'mp_roles_init' ), 0 );
		}

		/**
		 * Loop through dynamic roles and add them to the $wp_roles array
		 *
		 * @param null|object $wp_roles
		 * @return null
		 */
		function mp_roles_init( $wp_roles = null ) {
			//Add MP role data to WP Roles
//			var_dump($wp_roles->roles); die();
			foreach ( $wp_roles->roles as $roleID => $role_data ) {
				$role_meta = get_option( "mp_role_{$roleID}_meta" );
				if ( empty( $role_meta ) ) {
					if (isset($this->{$roleID.'_roles'})) {
						$meta_data = array_merge(array('name'=>$role_data['name']), $this->{$roleID.'_roles'});
					} else {
						$meta_data = array_merge(array('name'=>$role_data['name']), $this->mp_roles);
					}
					update_option( "mp_role_{$roleID}_meta", $meta_data );
					unset($meta_data['name']);
					foreach ($meta_data as $key => $meta) {
						if ($meta) {
							$wp_roles->add_cap($roleID,$key);
						} else {
							$wp_roles->remove_cap($roleID,$key);
						}
					}
				}
			}

			return $wp_roles;
		}


		/**
		 * Check if role is custom
		 *
		 * @param $role
		 * @return bool
		 */
		function is_role_custom( $role ) {
			// User has roles so look for a MP Role one
			$role_keys = get_option( 'mp_roles' );

			if ( empty( $role_keys ) )
				return false;

			$role_keys = array_map( function( $item ) {
				return 'mp_' . $item;
			}, $role_keys );

			return in_array( $role, $role_keys );
		}

		/**
		 * Remove user role
		 *
		 * @param $user_id
		 * @param $role
		 */
		function remove_role( $user_id, $role ) {
			// Validate user id
			$user = get_userdata( $user_id );

			// User exists
			if ( ! empty( $user ) ) {
				// Remove role
				$user->remove_role( $role );
			}
		}

		/**
		 * Remove user role
		 *
		 * @param $user_id
		 * @param $role
		 */
		function set_role_wp( $user_id, $role ) {
			// Validate user id
			$user = get_userdata( $user_id );

			// User exists
			if ( ! empty( $user ) ) {
				// Remove role
				$user->add_role( $role );
			}
		}

		/**
		 * Set roles for groups
		 * make user only with $roles roles
		 *
		 * @param int $user_id
		 * @param string|array $roles
		 */
		function set_roles( $roleID ) {
			global $wp_roles;
			$role_meta = get_option( "mp_role_{$roleID}_meta" );
			if ( ! empty( $role_meta ) ) {
				unset($role_meta['name']);
				foreach ($role_meta as $key => $meta) {
					if ($meta) {
						$wp_roles->add_cap($roleID,$key);
					} else {
						$wp_roles->remove_cap($roleID,$key);
					}
				}
			}
		}

		/**
		 * Reset role by id to default.
		 * @param $roleid
		 */
		function reset_default_role($roleID) {
			global $wp_roles;
			$role_data = get_option( "mp_role_{$roleID}_meta" );
			if (!empty($role_data)) {
				if (isset($this->{$roleID.'_roles'})) {
					$meta_data = array_merge(array('name'=>$role_data['name']), $this->{$roleID.'_roles'});
				} else {
					$meta_data = array_merge(array('name'=>$role_data['name']), $this->mp_roles);
				}
				update_option( "mp_role_{$roleID}_meta", $meta_data );
				unset($meta_data['name']);
				foreach ($meta_data as $key => $meta) {
					if ($meta) {
						$wp_roles->add_cap($roleID,$key);
					} else {
						$wp_roles->remove_cap($roleID,$key);
					}
				}
			}
		}

		/**
		 * Get user one of MP roles if it has it
		 *
		 * @deprecated since 2.0
		 * @param int $user_id
		 * @return bool|mixed
		 */
		function mp_get_user_role( $user_id ) {
			return $this->get_mp_user_role( $user_id );
		}


		/**
		 * @param $user_id
		 *
		 * @return array|bool
		 */
		function get_all_user_roles( $user_id ) {
			$user = get_userdata( $user_id );

			if ( empty( $user->roles ) ) {
				return false;
			}

			return array_values( $user->roles );
		}


		/**
		 * @param $user_id
		 *
		 * @return bool|mixed
		 */
		function get_user_role( $user_id ) {
			$user = get_userdata( $user_id );

			if ( empty( $user->roles ) )
				return false;

			$roles = array();
			foreach ( array_values( $user->roles ) as $userrole ) {

				$rolemeta = get_option( "mp_role_{$userrole}_meta", false );

				if ( $rolemeta ) {
					$roles[ $userrole ] = $rolemeta;
				}
			}

			return $roles ;
		}


		/**
		 * @param $user_id
		 *
		 * @return bool|mixed
		 */
		function get_priority_user_role( $user_id ) {
			$user = get_userdata( $user_id );

			if ( empty( $user->roles ) )
				return false;

			// User has roles so look for a MP Role one
			$mp_roles_keys = get_option( 'mp_roles' );

			if ( ! empty( $mp_roles_keys ) ) {
				$mp_roles_keys = array_map( function( $item ) {
					return 'mp_' . $item;
				}, $mp_roles_keys );
			}

			$orders = array();
			foreach ( array_values( $user->roles ) as $userrole ) {
				if ( ! empty( $mp_roles_keys ) && in_array( $userrole, $mp_roles_keys ) ) {
					$userrole_metakey = substr( $userrole, 3 );
				} else {
					$userrole_metakey = $userrole;
				}

				$rolemeta = get_option( "mp_role_{$userrole_metakey}_meta", false );

				if ( ! $rolemeta ) {
					$orders[ $userrole ] = 0;
					continue;
				}

				$orders[ $userrole ] = ! empty( $rolemeta['_mp_priority'] ) ? $rolemeta['_mp_priority'] : 0;
			}

			arsort( $orders );
			$roles_in_priority = array_keys( $orders );

			return array_shift( $roles_in_priority );
		}


		/**
		 * Get editable MP user roles
		 *
		 * @return array
		 */
		function get_editable_user_roles() {
			$default_roles = array( 'subscriber' );

			// User has roles so look for a MP Role one
			$mp_roles_keys = get_option( 'mp_roles', array() );

			if ( ! empty( $mp_roles_keys ) && is_array( $mp_roles_keys ) ) {
				$mp_roles_keys = array_map( function( $item ) {
					return 'mp_' . $item;
				}, $mp_roles_keys );

				return array_merge( $mp_roles_keys, $default_roles );
			}

			return $default_roles;
		}


		/**
		 * @param $user_id
		 *
		 * @return bool|mixed
		 */
		function get_editable_priority_user_role( $user_id ) {
			$user = get_userdata( $user_id );
			if ( empty( $user->roles ) )
				return false;

			// User has roles so look for a MP Role one
			$mp_roles_keys = get_option( 'mp_roles' );

			if ( ! empty( $mp_roles_keys ) ) {
				$mp_roles_keys = array_map( function( $item ) {
					return 'mp_' . $item;
				}, $mp_roles_keys );

			}

			$orders = array();
			foreach ( array_values( $user->roles ) as $userrole ) {
				if ( ! empty( $mp_roles_keys ) && in_array( $userrole, $mp_roles_keys ) ) {
					$userrole_metakey = substr( $userrole, 3 );
				} else {
					$userrole_metakey = $userrole;
				}

				$rolemeta = get_option( "mp_role_{$userrole_metakey}_meta", false );

				if ( ! $rolemeta ) {
					$orders[ $userrole ] = 0;
					continue;
				}

				$orders[ $userrole ] = ! empty( $rolemeta['_mp_priority'] ) ? $rolemeta['_mp_priority'] : 0;
			}

			arsort( $orders );
			$roles_in_priority = array_keys( $orders );
			$roles_in_priority = array_intersect( $roles_in_priority, $this->get_editable_user_roles() );

			return array_shift( $roles_in_priority );
		}


		/**
		 * @param $user_id
		 *
		 * @return bool|mixed
		 */
		function get_mp_user_role( $user_id ) {
			// User has roles so look for a MP Role one
			$mp_roles_keys = get_option( 'mp_roles' );

			if ( empty( $mp_roles_keys ) )
				return false;

			$user = get_userdata( $user_id );

			if ( empty( $user->roles ) )
				return false;

			$mp_roles_keys = array_map( function( $item ) {
				return 'mp_' . $item;
			}, $mp_roles_keys );

			$user_mp_roles_array = array_intersect( $mp_roles_keys, array_values( $user->roles ) );

			if ( empty( $user_mp_roles_array ) )
				return false;

			return array_shift( $user_mp_roles_array );
		}


		/**
		 * Get role name by roleID
		 *
		 * @param $slug
		 * @return bool|string
		 */
		function get_role_name( $slug ) {
			$roledata = $this->role_data( $slug );

			if ( empty( $roledata['name'] ) ) {
				global $wp_roles;

				if ( empty( $wp_roles->roles[$slug] ) )
					return false;
				else
					return $wp_roles->roles[$slug]['name'];
			}


			return $roledata['name'];
		}


		/**
		 * Get role data
		 *
		 * @param int $roleID Role ID
		 * @return mixed|void
		 */
		function role_data( $roleID ) {
			if ( strpos( $roleID, 'mp_' ) === 0 ) {
				$role_data = get_option( "mp_role_{$roleID}_meta" );

				if ( ! $role_data ) {
					$roleID = substr( $roleID, 3 );
					$role_data = get_option( "mp_role_{$roleID}_meta" );
				}
			} else {
				$role_data = get_option( "mp_role_{$roleID}_meta" );
			}

			if ( ! $role_data ) {
				return array();
			}

			$temp = array();
			foreach ( $role_data as $key=>$value ) {
				if ( strpos( $key, '_mp_' ) === 0 ) {
					$key = preg_replace('/_mp_/', '', $key, 1);
				}

				//$key = str_replace( '_mp_', '', $key, $count );
				$temp[ $key ] = $value;
			}

			$temp = apply_filters( 'mp_change_role_data', $temp, $roleID );

			return $temp;
		}


		/**
		 * Query for MP roles
		 *
		 * @param bool $add_default
		 * @param null $exclude
		 *
		 * @return array
		 */
		function get_roles( $add_default = false, $exclude = null ){
			global $wp_roles;

			if ( empty( $wp_roles ) ) {
				return array();
			}

			$roles = $wp_roles->role_names;

			if ( $add_default ) {
				$roles[0] = $add_default;
			}

			if ( $exclude ) {
				foreach( $exclude as $role ) {
					unset( $roles[$role] );
				}
			}

			return $roles;
		}

		/**
		 * User can ( role settings )
		 *
		 * @param $permission
		 * @return bool|mixed
		 */
		function mp_user_can( $permission ) {
			if ( ! is_user_logged_in() )
				return false;

			$user_id = get_current_user_id();
			$role = $this->get_priority_user_role( $user_id );

			$permissions = $this->role_data( $role );

			/**
			 * MP hook
			 *
			 * @type filter
			 * @title mp_user_permissions_filter
			 * @description Change User Permissions
			 * @input_vars
			 * [{"var":"$permissions","type":"array","desc":"User Permissions"},
			 * {"var":"$user_id","type":"int","desc":"User ID"}]
			 * @change_log
			 * ["Since: 2.0"]
			 * @usage
			 * <?php add_filter( 'mp_user_permissions_filter', 'function_name', 10, 2 ); ?>
			 * @example
			 * <?php
			 * add_filter( 'mp_user_permissions_filter', 'my_user_permissions', 10, 2 );
			 * function my_user_permissions( $permissions, $user_id ) {
			 *     // your code here
			 *     return $permissions;
			 * }
			 * ?>
			 */
			$permissions = apply_filters( 'mp_user_permissions_filter', $permissions, $user_id );

			if ( isset( $permissions[ $permission ] ) && is_serialized( $permissions[ $permission ] ) )
				return unserialize( $permissions[ $permission ] );

			if ( isset( $permissions[ $permission ] ) && is_array( $permissions[ $permission ] ) )
				return $permissions[ $permission ];

			if ( isset( $permissions[ $permission ] ) && $permissions[ $permission ] == 1 )
				return true;

			return false;
		}
	}
}