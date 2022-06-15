<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Music_Press_Pro_Admin class.
 */
class Music_Press_Pro_Admin {

    /**
     * __construct function.
     *
     * @access public
     * @return void
     */
    public function __construct() {

        // Enqueue CSS and JS in admin
        add_action( 'admin_enqueue_scripts', array( $this, 'music_press_pro_admin_scripts' ) );

        // Use a custom walker for the ACF dropdowns
//        add_filter( 'acf/fields/taxonomy/wp_list_categories', array( $this, 'acf_wp_list_categories' ), 10, 2 );

        // Adds a Make column to the Song admin columns

        add_filter( 'manage_mp_song_posts_columns',array( $this,  'set_custom_edit_song_columns' ));
        add_action( 'manage_mp_song_posts_custom_column' , array( $this, 'custom_song_column'), 10, 2 );
        add_filter( 'manage_mp_album_posts_columns',array( $this,  'set_custom_edit_album_columns' ));
        add_action( 'manage_mp_album_posts_custom_column' , array( $this, 'custom_album_column'), 10, 2 );
        // Add helpful action links to the plugin list
        add_filter( 'plugin_action_links_'. MUSIC_PRESS_PRO_PLUGIN_BASENAME, array( $this, 'plugin_action_links' ) );

        add_filter( 'hidden_meta_boxes', array($this,'amita_hidden_meta_boxes' ));

        add_action( 'restrict_manage_posts', array($this,'mp_filter_tracked_plugins') );
        add_filter( 'parse_query', array($this,'mp_sort_plugins_by_album') );
	    //roles metaboxes
	    add_action( 'mp_roles_add_meta_boxes', array( &$this, 'add_metabox_role' ) );
        MP()->acl();
    }

    public function mp_filter_tracked_plugins() {
        // Apply this only on a specific post type
        global $typenow;
        if( $typenow != "page" && $typenow != "post" ){
            $post_type=get_query_var('post_type');
            if($post_type=='mp_song'){
                global $wpdb;
                $mp_albums = "SELECT  * FROM " . $wpdb->prefix . "posts WHERE post_type= 'mp_album' AND  post_status ='publish'";
                $album_results = $wpdb->get_results($mp_albums );

                if($album_results ) {
                    echo "<select name='song_album' id='song_album' class='postform'>";
                    echo '<option value="all">' . sprintf(esc_html__('All Albums', 'music-press-member')) . '</option>';
                    foreach ($album_results as $album_item) {
                        $album_id = $album_item->ID;
                        printf(
                            '<option value="%1$s" %2$s>%3$s</option>',
                            $album_id,
                            ((isset($_GET['song_album']) && ($_GET['song_album'] == $album_id)) ? ' selected="selected"' : ''),
                            get_the_title($album_id)
                        );
                    }
                    echo '</select>';
                }
                $mp_artists = "SELECT  * FROM " . $wpdb->prefix . "posts WHERE post_type= 'mp_artist' AND  post_status ='publish'";
                $artist_results = $wpdb->get_results($mp_artists );
                if($artist_results ) {
                    echo "<select name='song_artist' id='song_artist' class='postform'>";
                    echo '<option value="all">' . sprintf(esc_html__('All Artist', 'music-press-member')) . '</option>';
                    foreach ($artist_results as $artist_item) {
                        $artist_id = $artist_item->ID;
                        printf(
                            '<option value="%1$s" %2$s>%3$s</option>',
                            $artist_id,
                            ((isset($_GET['song_artist']) && ($_GET['song_artist'] == $artist_id)) ? ' selected="selected"' : ''),
                            get_the_title($artist_id)
                        );
                    }
                    echo '</select>';
                }
                $mp_bands = "SELECT  * FROM " . $wpdb->prefix . "posts WHERE post_type= 'mp_band' AND  post_status ='publish'";
                $band_results = $wpdb->get_results($mp_bands );
                if($band_results ) {
                    echo "<select name='song_band' id='song_band' class='postform'>";
                    echo '<option value="all">' . sprintf(esc_html__('All Band', 'music-press-member')) . '</option>';
                    foreach ($band_results as $band_item) {
                        $band_id = $band_item->ID;
                        printf(
                            '<option value="%1$s" %2$s>%3$s</option>',
                            $band_id,
                            ((isset($_GET['song_band']) && ($_GET['song_band'] == $band_id)) ? ' selected="selected"' : ''),
                            get_the_title($band_id)
                        );
                    }
                    echo '</select>';
                }
            }
            if($post_type=='mp_album'){
                $albums_type = array('audio','video','all');
                echo "<select name='album_type' id='album_type' class='postform'>";
                echo '<option value="all">' . sprintf(esc_html__('All Type', 'music-press-member')) . '</option>';
                foreach ($albums_type as $album_type) {
                    printf(
                        '<option value="%1$s" %2$s>%3$s</option>',
                        $album_type,
                        ((isset($_GET['album_type']) && ($_GET['album_type'] == $album_type)) ? ' selected="selected"' : ''),
                        $album_type
                    );
                }
                echo '</select>';
            }

        }
    }
    public function mp_sort_plugins_by_album($query){
        global $pagenow;
        // Get the post type
        $post_type = isset( $_GET['post_type'] ) ? $_GET['post_type'] : '';
        if ( is_admin() && $pagenow=='edit.php' && $post_type == 'mp_song' && isset( $_GET['song_album'] ) && $_GET['song_album'] !='all' ) {
            $album = $_GET['song_album'];
            $query->query_vars['meta_key'] = 'song_album';
            $query->query_vars['meta_value'] = '\"'.$album.'\"';
            $query->query_vars['meta_compare'] = 'REGEXP';
        }
        if ( is_admin() && $pagenow=='edit.php' && $post_type == 'mp_song' && isset( $_GET['song_artist'] ) && $_GET['song_artist'] !='all' ) {
            $artist = $_GET['song_artist'];
            $query->query_vars['meta_key'] = 'song_artist';
            $query->query_vars['meta_value'] = '\"'.$artist.'\"';
            $query->query_vars['meta_compare'] = 'REGEXP';
        }
        if ( is_admin() && $pagenow=='edit.php' && $post_type == 'mp_song' && isset( $_GET['song_band'] ) && $_GET['song_band'] !='all' ) {
            $band = $_GET['song_band'];
            $query->query_vars['meta_key'] = 'song_band';
            $query->query_vars['meta_value'] = '\"'.$band.'\"';
            $query->query_vars['meta_compare'] = 'REGEXP';
        }
        if ( is_admin() && $pagenow=='edit.php' && $post_type == 'mp_album' && isset( $_GET['album_type'] ) && $_GET['album_type'] !='all' ) {
            $album = $_GET['album_type'];
            $query->query_vars['meta_key'] = 'album_type';
            $query->query_vars['meta_value'] = ''.$album.'';
            $query->query_vars['meta_compare'] = '=';
        }
    }
    public function amita_hidden_meta_boxes( $hidden ) {
        // Hide meta boxes on the single Post screen
        $hidden[] = 'formatdiv';  // Featured Image

        return $hidden;
    }

    /**
     * Enqueue CSS and JS in admin
     *
     * @access public
     * @return void
     */
    public function music_press_pro_admin_scripts() {
		wp_enqueue_script('jquery-ui-datepicker');

        wp_enqueue_style( 'music_press_admin_css', MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/css/admin.css', false );
        wp_enqueue_style( 'music_press_chosen_css', MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/css/chosen.css', false );
        wp_enqueue_script( 'music_press_admin_js', MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/js/admin.js', array( 'jquery' ),  true );
        wp_enqueue_script( 'music_press_chosen_js', MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/js/chosen.jquery.min.js', array( 'jquery' ),  true );
        wp_enqueue_script( 'music_press_init_js', MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/js/init.js', array( 'jquery' ),  true );
    }

    /**
     * Use a custom walker for the ACF dropdowns
     * @param  array $args 		The default dropdown arguments
     * @return array 			Default dropdown args + custom walker
     */
    public function acf_wp_list_categories( $args, $field ) {
        $args['walker'] = new music_press_pro_acf_taxonomy_field_walker( $field );
        return $args;
    }

    public function set_custom_edit_song_columns($columns) {
        $date = $columns['date'];
        unset( $columns['date'] );
        unset( $columns['comments'] );
        $columns['song_album'] = esc_html__( 'Albums',  'music-press-pro' );
        $columns['song_play'] = esc_html__( 'Plays',  'music-press-pro' );
        $columns['date'] = $date;
        return $columns;
    }
    public function custom_song_column($columns, $post_ID ){
        if ($columns == 'song_album') {
            $albums = get_field('song_album',$post_ID);
            if($albums != null){
                $count = count($albums);
                $i=1;
                foreach ($albums as $album){
                    if($i== $count){
                        ?>
                        <a href="<?php echo esc_url(get_edit_post_link($album));?>"><?php echo esc_attr(get_the_title($album));?></a>
                        <?php
                    }else{
                        ?>
                        <a href="<?php echo esc_url(get_edit_post_link($album));?>"><?php echo esc_attr(get_the_title($album));?></a><?php echo esc_html__(',', 'music-press-pro');
                    }
                    $i++;
                }
            }
        }
        if ($columns == 'song_play') {
            echo music_press_pro_getPostViews( get_the_ID() );
        }
        $mp_version =  get_plugin_data(TZ_MUSIC_PLUGIN_FILE);
        $mp_ver = $mp_version['Version'];
        if($mp_ver<=1.2){
            $song_type = get_field('song_type',$post_ID);
            set_post_format($post_ID,$song_type);
        }
    }

    public function set_custom_edit_album_columns($columns) {
        $date = $columns['date'];
        unset( $columns['date'] );
        $comments = $columns['comments'];
        unset( $columns['comments'] );
        $columns['album_play'] = esc_html__( 'Plays',  'music-press-pro' );
        $columns['album_songs'] = esc_html__( 'Songs',  'music-press-pro' );
        $columns['comments'] = $comments;
        $columns['date'] = $date;
        return $columns;
    }
    public function custom_album_column($columns, $post_ID ){
        if ($columns == 'album_play') {
            echo music_press_pro_getPostViews( $post_ID );
        }
        if ($columns == 'album_songs') {
            $songs = music_press_pro_get_songs_from_album($post_ID,'post_date','ASC');
            if (isset($songs)){
                $total_song = count($songs);
                echo $total_song;
            }else{
                echo esc_html_e('0','music-press-pro');
            }

        }
    }

	/**
	 * Add role metabox
	 */
	function add_metabox_role() {
		$roles_metaboxes    =   array();

		/**
		 * UM hook
		 *
		 * @type filter
		 * @title mp_admin_role_metaboxes
		 * @description Extend metaboxes at Add/Edit User Role
		 * @input_vars
		 * [{"var":"$roles_metaboxes","type":"array","desc":"Metaboxes at Add/Edit UM Role"}]
		 * @change_log
		 * ["Since: 2.0"]
		 * @usage add_filter( 'mp_admin_role_metaboxes', 'function_name', 10, 1 );
		 * @example
		 * <?php
		 * add_filter( 'mp_admin_role_metaboxes', 'my_admin_role_metaboxes', 10, 1 );
		 * function my_admin_role_metaboxes( $roles_metaboxes ) {
		 *     // your code here
		 *     $roles_metaboxes[] = array(
		 *         'id'        => 'mp-admin-form-your-custom',
		 *         'title'     => __( 'My Roles Metabox', 'music-press-pro' ),
		 *         'callback'  => 'my-metabox-callback',
		 *         'screen'    => 'mp_role_meta',
		 *         'context'   => 'side',
		 *         'priority'  => 'default'
		 *     );
		 *
		 *     return $roles_metaboxes;
		 * }
		 * ?>
		 */
		$roles_metaboxes = apply_filters( 'mp_admin_role_metaboxes', $roles_metaboxes );

		foreach ( $roles_metaboxes as $metabox ) {
			add_meta_box(
				$metabox['id'],
				$metabox['title'],
				$metabox['callback'],
				$metabox['screen'],
				$metabox['context'],
				$metabox['priority']
			);
		}
	}

    /**
     * Add helpful action links to the plugin list
     * @param  array $links Excisting links
     * @return array        Added link to plugin settings
     */
    public function plugin_action_links( $links ) {
        $links[] = '<a href="' . admin_url( 'admin.php?page=acf-options-settings' ) . '">' . esc_html__( 'Settings',  'music-press-pro' ) . '</a>';
//        $links[] = '<a href="' . admin_url( 'admin.php?page=music-press-addons' ) . '">' . esc_html__( 'Free Add-ons',  'music-press-pro' ) . '</a>';
        return $links;
    }
}

new Music_Press_Pro_Admin();

if (!class_exists('acf_mp') && !defined('ACF_LITE')) {
    class music_press_pro_acf_taxonomy_field_walker extends acf_taxonomy_field_walker_mp
    {
        // start_el
        function start_el(&$output, $term, $depth = 0, $args = array(), $current_object_id = 0)
        {
            // vars

            $selected = in_array($term->term_id, $this->field['value']);
            if ($this->field['field_type'] == 'checkbox') {
                $output .= '<li><label class="selectit"><input type="checkbox" name="' . $this->field['name'] . '" value="' . $term->term_id . '" ' . ($selected ? 'checked="checked"' : '') . ' /> ' . $term->name . '</label>';
            } elseif ($this->field['field_type'] == 'radio') {
                $output .= '<li><label class="selectit"><input type="radio" name="' . $this->field['name'] . '" value="' . $term->term_id . '" ' . ($selected ? 'checked="checkbox"' : '') . ' /> ' . $term->name . '</label>';
            } elseif ($this->field['field_type'] == 'select') {
                if ('model' == $term->taxonomy) {
                    $make = get_field('make', $term);

                    $make_attr = 'data-make="' . $make->name . '"';
                }
                $indent = str_repeat("&mdash;", $depth);
                $output .= '<option ' . $make_attr . ' value="' . $term->term_id . '" ' . ($selected ? 'selected="selected"' : '') . '>' . $indent . ' ' . $term->name . '</option>';
            }

        }
    }
}