<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly
if ( ! class_exists( 'Music_Press_Pro_Album_Fields' ) ) {
class Music_Press_Pro_Album_Fields

{

    public function __construct()
    {

        $this->fields = array();
        // add query vars of our searchform
        add_filter('query_vars', array($this, 'music_press_pro_add_query_vars_filter'));
        add_filter('pre_get_posts', array($this, 'music_press_pro_filter_posts'));
        add_filter('acf/save_post', array($this, 'music_press_pro_sync_content_field'));
        add_action('init', array($this, 'music_press_pro_register_fields'));

        $this->built_in = array(
            'album_genre' => array(
                'label' => esc_html__('Genres',  'music-press-pro'),
                'name' => 'album_genre',
                'type' => 'select',
                'sort' => 5,
                'multiple' => 1,
                'allow_null' => 0,
                'choices' => $this->music_press_pro_infos('mp_genre'),
                'class' => 'chosen-select',
                'default_value' => '',
            ),
            'album_band' => array(
                'label' => esc_html__('Bands',  'music-press-pro'),
                'name' => 'album_band',
                'type' => 'select',
                'sort' => 6,
                'multiple' => 1,
                'allow_null' => 0,
                'choices' => $this->music_press_pro_infos('mp_band'),
                'class' => 'chosen-select',
                'default_value' => '',
            ),
            'album_artist' => array(
                'label' => esc_html__('Artists',  'music-press-pro'),
                'name' => 'album_artist',
                'type' => 'select',
                'sort' => 7,
                'multiple' => 1,
                'allow_null' => 0,
                'choices' => $this->music_press_pro_infos('mp_artist'),
                'class' => 'chosen-select',
                'default_value' => '',
            ),
            'music_type' => array(
                'label' => esc_html__('Album Type',  'music-press-pro'),
                'name' => 'album_type',
                'instructions' => '',
                'type' => 'select',
                'choices' => array(
                    'audio' => esc_html__('Audio',  'music-press-pro'),
                    'video' => esc_html__('Video',  'music-press-pro'),
                    'all'   => esc_html__('Audio & Video',  'music-press-pro'),
                ),
                'multiple'  => 0,
                'default_value' => 'audio',
                'sort' => 30
            ),
            'album_poster' => array(
                'label' => esc_html__('Album Poster',  'music-press-pro'),
                'name' => 'album_poster',
                'instructions' => '',
                'type' => 'image',
                'sort' => 35
            )
        );
    }

    public function music_press_pro_infos($album_info)
    {
        global $wpdb;
        $albums = $wpdb->get_results( "SELECT ID, post_name, post_title FROM ". $wpdb->prefix ."posts WHERE post_type = '$album_info' AND post_status ='publish'"  );
        $al_arr = array();
        foreach ($albums as $album){
            $al_arr[$album->ID]= $album->post_title;
        }
        return $al_arr;
    }

    public function music_press_pro_bands()
    {
        global $wpdb;
        $albums = $wpdb->get_results( "SELECT * FROM ". $wpdb->prefix ."posts WHERE post_type = 'mp_band'"  );
        $al_arr = array();
        foreach ($albums as $album){
            $al_arr[$album->post_name]= $album->post_title;
        }
        return $al_arr;

    }

    public function music_press_pro_artists()
    {
        global $wpdb;
        $albums = $wpdb->get_results( "SELECT * FROM ". $wpdb->prefix ."posts WHERE post_type = 'mp_artist'"  );
        $al_arr = array();
        foreach ($albums as $album){
            $al_arr[$album->post_name]= $album->post_title;
        }
        return $al_arr;

    }

    public function music_press_pro_add_query_vars_filter( $vars ) {

        $fields = $this->get_registered_fields();

        if ( $fields ) {
            foreach ( $fields as $field ) {
                if ( 'taxonomy' != $field['type'] ) {
                    $vars[] = $field['name'];
                }
            }
        }
        return $vars;

    }

    public function music_press_pro_filter_posts( $query ) {
        if ( ! is_post_type_archive('mp_album') && ( isset($query->query['post_type']) && 'mp_album' != $query->query['post_type'] )) {
            return;
        }
        if ( ! $query->is_main_query()  ) {
            return;
        }

        $meta_query = array();
        $fields = $this->get_registered_fields();

        if ( $fields ) {
            foreach ( $fields as $field ) {

                $query_var = get_query_var( $field['name'] );

                if ( empty( $query_var ) || ! is_array( $query_var ) ) {
                    continue;
                }
                if ( 'radio' == $field['type'] || 'checkbox' == $field['type'] ) {

                    $meta_query[] = array(
                        'key' => $field['name'],
                        'value' => $query_var,
                        'compare' => 'IN'
                    );
                }
            }
        }

        $query->set('meta_query', $meta_query);

    }

    public function music_press_pro_sync_content_field( $post_id ) {
        // vars
        $fields = false;

        // load from post
        if( isset( $_POST['fields'] ) ) {
            $field_key = get_field( '_content', $post_id );
            $content='';
            if ( $field_key ) {

            }
            else {
                $content = 0;
            }
            // Update post 37
            $updated_post = array(
                'ID'           => $post_id,
                'post_content' => $content
            );

            remove_action( 'acf/save_post', array( $this, 'music_press_pro_sync_content_field' ));

            // Update the post into the database
            wp_update_post( $updated_post );

            add_action( 'acf/save_post', array( $this, 'music_press_pro_sync_content_field' ));
        }
    }

    public function get_meta_values( $key = '', $type = 'post', $status = 'publish' ) {

        global $wpdb;

        if( empty( $key ) )
            return;

        $r = $wpdb->get_col( $wpdb->prepare( "
	        SELECT pm.meta_value FROM {$wpdb->postmeta} pm
	        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
	        WHERE pm.meta_key = '%s'
	        AND p.post_status = '%s'
	        AND p.post_type = '%s'
	    ", $key, $status, $type ) );

        return $r;
    }

    public function music_press_pro_register_field( $args ) {

        // ACF requires a unique key per field so lets generate one
        $key = md5( serialize( $args ));

        if ( empty( $args['type'] )) {
            $args['type'] = 'number';
        }
        $type = $args['type'];

        if ( 'taxonomy' == $type ) {

            $field = wp_parse_args( $args, array(
                'key'           => $key,
                'label'         => '',
                'name'          => '',
                'type'          => 'taxonomy',
                'instructions'  => '',
                'taxonomy'      => '',
                'field_type'    => 'select',
                'allow_null'    => 0,
                'load_save_terms' => 1,
                'add_term'		=> 0,
                'return_format' => 'id',
                'multiple'      => 0,
                'sort'          => 0,
                'group'         => 'information'
            ) );
        } else if ( 'checkbox' == $type ) {

            $field = wp_parse_args( $args, array (
                'key' => $key,
                'label' => '',
                'name' => '',
                'instructions' => '',
                'choices' => array(),
                'layout' => 'vertical',
                'sort' => 0,
                'multiple'	=> 1,
                'group' => 'information'
            ) );
        } else{

            $field = wp_parse_args( $args, array (
                'key' => $key,
                'label' => '',
                'name' => '',
                'instructions' => '',
                'choices' => array(),
                'sort' => 0,
                'multiple'	=> 1,
                'group' => 'information'
            ) );
        }
        $field = apply_filters( 'pcd/register_field', $field );
        $this->fields[$field['name']] = $field;

        return $field;
    }

    public function music_press_pro_register_built_in_fields() {

        $built_in_fields = apply_filters( 'pcd/built_in_fields', $this->built_in);

        if ( ! empty( $built_in_fields )) {
            foreach ( $built_in_fields as $field ) {
                $this->music_press_pro_register_field( $field );
            }
        }
    }

    public function music_press_pro_register_fields() {

        $this->music_press_pro_register_built_in_fields();

        $fields = array();
        $translations = array( // not used anywhere else
            esc_html__( 'Description',  'music-press-pro' ),
            esc_html__( 'Information',  'music-press-pro' ),
        );

        $layout_groups = array(
            'Description' => array(),
            'Information' => array(),
        );
        $layout_groups['Description'] = $this->get_registered_fields( 'description' );
        $layout_groups['Description'][] = array (
            'key' => 'field_52910fe7d4567',
            'label' => esc_html__( 'Album Description',  'music-press-pro' ),
            'name' => 'content',
            'type' => 'wysiwyg',
            'default_value' => '',
            'toolbar' => 'full',
            'media_upload' => 'yes',
            'sort'      => 30,
        );
        $layout_groups['Description'][] = array (
            'key' => 'field_52910fe7dfd356',
            'label' => esc_html__( 'Album Short description',  'music-press-pro' ),
            'name' => 'song_lyric',
            'type' => 'textarea',
            'default_value' => '',
            'sort'      => 10,
        );
        $layout_groups['Information'] = $this->get_registered_fields('information');

        foreach ( $layout_groups as $label => $field_group ) {
            $fields[] = array (
                'key' => 'tab_'. $label,
                'label' => $label,
                'name' => $label,
                'type' => 'tab',
            );
            foreach ( $field_group as $field ) {
                $fields[] = $field;
            };
        };

        if(function_exists("register_field_group"))
        {
            register_field_group(array (
                'id' => 'acf_album-data',
                'title' => esc_html__( 'Song Data',  'music-press-pro' ),
                'fields' => $fields,
                'location' => array (
                    array (
                        array (
                            'param' => 'post_type',
                            'operator' => '==',
                            'value' => 'mp_album',
                            'order_no' => 0,
                            'group_no' => 0,
                        ),
                    ),
                ),
                'options' => array (
                    'position' => 'normal',
                    'layout' => 'no_box',
                    'hide_on_screen' => array (
                        'the_content', 'custom_fields'
                    ),
                ),
                'menu_order' => 0,
            ));
        }
    }

    public function get_registered_fields( $group = '' ) {

        $fields = $this->fields;
        $filtered = array();
        $sorted = array();

        foreach ($fields as $key => $field ) {
            $fields[$key]['label'] = $field['label'];
        }

        if ( ! empty( $group ) ) {
            foreach ($fields as $field ) {
                if ( $group == $field['group'] ) {
                    $filtered[] = $field;
                }
            }
        } else {
            $filtered = $fields;
        }

        foreach ( $filtered as $key => $value ) {
            $sorted[$key]  = $value['sort'];
        }

        array_multisort( $sorted, SORT_ASC, SORT_NUMERIC, $filtered );

        return apply_filters( 'pcd/fields', $filtered );
    }

}
}