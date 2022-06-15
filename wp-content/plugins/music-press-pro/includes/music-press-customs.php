<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
require_once MUSIC_PRESS_PRO_PLUGIN_DIR . '/includes/library/roles.php';

class Music_Press_Pro_Customs {
    var $classes    =    array();

	/**
	 * Constructor
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'music_press_pro_register_customs' ) );
		add_action( 'admin_menu', array( $this, 'music_press_pro_remove_taxonomy_metaboxes' ) );
		add_filter( 'the_content', array( $this, 'music_press_pro_content' ) );
//		add_filter( 'the_music_content', 'wptexturize' );
//		add_filter( 'the_music_content', 'convert_smilies' );
//		add_filter( 'the_music_content', 'convert_chars' );
//		add_filter( 'the_music_content', 'wpautop' );
//		add_filter( 'the_music_content', 'shortcode_unautop' );
//		add_filter( 'the_music_content', 'prepend_attachment' );
	}
	/**
	 * Registers the necessary custom post types and taxonomies for the plugin
	 */

	public function music_press_pro_register_customs() {
//        $acl   =   MP()->acl();
//        var_dump($acl->mp_user_can); die();
		/**
		 * Song Post types
		 */
		$singular  = esc_html__( 'Songs',  'music-press-pro' );
		$plural    = esc_html__( 'Songs manager',  'music-press-pro' );

		$args = array(
			'description'         => esc_html__( 'This is where you can create and manage Songs.',  'music-press-pro' ),
			'labels' => array(
				'name' 					=> $plural,
				'singular_name' 		=> $singular,
				'menu_name'             => $plural,
				'all_items'             => sprintf( esc_html__( 'All %s',  'music-press-pro' ), $singular ),
				'add_new' 				=> esc_html__( 'Add New Song',  'music-press-pro' ),
				'add_new_item' 			=> sprintf( esc_html__( 'Add %s',  'music-press-pro' ), $singular ),
				'edit' 					=> esc_html__( 'Edit',  'music-press-pro' ),
				'edit_item' 			=> sprintf( esc_html__( 'Edit %s',  'music-press-pro' ), $singular ),
				'new_item' 				=> sprintf( esc_html__( 'New %s',  'music-press-pro' ), $singular ),
				'view' 					=> sprintf( esc_html__( 'View %s',  'music-press-pro' ), $singular ),
				'view_item' 			=> sprintf( esc_html__( 'View %s',  'music-press-pro' ), $singular ),
				'search_items' 			=> sprintf( esc_html__( 'Search %s',  'music-press-pro' ), $plural ),
				'not_found' 			=> sprintf( esc_html__( 'No %s found',  'music-press-pro' ), $plural ),
				'not_found_in_trash' 	=> sprintf( esc_html__( 'No %s found in trash',  'music-press-pro' ), $plural ),
				'parent' 				=> sprintf( esc_html__( 'Parent %s',  'music-press-pro' ), $singular )
			),
			'supports'            => array( 'title', 'editor', 'thumbnail', 'comments','post-formats' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => 'music_press',
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 20,
			'menu_icon'           => MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/images/music-press.png',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'song',
			'capabilities' => array(
				'publish_posts' => 'publish_songs',
				'edit_posts' => 'edit_songs',
				'edit_others_posts' => 'edit_others_songs',
				'delete_posts' => 'delete_songs',
				'delete_others_posts' => 'delete_others_songs',
				'read_private_posts' => 'read_private_songs',
				'edit_post' => 'edit_song',
				'delete_post' => 'delete_song',
				'read_post' => 'read_song',
				'delete_private_posts' => 'delete_private_songs',
				'delete_published_posts' => 'delete_published_songs',
				'edit_private_posts' => 'edit_private_songs',
				'edit_published_posts' => 'edit_published_songs'
			),
			'rewrite'			  => array( 'slug' => 'song' )
		);
        register_post_type( 'mp_song', $args );

        /**
         * Album Post types
         */

		$singular  = esc_html__( 'Genres',  'music-press-pro' );
		$plural    = esc_html__( 'Genres manager',  'music-press-pro' );

		$args = array(
			'description'         => esc_html__( 'This is where you can create and manage Genres.',  'music-press-pro' ),
			'labels' => array(
				'name' 					=> $plural,
				'singular_name' 		=> $singular,
				'menu_name'             => $plural,
				'all_items'             => sprintf( esc_html__( '%s',  'music-press-pro' ), $singular ),
				'add_new' 				=> esc_html__( 'Add New Genre',  'music-press-pro' ),
				'add_new_item' 			=> sprintf( esc_html__( 'Add %s',  'music-press-pro' ), $singular ),
				'edit' 					=> esc_html__( 'Edit',  'music-press-pro' ),
				'edit_item' 			=> sprintf( esc_html__( 'Edit %s',  'music-press-pro' ), $singular ),
				'new_item' 				=> sprintf( esc_html__( 'New %s',  'music-press-pro' ), $singular ),
				'view' 					=> sprintf( esc_html__( 'View %s',  'music-press-pro' ), $singular ),
				'view_item' 			=> sprintf( esc_html__( 'View %s',  'music-press-pro' ), $singular ),
				'search_items' 			=> sprintf( esc_html__( 'Search %s',  'music-press-pro' ), $plural ),
				'not_found' 			=> sprintf( esc_html__( 'No %s found',  'music-press-pro' ), $plural ),
				'not_found_in_trash' 	=> sprintf( esc_html__( 'No %s found in trash',  'music-press-pro' ), $plural ),
				'parent' 				=> sprintf( esc_html__( 'Parent %s',  'music-press-pro' ), $singular )
			),
			'supports'            => array( 'title', 'editor', 'thumbnail' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => 'music_press',
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 30,
			'menu_icon'           => MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/images/music-press.png',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'genre',
			'capabilities' => array(
				'publish_posts' => 'publish_genres',
				'edit_posts' => 'edit_genres',
				'edit_others_posts' => 'edit_others_genres',
				'delete_posts' => 'delete_genres',
				'delete_others_posts' => 'delete_others_genres',
				'read_private_posts' => 'read_private_genres',
				'edit_post' => 'edit_genre',
				'delete_post' => 'delete_genre',
				'read_post' => 'read_genre',
				'delete_private_posts' => 'delete_private_genres',
				'delete_published_posts' => 'delete_published_genres',
				'edit_private_posts' => 'edit_private_genres',
				'edit_published_posts' => 'edit_published_genres'
			),
			'rewrite'			  => array( 'slug' => 'genre' )
		);

		register_post_type( 'mp_genre', $args );

        /**
         * Album Post types
         */

		$singular  = esc_html__( 'Albums',  'music-press-pro' );
		$plural    = esc_html__( 'Albums manager',  'music-press-pro' );

		$args = array(
			'description'         => esc_html__( 'This is where you can create and manage Songs.',  'music-press-pro' ),
			'labels' => array(
				'name' 					=> $plural,
				'singular_name' 		=> $singular,
				'menu_name'             => $plural,
				'all_items'             => sprintf( esc_html__( '%s',  'music-press-pro' ), $singular ),
				'add_new' 				=> esc_html__( 'Add New Album',  'music-press-pro' ),
				'add_new_item' 			=> sprintf( esc_html__( 'Add %s',  'music-press-pro' ), $singular ),
				'edit' 					=> esc_html__( 'Edit',  'music-press-pro' ),
				'edit_item' 			=> sprintf( esc_html__( 'Edit %s',  'music-press-pro' ), $singular ),
				'new_item' 				=> sprintf( esc_html__( 'New %s',  'music-press-pro' ), $singular ),
				'view' 					=> sprintf( esc_html__( 'View %s',  'music-press-pro' ), $singular ),
				'view_item' 			=> sprintf( esc_html__( 'View %s',  'music-press-pro' ), $singular ),
				'search_items' 			=> sprintf( esc_html__( 'Search %s',  'music-press-pro' ), $plural ),
				'not_found' 			=> sprintf( esc_html__( 'No %s found',  'music-press-pro' ), $plural ),
				'not_found_in_trash' 	=> sprintf( esc_html__( 'No %s found in trash',  'music-press-pro' ), $plural ),
				'parent' 				=> sprintf( esc_html__( 'Parent %s',  'music-press-pro' ), $singular )
			),
			'supports'            => array( 'title', 'editor', 'thumbnail','comments' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => 'music_press',
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 35,
			'menu_icon'           => MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/images/music-press.png',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'album',
			'capabilities' => array(
				'publish_posts' => 'publish_albums',
				'edit_posts' => 'edit_albums',
				'edit_others_posts' => 'edit_others_albums',
				'delete_posts' => 'delete_albums',
				'delete_others_posts' => 'delete_others_albums',
				'read_private_posts' => 'read_private_albums',
				'edit_post' => 'edit_album',
				'delete_post' => 'delete_album',
				'read_post' => 'read_album',
				'delete_private_posts' => 'delete_private_albums',
				'delete_published_posts' => 'delete_published_albums',
				'edit_private_posts' => 'edit_private_albums',
				'edit_published_posts' => 'edit_published_albums'
			),
			'rewrite'			  => array( 'slug' => 'album' )
		);

		register_post_type( 'mp_album', $args );

        /**
         * Bands Post types
         */

		$singular  = esc_html__( 'Bands',  'music-press-pro' );
		$plural    = esc_html__( 'Bands manager',  'music-press-pro' );

		$args = array(
			'description'         => esc_html__( 'This is where you can create and manage Bands.',  'music-press-pro' ),
			'labels' => array(
				'name' 					=> $plural,
				'singular_name' 		=> $singular,
				'menu_name'             => $plural,
				'all_items'             => sprintf( esc_html__( '%s',  'music-press-pro' ), $singular ),
				'add_new' 				=> esc_html__( 'Add New Band',  'music-press-pro' ),
				'add_new_item' 			=> sprintf( esc_html__( 'Add %s',  'music-press-pro' ), $singular ),
				'edit' 					=> esc_html__( 'Edit',  'music-press-pro' ),
				'edit_item' 			=> sprintf( esc_html__( 'Edit %s',  'music-press-pro' ), $singular ),
				'new_item' 				=> sprintf( esc_html__( 'New %s',  'music-press-pro' ), $singular ),
				'view' 					=> sprintf( esc_html__( 'View %s',  'music-press-pro' ), $singular ),
				'view_item' 			=> sprintf( esc_html__( 'View %s',  'music-press-pro' ), $singular ),
				'search_items' 			=> sprintf( esc_html__( 'Search %s',  'music-press-pro' ), $plural ),
				'not_found' 			=> sprintf( esc_html__( 'No %s found',  'music-press-pro' ), $plural ),
				'not_found_in_trash' 	=> sprintf( esc_html__( 'No %s found in trash',  'music-press-pro' ), $plural ),
				'parent' 				=> sprintf( esc_html__( 'Parent %s',  'music-press-pro' ), $singular )
			),
			'supports'            => array( 'title', 'editor', 'thumbnail','comments' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => 'music_press',
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 40,
			'menu_icon'           => MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/images/music-press.png',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'band',
			'capabilities' => array(
				'publish_posts' => 'publish_bands',
				'edit_posts' => 'edit_bands',
				'edit_others_posts' => 'edit_others_bands',
				'delete_posts' => 'delete_bands',
				'delete_others_posts' => 'delete_others_bands',
				'read_private_posts' => 'read_private_bands',
				'edit_post' => 'edit_band',
				'delete_post' => 'delete_band',
				'read_post' => 'read_band',
				'delete_private_posts' => 'delete_private_bands',
				'delete_published_posts' => 'delete_published_bands',
				'edit_private_posts' => 'edit_private_bands',
				'edit_published_posts' => 'edit_published_bands'
			),
			'rewrite'			  => array( 'slug' => 'band' )
		);
		register_post_type( 'mp_band', $args );
		/**
         * Artist Post types
         */

		$singular  = esc_html__( 'Artists',  'music-press-pro' );
		$plural    = esc_html__( 'Artist manager',  'music-press-pro' );

		$args = array(
			'description'         => esc_html__( 'This is where you can create and manage Artists.',  'music-press-pro' ),
			'labels' => array(
				'name' 					=> $plural,
				'singular_name' 		=> $singular,
				'menu_name'             => $plural,
				'all_items'             => sprintf( esc_html__( '%s',  'music-press-pro' ), $singular ),
				'add_new' 				=> esc_html__( 'Add New Artist',  'music-press-pro' ),
				'add_new_item' 			=> sprintf( esc_html__( 'Add %s',  'music-press-pro' ), $singular ),
				'edit' 					=> esc_html__( 'Edit',  'music-press-pro' ),
				'edit_item' 			=> sprintf( esc_html__( 'Edit %s',  'music-press-pro' ), $singular ),
				'new_item' 				=> sprintf( esc_html__( 'New %s',  'music-press-pro' ), $singular ),
				'view' 					=> sprintf( esc_html__( 'View %s',  'music-press-pro' ), $singular ),
				'view_item' 			=> sprintf( esc_html__( 'View %s',  'music-press-pro' ), $singular ),
				'search_items' 			=> sprintf( esc_html__( 'Search %s',  'music-press-pro' ), $plural ),
				'not_found' 			=> sprintf( esc_html__( 'No %s found',  'music-press-pro' ), $plural ),
				'not_found_in_trash' 	=> sprintf( esc_html__( 'No %s found in trash',  'music-press-pro' ), $plural ),
				'parent' 				=> sprintf( esc_html__( 'Parent %s',  'music-press-pro' ), $singular )
			),
			'supports'            => array( 'title', 'editor', 'thumbnail','comments' ),
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => 'music_press',
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 45,
			'menu_icon'           => MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/images/music-press.png',
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'publicly_queryable'  => true,
			'capability_type'     => 'artist',
			'capabilities' => array(
				'publish_posts' => 'publish_artists',
				'edit_posts' => 'edit_artists',
				'edit_others_posts' => 'edit_others_artists',
				'delete_posts' => 'delete_artists',
				'delete_others_posts' => 'delete_others_artists',
				'read_private_posts' => 'read_private_artists',
				'edit_post' => 'edit_artist',
				'delete_post' => 'delete_artist',
				'read_post' => 'read_artist',
				'delete_private_posts' => 'delete_private_artists',
				'delete_published_posts' => 'delete_published_artists',
				'edit_private_posts' => 'edit_private_artists',
				'edit_published_posts' => 'edit_published_artists'
			),
			'rewrite'			  => array( 'slug' => 'artist' )
		);
		register_post_type( 'mp_artist', $args );

        flush_rewrite_rules( false );

	}
	/**
	 * Removes the default taxonomy metaboxes from the edit screen.
	 * We use the advanced custom fields instead and sync the data.
	 */
	public function music_press_pro_remove_taxonomy_metaboxes(){

        add_menu_page(
            'Music Press Pro',
            'Music Press Pro',
            'read',
            'music_press',
            '', // Callback, leave empty
            MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/images/music-press.png',
            10 // Position
        );
//		add_submenu_page(
//			'music_press',
//			'Add new song', /*page title*/
//			'Add new song', /*menu title*/
//			'manage_options', /*roles and capabiliyt needed*/
//			'post-new.php?post_type=mp_song',
//            ''
//		);
		add_submenu_page(
			'music_press',
			'Music Add-ons page', /*page title*/
			'Free Add-ons', /*menu title*/
			'manage_options', /*roles and capabiliyt needed*/
			'music-add-ons',
			'music_press_pro_adds_on_menu' /*replace with your own function*/
		);

		add_submenu_page(
			'music_press',
			esc_html__( 'ACL Manager',  'music-press-pro' ), /*page title*/
			esc_html__( 'ACL',  'music-press-pro' ), /*menu title*/
			'manage_options', /*roles and capabiliyt needed*/
			'mp_roles',
			array( &$this, 'music_press_pro_acl' )
		);
		remove_meta_box( 'tagsdiv-album', 'music', 'normal' );
		remove_meta_box( 'tagsdiv-artist', 'music', 'normal' );
		function music_press_pro_adds_on_menu(){
			?>
			<h3 class="music-addons"><?php echo esc_html_e('Music Press Add-ons','music-press-pro');?></h3>

			<ul class="addons-contain">
				<li class="addons-item">
					<a target="_blank" href="https://wordpress.org/plugins/music-press-quick-playlist/" ><img src="<?php echo esc_url(MUSIC_PRESS_PRO_PLUGIN_URL.'/assets/images/music_playlist.png');?>"/></a>
					<span><?php echo esc_html__('Music Press Quick Playlist', 'music-press-pro');?></span>
					<span class="version"><?php echo esc_html__('Version 1.0', 'music-press-pro');?></span>
					<p><?php echo esc_html__('Music Press Playlist helps you create any playlist to get latest song, top song plays or you can choose manual songs add to playlist.
and you can show playlist in page or post or sidebar.', 'music-press-pro')?></p>
					<div class="btn_addons">
                        <?php
                        if ( is_plugin_active( 'music-press-quick-playlist/music-press-quick-playlist.php' ) ) { ?>
                        <span class="installed" href=":javascript"><?php echo esc_html__('Installed', 'music-press-pro');?></span>
                        <?php }else{

                        ?>
						<a class="install" target="_blank" href="plugin-install.php?s=Music+Press+Playlist&tab=search&type=term"><?php echo esc_html__('Install', 'music-press-pro');?></a>
<?php } ?>
					</div>
				</li>
			</ul>
			<?php
		}

	}

	/**
	 * ACL menu callback
	 */
	function music_press_pro_acl () {
		require_once MUSIC_PRESS_PRO_PLUGIN_DIR . '/includes/admin/controllers/acl/acl.php';
		$acl  =   new MP_ACL_Controller();
	}

	/**
	 * Since our vehicle post type doesn't have an editor field we need to display some of the meta values instead
	 * @param  string $content 	the excisting content
	 * @return string $content 	the updated content
	 */
	function music_press_pro_content( $content ) {
		global $post;

		if ( $post->post_type == 'mp_song' || $post->post_type == 'mp_album' || $post->post_type == 'mp_artist' || $post->post_type == 'mp_genre' || $post->post_type == 'mp_band' ) {
			$content = do_shortcode( '[music_press_pro_description]' );
			$content = apply_filters( 'the_music_content', $content );
		}

		return $content;
	}

}
?>