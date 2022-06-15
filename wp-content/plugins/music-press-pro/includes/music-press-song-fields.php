<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly
if (!class_exists('Music_Press_Pro_Fields')) {
    class Music_Press_Pro_Fields
    {

        public function __construct()
        {

            $this->fields = array();

            // add query vars of our searchform
            add_filter('query_vars', array($this, 'music_press_pro_add_query_vars_filter'));
            add_filter('pre_get_posts', array($this, 'music_press_pro_filter_posts'));
            add_filter('acf/save_post', array($this, 'music_press_pro_sync_content_field'));

            add_action('plugins_loaded', array($this, 'music_press_pro_register_admin_fields'));
            add_action('init', array($this, 'music_press_pro_register_fields'));

            $this->built_in = array(

                'song_type' => array(
                    'label' => esc_html__('Song Type', 'music-press-pro'),
                    'name' => 'song_type',
                    'instructions' => '',
                    'type' => 'radio',
                    'choices' => array(
                        'audio' => esc_html__('Audio', 'music-press-pro'),
                        'video' => esc_html__('Video', 'music-press-pro'),
                    ),
                    'default_value' => 'audio',
                    'class' => 'song_type',
                    'other_choice' => 0,
                    'sort' => 30
                ),
                'song_source' => array(
                    'label' => esc_html__('Song Source', 'music-press-pro'),
                    'name' => 'song_source',
                    'instructions' => '',
                    'type' => 'radio',
                    'choices' => array(
                        'upload' => esc_html__('Upload File or File Url', 'music-press-pro'),
                        'embed' => esc_html__('Add Url or Embed Code', 'music-press-pro'),
                    ),
                    'default_value' => 'upload',
                    'class' => 'song_source',
                    'other_choice' => 0,
                    'sort' => 30
                ),
                'song_license' => array(
                    'label' => esc_html__('Song License', 'music-press-pro'),
                    'name' => 'song_license',
                    'instructions' => '',
                    'type' => 'radio',
                    'choices' => array(
                        'free' => esc_html__('Free', 'music-press-pro'),
//                    'sale' => esc_html__('Sale',  'music-press-pro'),
                    ),
                    'default_value' => 'free',
                    'class' => 'song_license',
                    'other_choice' => 0,
                    'sort' => 5
                ),
                'song_audio' => array(
                    'label' => esc_html__('Audio File', 'music-press-pro') . ' <small>' . esc_html__('(Select mp3 file)', 'music-press-pro') . '</small>',
                    'name' => 'song_audio',
                    'instructions' => '',
                    'type' => 'file',
                    'sort' => 30,
                    'mime_types' => 'audio'
                ),
                'song_embed_audio' => array(
                    'label' => esc_html__('Audio url (oembed) or embed code.', 'music-press-pro'),
                    'name' => 'song_embed_audio',
                    'instructions' => '',
                    'type' => 'textarea',
                    'mime_types' => 'audio',
                    'sort' => 30
                ),
                'song_audio_cover' => array(
                    'label' => esc_html__('Audio File Cover', 'music-press-pro') . ' <small>' . esc_html__('(Select mp3 file)', 'music-press-pro') . '</small>',
                    'name' => 'song_audio_cover',
                    'instructions' => '',
                    'type' => 'file',
                    'sort' => 30,
                    'library' => 'audio'
                ),
                'song_audio_link' => array(
                    'label' => esc_html__('mp3 link', 'music-press-pro') . ' <small>' . esc_html__('(Enter link to .mp3)', 'music-press-pro') . '</small>',
                    'name' => 'song_audio_link',
                    'instructions' => '',
                    'type' => 'text',
                    'sort' =>35,
                ),
                'song_video' => array(
                    'label' => esc_html__('Video File', 'music-press-pro') . ' <small>' . esc_html__('(Select mp4 file)', 'music-press-pro') . '</small>',
                    'name' => 'song_video',
                    'instructions' => '',
                    'type' => 'file',
                    'sort' => 35,
                    'mime_types' => 'video'
                ),
                'song_video_cover' => array(
                    'label' => esc_html__('Video File Cover', 'music-press-pro') . ' <small>' . esc_html__('(Select mp4 file)', 'music-press-pro') . '</small>',
                    'name' => 'song_video_cover',
                    'instructions' => '',
                    'type' => 'file',
                    'sort' => 35,
                    'mime_types' => 'video'
                ),
                'song_video_link' => array(
                    'label' => esc_html__('Video link', 'music-press-pro') . ' <small>' . esc_html__('(Enter link to .mp4)', 'music-press-pro') . '</small>',
                    'name' => 'song_video_link',
                    'instructions' => '',
                    'type' => 'text',
                    'sort' => 36,
                ),
                'song_embed_video' => array(
                    'label' => esc_html__('Video url(oembed) or embed code', 'music-press-pro'),
                    'name' => 'song_embed_video',
                    'instructions' => '',
                    'type' => 'textarea',
                    'mime_types' => 'video',
                    'sort' => 40
                ),
                'song_genre' => array(
                    'label' => esc_html__('Genres', 'music-press-pro'),
                    'name' => 'song_genre',
                    'type' => 'select',
                    'sort' => 5,
                    'multiple' => 1,
                    'allow_null' => 0,
                    'choices' => $this->music_press_pro_song_info('mp_genre'),
                    'class' => 'chosen-select',
                    'default_value' => '',
                ),
                'song_album' => array(
                    'label' => esc_html__('Albums', 'music-press-pro'),
                    'name' => 'song_album',
                    'type' => 'select',
                    'sort' => 6,
                    'multiple' => 1,
                    'allow_null' => 0,
                    'choices' => array(
                        'Album Audio' => $this->music_press_pro_album_info('audio'),
                        'Album Video' => $this->music_press_pro_album_info('video'),
                        'Album Audio & Video' => $this->music_press_pro_album_info('all')
                    ),
                    'class' => 'chosen-select',
                    'default_value' => '',
                ),
                'song_band' => array(
                    'label' => esc_html__('Bands', 'music-press-pro'),
                    'name' => 'song_band',
                    'type' => 'select',
                    'sort' => 7,
                    'multiple' => 1,
                    'allow_null' => 0,
                    'choices' => $this->music_press_pro_song_info('mp_band'),
                    'class' => 'chosen-select',
                    'default_value' => '',
                ),
                'song_artist' => array(
                    'label' => esc_html__('Artists', 'music-press-pro'),
                    'name' => 'song_artist',
                    'type' => 'select',
                    'sort' => 8,
                    'multiple' => 1,
                    'allow_null' => 0,
                    'choices' => $this->music_press_pro_song_info('mp_artist'),
                    'class' => 'chosen-select',
                    'default_value' => '',
                ),
//            'song_for_sale' => array(
//                'label' => esc_html__('Song Price',  'music-press-pro'),
//                'name' => 'song_price',
//                'type' => 'number',
//                'class' => 'music_sale',
//                'sort' => 10,
//                'allow_null' => 0
//            )
            );
        }

        public function music_press_pro_album_info($album_type)
        {
            global $wpdb;
            $albums = $wpdb->get_results("SELECT ID, post_name, post_title FROM " . $wpdb->prefix . "posts po 
        LEFT JOIN(SELECT meta_key as album_type, meta_value as mptype, post_id FROM " . $wpdb->prefix . "postmeta
                        WHERE meta_key ='album_type') as pm ON po.ID=pm.post_id 
        WHERE po.post_type = 'mp_album' AND po.post_status ='publish'AND pm.mptype='" . $album_type . "'");

            $al_arr = array();
            foreach ($albums as $album) {
                $al_arr[$album->ID] = $album->post_title;
            }
            return $al_arr;

        }

        public function music_press_pro_song_info($song_info)
        {
            global $wpdb;
            $albums = $wpdb->get_results("SELECT ID, post_name, post_title FROM " . $wpdb->prefix . "posts WHERE post_type = '$song_info' AND post_status ='publish'");
            $al_arr = array();
            foreach ($albums as $album) {
                $al_arr[$album->ID] = $album->post_title;
            }
            return $al_arr;

        }

        public function music_press_pro_add_query_vars_filter($vars)
        {

            $fields = $this->get_registered_fields();

            if ($fields) {
                foreach ($fields as $field) {
                    if ('taxonomy' != $field['type']) {
                        $vars[] = $field['name'];
                    }
                }
            }
            return $vars;

        }

        public function music_press_pro_filter_posts($query)
        {

            if (!is_post_type_archive('mp_song') && (isset($query->query['post_type']) && 'mp_song' != $query->query['post_type'])) {
                return;
            }
            if (!$query->is_main_query()) {
                return;
            }
            if ( is_search() && $query->is_main_query() && $query->get( 's' ) && $query->get( 'post_type' ) ) {

                $query->set('post_type', array(
                    'mp_song',
                    'mp_artist',
                    'mp_band',
                    'mp_album',
                    'mp_genre',
                ));
            }
            $meta_query = array();
            $fields = $this->get_registered_fields();

            if ($fields) {
                foreach ($fields as $field) {

                    $query_var = get_query_var($field['name']);

                    if (empty($query_var) || !is_array($query_var)) {
                        continue;
                    }
                    if ('radio' == $field['type'] || 'checkbox' == $field['type']) {

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

        public function music_press_pro_sync_content_field($post_id)
        {
            // vars
            $fields = false;

            // load from post
            if (isset($_POST['fields'])) {
                $song_type = get_field('song_type', $post_id);
                $field_key = get_field('_content', $post_id);
                $content = '';
                if ($field_key) {

                } else {
                    $content = 0;
                }
                // Update post 37
                $updated_post = array(
                    'ID' => $post_id,
                    'post_content' => $content
                );
                $count_key = 'mp_count_play';
                $count     = (int) get_post_meta( $post_id, $count_key, true );
                if ( $count < 1 ) {
                    delete_post_meta( $post_id, $count_key );
                    add_post_meta( $post_id, $count_key, '0' );
                }
                remove_action('acf/save_post', array($this, 'music_press_pro_sync_content_field'));

                // Update the post into the database
                wp_update_post($updated_post);
                set_post_format($post_id,$song_type);
                add_action('acf/save_post', array($this, 'music_press_pro_sync_content_field'));
            }
        }

        public function get_meta_values($key = '', $type = 'post', $status = 'publish')
        {

            global $wpdb;

            if (empty($key))
                return;

            $r = $wpdb->get_col($wpdb->prepare("
	        SELECT pm.meta_value FROM {$wpdb->postmeta} pm
	        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
	        WHERE pm.meta_key = '%s'
	        AND p.post_status = '%s'
	        AND p.post_type = '%s'
	    ", $key, $status, $type));

            return $r;
        }

        public function music_press_pro_register_field($args)
        {

            // ACF requires a unique key per field so lets generate one
            $key = md5(serialize($args));

            if (empty($args['type'])) {
                $args['type'] = 'number';
            }
            $type = $args['type'];

            if ('taxonomy' == $type) {

                $field = wp_parse_args($args, array(
                    'key' => $key,
                    'label' => '',
                    'name' => '',
                    'type' => 'taxonomy',
                    'instructions' => '',
                    'taxonomy' => '',
                    'field_type' => 'select',
                    'allow_null' => 0,
                    'load_save_terms' => 1,
                    'add_term' => 0,
                    'return_format' => 'id',
                    'multiple' => 0,
                    'sort' => 0,
                    'group' => 'information'
                ));
            } else if ('radio' == $type) {
                $field = wp_parse_args($args, array(
                    'key' => $key,
                    'label' => '',
                    'name' => '',
                    'instructions' => '',
                    'choices' => array(),
                    'other_choice' => 1,
                    'save_other_choice' => 1,
                    'default_value' => '',
                    'layout' => 'horizontal',
                    'sort' => 0,
                    'group' => 'music_file'
                ));
            } else if ('checkbox' == $type) {

                $field = wp_parse_args($args, array(
                    'key' => $key,
                    'label' => '',
                    'name' => '',
                    'instructions' => '',
                    'choices' => array(),
                    'layout' => 'vertical',
                    'sort' => 0,
                    'multiple' => 1,
                    'group' => 'information'
                ));
            } else if ('select' == $type) {

                $field = wp_parse_args($args, array(
                    'key' => $key,
                    'label' => '',
                    'name' => '',
                    'instructions' => '',
                    'choices' => array(),
                    'sort' => 0,
                    'multiple' => 1,
                    'group' => 'information'
                ));
            } else {
                $field = wp_parse_args($args, array(
                    'key' => $key,
                    'label' => '',
                    'name' => '',
                    'type' => 'number',
                    'instructions' => '',
                    'default_value' => '',
                    'placeholder' => '',
                    'prepend' => '',
                    'append' => '',
                    'min' => 0,
                    'max' => '',
                    'step' => '',
                    'sort' => 0,
                    'group' => 'music_file'
                ));
            }
            $field = apply_filters('pcd/register_field', $field);
            $this->fields[$field['name']] = $field;

            return $field;
        }

        public function music_press_pro_register_built_in_fields()
        {

            $built_in_fields = apply_filters('pcd/built_in_fields', $this->built_in);

            if (!empty($built_in_fields)) {
                foreach ($built_in_fields as $field) {
                    $this->music_press_pro_register_field($field);
                }
            }

        }


        public function music_press_pro_register_fields()
        {

            $this->music_press_pro_register_built_in_fields();

            $fields = array();
            $translations = array( // not used anywhere else
                esc_html__('Description', 'music-press-pro'),
                esc_html__('Information', 'music-press-pro'),
                esc_html__('Music File', 'music-press-pro'),
            );

            $layout_groups = array(
                'Description' => array(),
                'Information' => array(),
                'Music File' => array()
            );
            $layout_groups['Description'] = $this->get_registered_fields('description');
            $layout_groups['Description'][] = array(
                'key' => 'field_52910fe7d4efa',
                'label' => esc_html__('Song Description', 'music-press-pro'),
                'name' => 'content',
                'type' => 'wysiwyg',
                'default_value' => '',
                'toolbar' => 'full',
                'media_upload' => 'yes',
                'sort' => 30,
            );
            $layout_groups['Description'][] = array(
                'key' => 'field_52910fe7d4efd',
                'label' => esc_html__('Song Lyric', 'music-press-pro'),
                'name' => 'song_lyric',
                'type' => 'textarea',
                'default_value' => '',
                'sort' => 10,
            );
            $layout_groups['Information'] = $this->get_registered_fields('information');

            $layout_groups['Music File'] = $this->get_registered_fields('music_file');

            foreach ($layout_groups as $label => $field_group) {
                $fields[] = array(
                    'key' => 'tab_' . $label,
                    'label' => $label,
                    'name' => $label,
                    'type' => 'tab',
                );
                foreach ($field_group as $field) {
                    $fields[] = $field;
                };
            };

            if (function_exists("register_field_group")) {
                register_field_group(array(
                    'id' => 'acf_song-data',
                    'title' => esc_html__('Song Data', 'music-press-pro'),
                    'fields' => $fields,
                    'location' => array(
                        array(
                            array(
                                'param' => 'post_type',
                                'operator' => '==',
                                'value' => 'mp_song',
                                'order_no' => 0,
                                'group_no' => 0,
                            ),
                        ),
                    ),
                    'options' => array(
                        'position' => 'normal',
                        'layout' => 'no_box',
                        'hide_on_screen' => array(
                            'the_content', 'custom_fields'
                        ),
                    ),
                    'menu_order' => 0,
                ));
            }
        }

        public function get_registered_fields($group = '')
        {

            $fields = $this->fields;
            $filtered = array();
            $sorted = array();

            foreach ($fields as $key => $field) {
                $fields[$key]['label'] = $field['label'];
            }

            if (!empty($group)) {
                foreach ($fields as $field) {
                    if ($group == $field['group']) {
                        $filtered[] = $field;
                    }
                }
            } else {
                $filtered = $fields;
            }

            foreach ($filtered as $key => $value) {
                $sorted[$key] = $value['sort'];
            }

            array_multisort($sorted, SORT_ASC, SORT_NUMERIC, $filtered);

            return apply_filters('pcd/fields', $filtered);
        }

        public function music_press_pro_register_admin_fields()
        {
            if (function_exists('acf_add_options_sub_page') && function_exists('register_field_group')) {

                acf_add_options_sub_page(array(
                    'title' => esc_html__('Settings', 'music-press-pro'),
                    'parent' => 'music_press',
                    'capability' => 'manage_options'
                ));

                $built_in_fields = $this->built_in;


                $choices = array();
                if (!empty($built_in_fields)) {
                    foreach ($built_in_fields as $field) {
                        $choices[$field['name']] = $field['label'];
                    }
                }

                register_field_group(array(
                    'id' => 'music_press_settings_page',
                    'title' => esc_html__('Settings', 'music-press-pro'),
                    'fields' => array(
                        array(
                            'key' => 'field_52910fcad4ef944',
                            'label' => esc_html__('General', 'music-press-pro'),
                            'name' => '',
                            'type' => 'tab',
                        ),
                        array(
                            'key' => 'field_52910fcad4ef456',
                            'label' => esc_html__('Order By', 'music-press-pro'),
                            'name' => 'global_orderby',
                            'type' => 'select',
                            'sort' => 1,
                            'multiple' => 0,
                            'allow_null' => 0,
                            'choices' => array(
                                'post_date' => esc_html__('Date', 'music-press-pro'),
                                'post_title' => esc_html__('Title', 'music-press-pro'),
                                'mp_count_play' => esc_html__('Plays', 'music-press-pro'),
                            ),
                            'default_value' => 'post_date',
                        ),
                        array(
                            'key' => 'field_52910fcad4ef409',
                            'label' => esc_html__('Order', 'music-press-pro'),
                            'name' => 'global_order',
                            'type' => 'select',
                            'sort' => 2,
                            'multiple' => 0,
                            'allow_null' => 0,
                            'choices' => array(
                                'DESC' => esc_html__('DESC (Descending)', 'music-press-pro'),
                                'ASC' => esc_html__('ASC (Ascending )', 'music-press-pro'),
                            ),
                            'default_value' => 'ASC',
                        ),
                        array(
                            'key' => 'field_52360fcad4ef409',
                            'label' => esc_html__('Limit', 'music-press-pro'),
                            'name' => 'global_limit',
                            'type' => 'number',
                            'class' => 'global_limit',
                            'sort' => 3,
                            'allow_null' => 0,
                            'default_value' => 8,
                            'min' => 1
                        ),

                        array(
                            'key' => 'field_52910fcad4ef190',
                            'label' => esc_html__('Share',  'music-press-pro'),
                            'name' => 'global_share',
                            'type' => 'select',
                            'sort' => 4,
                            'multiple' => 0,
                            'allow_null' => 0,
                            'choices' => array (
                                'enable' => esc_html__( 'Enabled',  'music-press-pro' ),
                                'disable'  => esc_html__( 'Disabled',  'music-press-pro' ),
                            ),
                            'default_value' => 'enable',
                        ),

                        array(
                            'key' => 'field_5293654ad4ef190',
                            'label' => esc_html__('Button Download',  'music-press-pro'),
                            'name' => 'global_download',
                            'type' => 'select',
                            'sort' => 4,
                            'multiple' => 0,
                            'allow_null' => 0,
                            'choices' => array (
                                'true' => esc_html__( 'Show',  'music-press-pro' ),
                                'false'  => esc_html__( 'Hide',  'music-press-pro' ),
                            ),
                            'default_value' => 'show',
                        ),

                        array(
                            'key' => 'field_5293654addfd0',
                            'label' => esc_html__('Music player',  'music-press-pro'),
                            'name' => 'global_music_player',
                            'type' => 'select',
                            'sort' => 5,
                            'multiple' => 0,
                            'allow_null' => 0,
                            'choices' => array (
                                'jplayer' => esc_html__( 'jplayer',  'music-press-pro' ),
                                'wavesurfer'  => esc_html__( 'wave surfer',  'music-press-pro' ),
                            ),
                            'default_value' => 'jplayer',
                        ),

                        array(
                            'key' => 'field_52910fcad4ef955',
                            'label' => esc_html__('Album Setting', 'music-press-pro'),
                            'name' => '',
                            'type' => 'tab',
                        ),
                        array(
                            'key' => 'field_5281609138d88',
                            'label' => esc_html__('AutoPlay', 'music-press-pro'),
                            'name' => 'album_autoplay',
                            'type' => 'radio',
                            'choices' => array(
                                'yes' => esc_html__('Yes', 'music-press-pro'),
                                'no' => esc_html__('No', 'music-press-pro'),
                            ),
                            'other_choice' => 0,
                            'save_other_choice' => 0,
                            'default_value' => 'yes',
                            'layout' => 'horizontal',
                        ),
                        array(
                            'key' => 'field_528160912568',
                            'label' => esc_html__('Order By', 'music-press-pro'),
                            'name' => 'album_orderby',
                            'type' => 'select',
                            'choices' => array(
                                'post_date' => esc_html__('Date', 'music-press-pro'),
                                'post_title' => esc_html__('Title', 'music-press-pro'),
                                'mp_count_play' => esc_html__('Plays', 'music-press-pro'),
                            ),
                            'default_value' => 'post_date',
                        ),
                        array(
                            'key' => 'field_52910fc365f409',
                            'label' => esc_html__('Order', 'music-press-pro'),
                            'name' => 'album_order',
                            'type' => 'select',
                            'sort' => 2,
                            'multiple' => 0,
                            'allow_null' => 0,
                            'choices' => array(
                                'DESC' => esc_html__('DESC (Descending)', 'music-press-pro'),
                                'ASC' => esc_html__('ASC (Ascending )', 'music-press-pro'),
                            ),
                            'default_value' => 'DESC',
                        ),
                        array(
                            'key' => 'field_5281609138d26',
                            'label' => esc_html__('Image Player', 'music-press-pro'),
                            'name' => 'album_image_player',
                            'type' => 'radio',
                            'choices' => array(
                                'image_album' => esc_html__('Album image', 'music-press-pro'),
                                'image_song' => esc_html__('Song image', 'music-press-pro'),
                            ),
                            'other_choice' => 0,
                            'save_other_choice' => 0,
                            'default_value' => 'image_album',
                            'layout' => 'horizontal',
                        ),
                        array(
                            'key' => 'field_5281623138d26',
                            'label' => esc_html__('Show Lyric', 'music-press-pro'),
                            'name' => 'album_lyric',
                            'type' => 'radio',
                            'choices' => array(
                                'yes' => esc_html__('Yes', 'music-press-pro'),
                                'no' => esc_html__('No', 'music-press-pro'),
                            ),
                            'other_choice' => 0,
                            'save_other_choice' => 0,
                            'default_value' => 'yes',
                            'layout' => 'horizontal',
                        ),
                        array(
                            'key' => 'field_528162312566',
                            'label' => esc_html__('Show Comment', 'music-press-pro'),
                            'name' => 'album_comment',
                            'type' => 'radio',
                            'choices' => array(
                                'yes' => esc_html__('Yes', 'music-press-pro'),
                                'no' => esc_html__('No', 'music-press-pro'),
                            ),
                            'other_choice' => 0,
                            'save_other_choice' => 0,
                            'default_value' => 'yes',
                            'layout' => 'horizontal',
                        ),
                        array(
                            'key' => 'field_5281623125896',
                            'label' => esc_html__('Enable Embed', 'music-press-pro'),
                            'name' => 'album_embed',
                            'type' => 'radio',
                            'choices' => array(
                                'yes' => esc_html__('Yes', 'music-press-pro'),
                                'no' => esc_html__('No', 'music-press-pro'),
                            ),
                            'other_choice' => 0,
                            'save_other_choice' => 0,
                            'default_value' => 'yes',
                            'layout' => 'horizontal',
                        ),

                        array(
                            'key' => 'field_52910fcad426955',
                            'label' => esc_html__('Band Setting', 'music-press-pro'),
                            'name' => '',
                            'type' => 'tab',
                        ),
                        array(
                            'key' => 'field_52360band4ef409',
                            'label' => esc_html__('Songs Limit', 'music-press-pro'),
                            'name' => 'band_all_song_limit',
                            'type' => 'number',
                            'class' => 'global_limit',
                            'sort' => 3,
                            'allow_null' => 0,
                            'default_value' => 8,
                            'min' => 1
                        ),
                        array(
                            'key' => 'field_52360band4effd29',
                            'label' => esc_html__('Albums Limit', 'music-press-pro'),
                            'name' => 'band_all_album_limit',
                            'type' => 'number',
                            'class' => 'global_limit',
                            'sort' => 3,
                            'allow_null' => 0,
                            'default_value' => 8,
                            'min' => 1
                        ),
                        array(
                            'key' => 'field_52360bandeef529',
                            'label' => esc_html__('Videos Limit', 'music-press-pro'),
                            'name' => 'band_all_video_limit',
                            'type' => 'number',
                            'class' => 'global_limit',
                            'sort' => 3,
                            'allow_null' => 0,
                            'default_value' => 8,
                            'min' => 1
                        ),
                        array(
                            'key' => 'field_528band12566',
                            'label' => esc_html__('Show Comment', 'music-press-pro'),
                            'name' => 'band_comment',
                            'type' => 'radio',
                            'choices' => array(
                                'yes' => esc_html__('Yes', 'music-press-pro'),
                                'no' => esc_html__('No', 'music-press-pro'),
                            ),
                            'other_choice' => 0,
                            'save_other_choice' => 0,
                            'default_value' => 'yes',
                            'layout' => 'horizontal',
                        ),

                        array(
                            'key' => 'field_52910fc356ef955',
                            'label' => esc_html__('Artist Setting', 'music-press-pro'),
                            'name' => '',
                            'type' => 'tab',
                        ),
                        array(
                            'key' => 'field_52360art4ef409',
                            'label' => esc_html__('Songs Limit', 'music-press-pro'),
                            'name' => 'artist_all_song_limit',
                            'type' => 'number',
                            'class' => 'global_limit',
                            'sort' => 3,
                            'allow_null' => 0,
                            'default_value' => 8,
                            'min' => 1
                        ),
                        array(
                            'key' => 'field_52360art4effd29',
                            'label' => esc_html__('Albums Limit', 'music-press-pro'),
                            'name' => 'artist_all_album_limit',
                            'type' => 'number',
                            'class' => 'global_limit',
                            'sort' => 3,
                            'allow_null' => 0,
                            'default_value' => 8,
                            'min' => 1
                        ),
                        array(
                            'key' => 'field_52360arteef529',
                            'label' => esc_html__('Videos Limit', 'music-press-pro'),
                            'name' => 'artist_all_video_limit',
                            'type' => 'number',
                            'class' => 'global_limit',
                            'sort' => 3,
                            'allow_null' => 0,
                            'default_value' => 8,
                            'min' => 1
                        ),
                        array(
                            'key' => 'field_528art12566',
                            'label' => esc_html__('Show Comment', 'music-press-pro'),
                            'name' => 'artist_comment',
                            'type' => 'radio',
                            'choices' => array(
                                'yes' => esc_html__('Yes', 'music-press-pro'),
                                'no' => esc_html__('No', 'music-press-pro'),
                            ),
                            'other_choice' => 0,
                            'save_other_choice' => 0,
                            'default_value' => 'yes',
                            'layout' => 'horizontal',
                        ),

                        array(
                            'key' => 'field_52910fcad4ff936',
                            'label' => esc_html__('Genre Setting', 'music-press-pro'),
                            'name' => '',
                            'type' => 'tab',
                        ),
                        array(
                            'key' => 'field_52360gen4ef409',
                            'label' => esc_html__('Songs Limit', 'music-press-pro'),
                            'name' => 'genre_all_song_limit',
                            'type' => 'number',
                            'class' => 'global_limit',
                            'sort' => 3,
                            'allow_null' => 0,
                            'default_value' => 8,
                            'min' => 1
                        ),
                        array(
                            'key' => 'field_52360gen4effd29',
                            'label' => esc_html__('Albums Limit', 'music-press-pro'),
                            'name' => 'genre_all_album_limit',
                            'type' => 'number',
                            'class' => 'global_limit',
                            'sort' => 3,
                            'allow_null' => 0,
                            'default_value' => 8,
                            'min' => 1
                        ),
                        array(
                            'key' => 'field_52360geneef529',
                            'label' => esc_html__('Videos Limit', 'music-press-pro'),
                            'name' => 'genre_all_video_limit',
                            'type' => 'number',
                            'class' => 'global_limit',
                            'sort' => 3,
                            'allow_null' => 0,
                            'default_value' => 8,
                            'min' => 1
                        ),

                    ),

                    'location' => array(
                        array(
                            array(
                                'param' => 'options_page',
                                'operator' => '==',
                                'value' => 'acf-options-settings',
                                'order_no' => 0,
                                'group_no' => 0,
                            ),
                        ),
                    ),

                    'options' => array(
                        'position' => 'normal',
                        'layout' => 'no_box',
                        'hide_on_screen' => array(),
                    ),
                    'menu_order' => 0,
                ));

            }
        }
    }
}