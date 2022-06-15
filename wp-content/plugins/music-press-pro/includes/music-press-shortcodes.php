<?php

if (!defined('ABSPATH')) exit; // Exit if accessed directly

/**
 * Music_Press_Shortcodes class.
 */
class Music_Press_Pro_Shortcodes
{
    public function __construct()
    {

        add_shortcode('music_press_pro_description', array($this, 'music_press_pro_get_music_description'));
        add_shortcode('music_press_pro_album', array($this, 'music_press_pro_get_music_album'));
        add_shortcode('music_press_pro_artist', array($this, 'music_press_pro_get_music_artist'));
        add_shortcode('music_press_pro_search', array($this, 'music_press_pro_get_music_search'));
        add_shortcode('music_press_pro_list_songs', array($this, 'music_press_pro_get_songs_list_character'));
        add_shortcode('music_press_pro_video_songs', array($this, 'music_press_pro_get_video_songs'));
        add_shortcode('music_press_pro_all_artist', array($this, 'music_press_pro_get_all_artist'));
        if (is_admin()) {
            add_action('init', array($this, 'music_press_pro_setup_tinymce_plugin'));
        }

    }

    public function music_press_pro_setup_tinymce_plugin()
    {

        // Check if the logged in WordPress User can edit Posts or Pages
        // If not, don't register our TinyMCE plugin
        if (!current_user_can('edit_posts') && !current_user_can('edit_pages')) {
            return;
        }

        // Check if the logged in WordPress User has the Visual Editor enabled
        // If not, don't register our TinyMCE plugin
        if (get_user_option('rich_editing') !== 'true') {
            return;
        }

        // Setup some filters
        add_filter('mce_external_plugins', array($this, 'music_press_pro_add_tinymce_plugin'));
        add_filter('mce_external_plugins', array($this, 'music_press_pro_add_tinymce_plugin_artist'));
        add_filter('mce_buttons', array($this, 'music_press_pro_add_tinymce_toolbar_button'));

    }

    public function music_press_pro_add_tinymce_plugin($plugin_array)
    {
        $args = array(
            'post_type' => 'mp_album',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'title'

        );
        $all_albums = get_posts($args);
        ?>
        <div class="album_select" style="display:none;">
            <div class="album-item">
                <label><?php echo esc_html__('Select Album', 'music-press-pro'); ?></label>
                <select class="albums">
                    <?php
                    foreach ($all_albums as $album) : setup_postdata($album); ?>
                        <option value="<?php echo esc_attr($album->ID); ?>"><?php echo esc_html($album->post_title); ?> </option>
                    <?php endforeach;
                    wp_reset_postdata(); ?>
                </select>
            </div>
            <div class="album-item">
                <label><?php echo esc_html__('AutoPlay', 'music-press-pro'); ?></label>
                <select class="album_autoplay">
                    <option value="1"><?php echo esc_html__('Yes', 'music-press-pro'); ?></option>
                    <option value="0"><?php echo esc_html__('No', 'music-press-pro'); ?></option>
                </select>
            </div>

            <div class="album-item">
                <label><?php echo esc_html__('Show Volume', 'music-press-pro'); ?></label>
                <select class="volume">
                    <option value="show"><?php echo esc_html__('Show', 'music-press-pro'); ?></option>
                    <option value="hide"><?php echo esc_html__('Hide', 'music-press-pro'); ?></option>
                </select>
            </div>

            <div class="album-item">
                <label><?php echo esc_html__('Show Repeat', 'music-press-pro'); ?></label>
                <select class="repeat">
                    <option value="show"><?php echo esc_html__('Show', 'music-press-pro'); ?></option>
                    <option value="hide"><?php echo esc_html__('Hide', 'music-press-pro'); ?></option>
                </select>
            </div>

            <div class="album-item">
                <label><?php echo esc_html__('Show Album Poster', 'music-press-pro'); ?></label>
                <select class="poster">
                    <option value="show"><?php echo esc_html__('Show', 'music-press-pro'); ?></option>
                    <option value="hide"><?php echo esc_html__('Hide', 'music-press-pro'); ?></option>
                </select>
            </div>

            <div class="album-item">
                <label><?php echo esc_html__('Song order by', 'music-press-pro'); ?></label>
                <select class="song_orderby">
                    <option value="post_date"><?php echo esc_html__('Date', 'music-press-pro'); ?></option>
                    <option value="post_title"><?php echo esc_html__('Title', 'music-press-pro'); ?></option>
                    <option value="mp_count_play"><?php echo esc_html__('Plays', 'music-press-pro'); ?></option>
                </select>
            </div>

            <div class="album-item">
                <label><?php echo esc_html__('Song order', 'music-press-pro'); ?></label>
                <select class="song_order">
                    <option value="DESC"><?php echo esc_html__('DESC', 'music-press-pro'); ?></option>
                    <option value="ASC"><?php echo esc_html__('ASC', 'music-press-pro'); ?></option>
                </select>
            </div>
        </div>
        <div class="video-songs-select" style="display: none">
            <div class="video-songs-item">
                <label><?php echo esc_html__('Number videos', 'music-press-pro'); ?></label>
                <input type="number" pattern="[0-9]" id="vds-number" value="12"/>
            </div>
            <div class="video-songs-item">
                <label><?php echo esc_html__('Order By', 'music-press-pro'); ?></label>
                <select id="vds-orderby">
                    <option value="title"><?php echo esc_html__('Title', 'music-press-pro'); ?></option>
                    <option value="date"><?php echo esc_html__('Date', 'music-press-pro'); ?></option>
                    <option value="view"><?php echo esc_html__('View', 'music-press-pro'); ?></option>
                </select>
            </div>
            <div class="video-songs-item">
                <label><?php echo esc_html__('Order', 'music-press-pro'); ?></label>
                <select id="vds-order">
                    <option value="DESC"><?php echo esc_html__('DESC', 'music-press-pro'); ?></option>
                    <option value="ASC"><?php echo esc_html__('ASC', 'music-press-pro'); ?></option>
                </select>
            </div>
            <div class="video-songs-item">
                <label><?php echo esc_html__('Show/hide thumbnail', 'music-press-pro'); ?></label>
                <select id="vds-thumbnail">
                    <option value="show"><?php echo esc_html__('Show', 'music-press-pro'); ?></option>
                    <option value="hide"><?php echo esc_html__('Hide', 'music-press-pro'); ?></option>
                </select>
            </div>
            <div class="video-songs-item">
                <label><?php echo esc_html__('Show/hide views', 'music-press-pro'); ?></label>
                <select id="vds-views">
                    <option value="show"><?php echo esc_html__('Show', 'music-press-pro'); ?></option>
                    <option value="hide"><?php echo esc_html__('Hide', 'music-press-pro'); ?></option>
                </select>
            </div>
            <div class="video-songs-item">
                <label><?php echo esc_html__('Number item inline ', 'music-press-pro'); ?></label>
                <select id="vds-nii">
                    <option value="1"><?php echo esc_html__('1', 'music-press-pro'); ?></option>
                    <option value="2"><?php echo esc_html__('2', 'music-press-pro'); ?></option>
                    <option value="3"><?php echo esc_html__('3', 'music-press-pro'); ?></option>
                    <option value="4"><?php echo esc_html__('4', 'music-press-pro'); ?></option>
                </select>
            </div>
        </div>
        <div class="all-artist-select" style="display: none">
            <div class="all-artist-item">
                <label><?php echo esc_html__('Limit Artists', 'music-press-pro'); ?></label>
                <input type="number" id="ar-limit" value="10"/>
            </div>
            <div class="all-artist-item">
                <label><?php echo esc_html__('Order By', 'music-press-pro'); ?></label>
                <select id="ar-orderby">
                    <option value="title"><?php echo esc_html__('Title', 'music-press-pro'); ?></option>
                    <option value="date"><?php echo esc_html__('Date', 'music-press-pro'); ?></option>
                    <option value="view"><?php echo esc_html__('View', 'music-press-pro'); ?></option>
                </select>
            </div>
            <div class="all-artist-item">
                <label><?php echo esc_html__('Order', 'music-press-pro'); ?></label>
                <select id="ar-order">
                    <option value="DESC"><?php echo esc_html__('DESC', 'music-press-pro'); ?></option>
                    <option value="ASC"><?php echo esc_html__('ASC', 'music-press-pro'); ?></option>
                </select>
            </div>
            <div class="all-artist-item">
                <label><?php echo esc_html__('Show/hide Avatar', 'music-press-pro'); ?></label>
                <select id="ar-avatar">
                    <option value="show"><?php echo esc_html__('Show', 'music-press-pro'); ?></option>
                    <option value="hide"><?php echo esc_html__('Hide', 'music-press-pro'); ?></option>
                </select>
            </div>
        </div>
        <?php
        $plugin_array['music_press_pro_shortcode_btn'] = MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/js/shortcode/tinymce-custom-class.js';
        return $plugin_array;

    }

    public function music_press_pro_add_tinymce_plugin_artist($plugin_array)
    {
        $args = array(
            'post_type' => 'mp_artist',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'order' => 'ASC',
            'orderby' => 'title'

        );
        $all_artists = get_posts($args);
        ?>
        <div class="artist_select" style="display:none;">
            <div class="artist-item">
                <label><?php echo esc_html__('Select Artist', 'music-press-pro'); ?></label>
                <select class="artists">
                    <?php
                    foreach ($all_artists as $artist) : setup_postdata($artist); ?>
                        <option value="<?php echo esc_attr($artist->ID); ?>"><?php echo esc_html($artist->post_title); ?> </option>
                    <?php endforeach;
                    wp_reset_postdata(); ?>
                </select>
            </div>

            <div class="artist-item">
                <label><?php echo esc_html__('Show all songs', 'music-press-pro'); ?></label>
                <select class="artist_songs">
                    <option value="show"><?php echo esc_html__('Show', 'music-press-pro'); ?></option>
                    <option value="hide"><?php echo esc_html__('Hide', 'music-press-pro'); ?></option>
                </select>
            </div>

            <div class="artist-item">
                <label><?php echo esc_html__('Show all videos', 'music-press-pro'); ?></label>
                <select class="artist_videos">
                    <option value="show"><?php echo esc_html__('Show', 'music-press-pro'); ?></option>
                    <option value="hide"><?php echo esc_html__('Hide', 'music-press-pro'); ?></option>
                </select>
            </div>

            <div class="artist-item">
                <label><?php echo esc_html__('Show all album', 'music-press-pro'); ?></label>
                <select class="artist_album">
                    <option value="show"><?php echo esc_html__('Show', 'music-press-pro'); ?></option>
                    <option value="hide"><?php echo esc_html__('Hide', 'music-press-pro'); ?></option>
                </select>
            </div>

        </div>
        <div id="list_songs_select" style="display:none;">

            <div class="list-songs-item">
                <label><?php echo esc_html__('Order', 'music-press-pro'); ?></label>
                <select class="list-songs-order">
                    <option value="ASC">ASC</option>
                    <option value="DESC">DESC</option>
                </select>
            </div>

            <div class="list-songs-item">
                <label><?php echo esc_html__('Number items display', 'music-press-pro'); ?></label>
                <input type="text" value="4" class="list_song_number"/>
            </div>
            <label><?php echo esc_html__('Songs column', 'music-press-pro'); ?></label>
            <select class="list-songs-col">
                <option value="1">1 column</option>
                <option value="2">2 column</option>
                <option value="3">3 column</option>
                <option value="4">4 column</option>
            </select>

        </div>
        <?php
        $plugin_array['music_press_pro_shortcode_btn'] = MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/js/shortcode/tinymce-custom-class.js';
        return $plugin_array;

    }

    public function music_press_pro_add_tinymce_toolbar_button($buttons)
    {

        array_push($buttons, 'music_press_pro_shortcode_btn');
        return $buttons;

    }

    public function music_press_pro_get_music_description($post_id = null)
    {
        return get_field('content', $post_id);
    }

    public function music_press_pro_get_music_search($shortcode_atts)
    {
        global $music_press_pro;
        $defaults = array(
            'include' => '',
            'exclude' => '',
            'action' => get_post_type_archive_link('mp_song'), // action url,
            'form' => 'true',
            'button' => __('Search', 'music-press-pro'),
            'form_atts' => ''
        );
        extract(shortcode_atts(apply_filters('mp/searchform/defaults', $defaults), $shortcode_atts));

        $fields = array();
        $includes = array();
        $excludes = array();

        if (!empty($include) && is_string($include)) {
            $includes = explode(',', $include);
        }
        if (!empty($exclude) && is_string($exclude)) {
            $excludes = explode(',', $exclude);
        }
        if ((empty($includes) || in_array('keyword', $includes)) && (!in_array('keyword', $excludes))) {
            $fields['keyword'] = 'keyword';
        }

        add_filter('mp/searchform/fields', array($this, 'music_press_pro_searchform_fields'), 10, 2);

        if (!in_array('button', $excludes)) {
            add_filter('mp/searchform/button', array($this, 'music_press_pro_searchform_button'), 10, 2);
        }

        $html = '';

        if ($form == 'true') {
            $html .= "<form role='search' method='get' action='$action' class='music-search-form' $form_atts>";
        }

        // add the fields
        $html = apply_filters('mp/searchform/fields', $html, $fields);

        // add the button
        $html = apply_filters('mp/searchform/button', $html, $button);

        $html .= '<input type="hidden" name="post_type" value="mp_song">';

        if ($form == 'true') {
            $html .= '</form>';
        }

        return apply_filters('mp/searchform/html', $html, $shortcode_atts);
    }

    public function music_press_pro_searchform_fields($html, $fields)
    {
        foreach ($fields as $field) {
            if ('keyword' == $field) {
                ob_start();
                ?>
                <p class="field field-keyword">
                <label><b><?php _e('Keyword:', 'music-press-pro') ?></b></label><br>
                <input type="search" class="search-field" placeholder="<?php _e('Search ...', 'music-press-pro') ?>"
                       value="<?php echo get_query_var('s') ?>" name="s"/>
                <?php
                $html .= apply_filters('mp/searchform/field/keyword', ob_get_clean(), $field);
            }
        }
        return $html;
    }

    public function music_press_pro_searchform_button($html, $button)
    {
        return $html . "<button class='mp-song-search-submit' id='mp-song-search-submit'>$button</button>";
    }

    public function music_press_pro_get_music_album($shortcode_atts)
    {
        wp_enqueue_style('music-press-jplayer-blue');
        wp_enqueue_script('music-press-jquery.jplayer');
        wp_enqueue_script('music-press-jquery.jplayerlist');
        $image_player = get_option('options_album_image_player', 'image_album');
        $download =get_option('options_global_download','true');
        $defaults = array(
            'album_id' => '',
            'autoplay' => 1,
            'volume' => '',
            'repeat' => '',
            'poster' => '',
            'song_orderby' => '',
            'song_order' => '',
        );
        $album_id = $autoplay = $volume = $repeat = $poster = $song_orderby = $song_order = '';
        extract(shortcode_atts(apply_filters('music_press_pro_album_shortcode', $defaults), $shortcode_atts));
        if ($autoplay == 1) {
            $autoplaycode = 'playlistOptions: {
            autoPlay: true
            },';
        } else {
            $autoplaycode = '';
        }
        $album_type = get_field('album_type', $album_id);
        $song_arr = music_press_pro_get_songs_from_album($album_id, $song_orderby, $song_order);
        $album_image = get_the_post_thumbnail_url($album_id, 'full');
        $album_rand = mt_rand(12, 5214);
        if ($volume == 'show') {
            $vl_html = '
            <div class="jp-volume-controls">
                <button class="jp-mute" role="button" tabindex="0"><i class="off fa fa-volume-off"></i><i class="down fa fa-volume-down"></i></button>
                <div class="jp-volume-bar">
                    <div class="jp-volume-bar-value"></div>
                </div>
                <button class="jp-volume-max" role="button" tabindex="0"><i class="fa fa-volume-up"></i></button>
            </div>
            ';
        } else {
            $vl_html = '';
        }
        if ($repeat == 'show') {
            $rp_html = '
            <div class="jp-toggles">
                <button class="jp-repeat" role="button" tabindex="0"><i class="fa fa-repeat"></i></button>
            </div>
            ';
        } else {
            $rp_html = '';
        }

        if ($album_type == 'audio') {
            $output = '<div class="mp">
				<div class="mp_playlist audio">
                    <div id="album_playlist_container_shortcode' . $album_rand . '" class="jp-audio" role="application" aria-label="media player">
                        <div class="jp-type-playlist">
                            <div class="jp-playlist-head">
                                <div id="album_playlist_shortcode' . $album_rand . '" class="jp-jplayer"></div>
                                <div class="jp-gui jp-interface">
                                    <div class="jp-controls">
                                        <button class="jp-stop" role="button" tabindex="0"><i class="fa fa-stop"></i></button>
                                        <button class="jp-previous" role="button" tabindex="0"><i class="fa fa-step-backward"></i>
                                        </button>
                                        <button class="jp-play" role="button" tabindex="0"><i class="play fa fa-play"></i><i class="pause fa fa-pause"></i></button>
                                        <button class="jp-next" role="button" tabindex="0"><i class="fa fa-step-forward"></i>
                                        </button>
                                    </div>
                                    <div class="jp-progress">
                                        <div class="jp-seek-bar">
                                            <div class="jp-play-bar"></div>
                                        </div>
                                    </div>
                                    <div class="jp-timer">
                                        <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                                        <span class="jp-line">/</span>
                                        <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                                    </div>                                    
                                    ' . $rp_html . '
                                    ' . $vl_html . '
                                </div>
                            </div>
                            <div class="jp-playlist">
                                <ul>
                                    <li>&nbsp;</li>
                                </ul>
                            </div>
                            <div class="jp-no-solution">
                                <span>Update Required</span>
                                To play the media you will need to either update your browser to a recent version or update your
                                <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                            </div>
                        </div>
                    </div>
                </div>
                </div>
			';
            $output .= '
		<script type="text/javascript">
            jQuery(document).ready(function () {

                new jPlayerPlaylist({
                    jPlayer: "#album_playlist_shortcode' . $album_rand . '",
                    cssSelectorAncestor: "#album_playlist_container_shortcode' . $album_rand . '"
                }, [';
            if ($song_arr):
                $mp_count = 1;
                foreach ($song_arr as $song) {
                    $file_type = get_field('song_type', $song);
                    if ($file_type == 'audio') {
                        $mp_count_item = $mp_count;
                        if ($mp_count < 10) {
                            $mp_count_item = '0' . $mp_count;
                        }
                        if (get_field('song_audio', $song)) {
                            $file = get_field('song_audio', $song);
                        }
                        if (get_field('song_audio_cover', $song)) {
                            $file = get_field('song_audio_cover', $song);
                        }
                        $artists = get_field('song_artist', $song);
                        if ($artists != null) {
                            $count = count($artists);
                            $i = 1;
                            $song_artist = '';
                            foreach ($artists as $artist) {
                                if ($i == $count) {
                                    $song_artist .= get_the_title($artist);
                                } else {
                                    $song_artist .= get_the_title($artist) . esc_html__(', ', 'music-press-pro');
                                }
                                $i++;
                            }
                        }
                        if(isset($file)){
                            $url = wp_get_attachment_url( $file );
                        }else{
                            $url = get_field('song_audio_link',$song);
                        }
                        $output .= '{
                        title: "' . balanceTags("<span>" . $mp_count_item . "</span>") . esc_attr(get_the_title($song)) . '",
                        artist:"' . esc_attr($song_artist) . '",
                        mp3: " ' . esc_url($url) . '",
                        free:true,
                        download:" '. esc_attr($download).'",
                        songID:"'.esc_attr($song).'",
                        icondownload:"fa-download",
                        urldl:" ' . esc_url(get_permalink($file)) . '",';
                        if ($poster == 'show') {
                            if ($image_player == 'image_album') {
                                $output .= 'poster: "' . esc_url($album_image) . '",';
                            } else {
                                $output .= 'poster: "' . the_post_thumbnail_url('full') . '",';
                            }
                        }
                        $output .= 'file_id:"' . esc_attr($file) . '"
                            },
                            ';
                        $mp_count++;

                    }
                }
            endif;
            $output .= '
                ], {
                    ' . $autoplaycode . '
                    swfPath: "' . esc_url(MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/js') . '",
                    supplied: "mp3",
                    size: {
                    width: "100%",
                    height: "auto",
                    cssClass: "album-audio"
                        },
                    wmode: "window",
                    useStateClassSkin: true,
                    autoBlur: false,
                    smoothPlayBar: true,
                    keyEnabled: true
                });
            });
        </script>
		';
        }

        if ($album_type == 'video') {
            $has_embed = $has_upload = false;
            foreach ($song_arr as $song_ID){
                $file_source = get_field('song_source',$song_ID);
                if( $file_source != 'embed' ){
                    $has_upload = true;
                }
                if( $file_source == 'embed' ){
                    $has_embed = true;
                }
            }
            if($has_upload) {
                $output = '<div class="mp">
				<div class="mp_playlist video">
                    <div id="jp_container_1' . $album_rand . '" class="jp-video jp-video-270p" role="application" aria-label="media player">
                        <div class="jp-type-playlist">
                            <div class="jp-playlist-head">
                                <div id="jquery_jplayer_1' . $album_rand . '" class="jp-jplayer"></div>
                                <div class="jp-gui">
                                    <div class="jp-video-play">
                                        <button class="jp-video-play-icon" role="button" tabindex="0"><i class="play fa fa-play"></i></button>
                                    </div>
                                    <div class="jp-interface">
                                        <div class="jp-controls">
                                            <button class="jp-stop" role="button" tabindex="0"><i class="fa fa-stop"></i></button>
                                            <button class="jp-previous" role="button" tabindex="0"><i class="fa fa-step-backward"></i>
                                            </button>
                                            <button class="jp-play" role="button" tabindex="0"><i class="play fa fa-play"></i><i class="pause fa fa-pause"></i></button>
                                            <button class="jp-next" role="button" tabindex="0"><i class="fa fa-step-forward"></i>
                                            </button>
                                        </div>
                                        <div class="jp-progress">
                                            <div class="jp-seek-bar">
                                                <div class="jp-play-bar"></div>
                                            </div>
                                        </div>
                                        <div class="jp-timer">
                                            <div class="jp-current-time" role="timer" aria-label="time">&nbsp;</div>
                                            <span class="jp-line">/</span>
                                            <div class="jp-duration" role="timer" aria-label="duration">&nbsp;</div>
                                        </div>
                                        <div class="jp-toggles">
                                            <button class="jp-repeat" role="button" tabindex="0"><i class="fa fa-repeat"></i></button>
                                            <button class="jp-shuffle" role="button" tabindex="0"><i class="fa fa-random"></i></button>
                                            <button class="jp-full-screen" role="button" tabindex="0"><i class="fa fa-arrows-alt"></i></button>
                                        </div>
                                        <div class="jp-volume-controls">
                                            <button class="jp-mute" role="button" tabindex="0"><i class="off fa fa-volume-off"></i><i class="down fa fa-volume-down"></i></button>
                                            <div class="jp-volume-bar">
                                                <div class="jp-volume-bar-value"></div>
                                            </div>
                                            <button class="jp-volume-max" role="button" tabindex="0"><i class="fa fa-volume-up"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="jp-details">
                                <div class="jp-title" aria-label="title">&nbsp;</div>
                            </div>
                            <div class="jp-playlist">
                                <ul>
                                    <!-- The method Playlist.displayPlaylist() uses this unordered list -->
                                    <li>&nbsp;</li>
                                </ul>
                            </div>
                            <div class="jp-no-solution">
                                <span>Update Required</span>
                                To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
                            </div>
                        </div>
                    </div>
                </div>
                </div>
			';
                $output .= '
		<script type="text/javascript">
            jQuery(document).ready(function () {
                new jPlayerPlaylist({
                    jPlayer: "#jquery_jplayer_1' . $album_rand . '",
                    cssSelectorAncestor: "#jp_container_1' . $album_rand . '"
                }, [';
                if ($song_arr):
                    $mp_count = 1;
                    foreach ($song_arr as $song) {
                        $file_type = get_field('song_type', $song);
                        if ($file_type == 'video') {
                            $mp_count_item = $mp_count;
                            if ($mp_count < 10) {
                                $mp_count_item = '0' . $mp_count;
                            }
                            if (get_field('song_video', $song)) {
                                $file = get_field('song_video', $song);
                            }
                            if (get_field('song_video_cover', $song)) {
                                $file = get_field('song_video_cover', $song);
                            }
                            $artists = get_field('song_artist', $song);
                            if ($artists != null) {
                                $count = count($artists);
                                $i = 1;
                                $song_artist = '';
                                foreach ($artists as $artist) {
                                    if ($i == $count) {
                                        $song_artist .= get_the_title($artist);
                                    } else {
                                        $song_artist .= get_the_title($artist) . esc_html__(', ', 'music-press-pro');
                                    }
                                    $i++;
                                }
                            }
                            if ($file) {
                                $url = wp_get_attachment_url($file);
                            } else {
                                $url = get_field('song_video_link', $song);
                            }
                            $output .= '{
                        title: "' . balanceTags("<span>" . $mp_count_item . "</span>") . esc_attr(get_the_title($song)) . '",
                        artist:"' . esc_attr($song_artist) . '",
                        m4v: " ' . esc_url($url) . '",
                        free:true,
                        songID:" ' . esc_attr($song) . '",
                        icondownload:"fa-download",
                        urldl:" ' . esc_url(get_permalink($file)) . '",';
                            if ($poster == 'show') {
                                if ($image_player == 'image_album') {
                                    $output .= 'poster: "' . esc_url($album_image) . '",';
                                } else {
                                    $output .= 'poster: "' . the_post_thumbnail_url('full') . '",';
                                }
                            }
                            $output .= 'file_id:"' . esc_attr($file) . '"
                            },
                            ';
                            $mp_count++;

                        }
                    }
                endif;
                $output .= '
                ], {
                    ' . $autoplaycode . '
                    swfPath: "' . esc_url(MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/js') . '",
                    supplied: "webmv, ogv, m4v",
                    size: {
                    width: "100%",
                    height: "auto",
                    cssClass: "album-audio"
                        },
                    wmode: "window",
                    useStateClassSkin: true,
                    autoBlur: false,
                    smoothPlayBar: true,
                    keyEnabled: true
                });
            });
            
        </script>
		';
            }
            if( $has_embed ){
                $song_playlist = '';
                if($song_arr){
                    $mp_count = 1;
                    foreach ($song_arr as $song){
                        $song_source = get_field('song_source',$song);
                        if( $song_source == 'embed' ){
                            $song_embed = get_field('song_embed_video',$song);
                            if( $mp_count == 1 ){
                                $song_playlist .= music_press_pro_YouTubeGetID( $song_embed );
                            }else{
                                $song_playlist .= ','.music_press_pro_YouTubeGetID( $song_embed );
                            }
                            $mp_count++;
                        }
                    }
                }
                $output = '<div class="mp_playlist video">
                        <div id="player"></div>
                    </div>
                    <script type="text/javascript">
        var tag = document.createElement("script");

        tag.src = "https://www.youtube.com/iframe_api";
        var firstScriptTag = document.getElementsByTagName("script")[0];
        firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
        var player;
        function onYouTubeIframeAPIReady() {
            player = new YT.Player("player", {
                height: "400",
                width: "800",
                playerVars: {
                    autoplay: 0,
                    cc_load_policy: 0,
                    controls: 1,
                    enablejsapi: 1,
                    hl: "en",
                    fs: 1,
                    iv_load_policy: 3,
                    loop: 1,
                    modestbranding: 1,
                    playlist: "'. esc_html($song_playlist).'",
                    playsinline: 1,
                    rel: 0,
                    showinfo: 1
                },
                events: {
                    "onStateChange": function(e) {

                    }
                }
            });
        }
</script>
                    ';
            }
        }

        if($song_arr ){
            $first_songID = $song_arr[0];
            if(get_field('song_lyric',$first_songID)){
                $output .='
                    <div class="mp-lyric">
                        <h3>'. esc_html__('Lyrics', 'music-press-pro') .'</h3>
                        <div class="song-lyric">
                            '. balanceTags(get_field('song_lyric',$first_songID)).'
                        </div>
                    </div>
                    ';
            }
        }else{
            $output.=''. esc_html__('No song in album', 'music-press-pro').'';
        }

        return $output;
    }

    public function music_press_pro_get_music_artist($shortcode_atts)
    {
        $defaults = array(
            'artist_id' => '',
            'artist_songs' => '',
            'artist_videos' => '',
            'artist_album' => '',
        );
        $artist_id = $artist_songs = $artist_videos = $artist_album = '';
        extract(shortcode_atts(apply_filters('music_press_pro_artist_shortcode', $defaults), $shortcode_atts));
        $artist_banner = get_field('artist_banner', $artist_id);
        $artist_banner_url = wp_get_attachment_url($artist_banner);
        $artist_img = get_the_post_thumbnail_url($artist_id, 'post-thumbnail');
        $artist_name = get_the_title($artist_id);

        $type = 'audio';
        $type_video = 'video';
        $limit = get_option('options_global_limit', 8);
        $orderby = get_option('options_global_orderby', 'mp_count_play');
        $order = get_option('global_order', 'DESC');
        $song_arr = music_press_pro_get_songs_from_artist($artist_id, $limit, $orderby, $order, $type);
        $song_arr_video = music_press_pro_get_songs_from_artist($artist_id, $limit, $orderby, $order, $type_video);
        $album_arr = music_press_pro_get_albums_from_artist($artist_id, $limit, $orderby, $order);
        $output = '
        <div class="mp-artist mp-white">
        <div class="artist-info" style="background-image: url(' . $artist_banner_url . ')">
            <div class="info-container">
                    <div class="mp-avatar">
                        <img src="' . $artist_img . '" alt=""/>
                    </div>
                <div class="mp-excerpt">
                    <h4 class="name">' . $artist_name . '</h4>
                    <div class="description">' . esc_html(get_field('artist_short_desc', $artist_id)) . '</div>
                </div>
            </div>
        </div>        
        ';
        if ($song_arr && $artist_songs == 'show') {
            $output .= '
            <div class="mp-list audio"><h2 class="mp-title mp-line">' . esc_attr__('Songs', 'music-press-pro') . '</h2>
            ';
            $output .= '<ul class="all-songs">';
            foreach ($song_arr as $songID) {

                $file_type = get_field('song_type', $songID);
                $song_play = intval(music_press_pro_getPostViews($songID));
                if ($file_type == 'audio') {
                    if (get_field('song_audio', $songID)) {
                        $file = get_field('song_audio', $songID);
                    }
                    if (get_field('song_audio_cover', $songID)) {
                        $file = get_field('song_audio_cover', $songID);
                    }
                    if ($file) {
                        $output .= '
                        <li><a href="' . esc_url(get_permalink($songID)) . '">' . get_the_title($songID) . '</a>
                            <span class="song_plays"><i class="fa fa-headphones"></i> ' . esc_attr($song_play) . '</span>
                        </li>
                        ';
                    }
                }
            }
            $output .= '</ul>';
            $output .= '</div>';
        }

        if ($song_arr_video && $artist_videos == 'show') {
            $output .= '<div class="mp-list video"><h2 class="mp-title mp-line">' . esc_attr__('Videos', 'music-press-pro') . '</h2>';
            $output .= '<div class="list-all">';
            foreach ($song_arr_video as $songID) {
                $song_type = get_field('song_type', $songID);
                if ($song_type == 'video') {
                    if (get_field('song_video', $songID)) {
                        $song = get_field('song_video', $songID);
                    }
                    if (get_field('song_video_cover', $songID)) {
                        $song = get_field('song_video_cover', $songID);
                    }

                    if ($song) {
                        $output .= '
                        <div class="mp-item">
                            <a class="mp-img" href="' . esc_url(get_permalink($songID)) . '" style="background-image:url(' . get_the_post_thumbnail_url($songID, 'large') . ')">
                                <span><i class="fa fa-play"></i></span>
                            </a>
                            <h3><a href="' . esc_url(get_permalink($songID)) . '">' . get_the_title($songID) . '</a></h3>';
                        $artists = get_field('song_artist', $songID);
                        if ($artists != null) {
                            $output .= '<div class="artist">';
                            $count = count($artists);
                            $i = 1;
                            $song_artist = '';
                            foreach ($artists as $artist) {
                                if ($i == $count) {
                                    $song_artist .= get_the_title($artist);
                                    $output .= '<a href="' . get_the_permalink($artist) . '">' . get_the_title($artist) . '</a>';
                                } else {
                                    $song_artist .= get_the_title($artist) . esc_html__(', ', 'music-press-pro');
                                    $output .= '<a href="' . get_the_permalink($artist) . '">' . get_the_title($artist) . '</a>' . esc_html__(', ', 'music-press-pro') . '';
                                }
                                $i++;
                            }
                            $output .= '</div>';
                        }
                        $output .= '</div>';
                    }
                }
            }
            $output .= '</div>';
            $output .= '</div>';

        }

        if ($album_arr && $artist_album == 'show') {
            $output .= '<div class="mp-list albums">
        <h2 class="mp-title mp-line">' . esc_attr__('Albums', 'music-press-pro') . '</h2>';
            $output .= '<div class="list-all">';
            foreach ($album_arr as $albumID) {
                $output .= '
                <div class="mp-item">
                    <a class="mp-img" href="' . esc_url(get_permalink($albumID)) . '" style="background-image:url(' . get_the_post_thumbnail_url($albumID, 'large') . ')"></a>
                    <h3><a href="' . esc_url(get_permalink($albumID)) . '">' . get_the_title($albumID) . '</a></h3>
                    <span>' . get_the_date('Y', $albumID) . '</span>
                </div>
                ';
            }
            $output .= '</div>';
        }

        $output .= '</div>';


        return $output;
    }

    public function music_press_pro_get_songs_list_character($shortcode_atts)
    {
        wp_enqueue_script('music-press-js');
        $defaults = array(
            'sl_postperpage' => '',
            'sl_col' => '',
            'sl_order' => '',
        );
        $sl_postperpage = $sl_col = $sl_order = '';


        extract(shortcode_atts(apply_filters('music_press_pro_list_songs', $defaults), $shortcode_atts));


        $output = '<div class="widget_songs_list">

        <div class="header-content">
        
            <div class="songs-character">
            
                <a class="directional" href="javascript:void(0)" data-col="' . $sl_col . '" data-limit="' . $sl_postperpage . '" data-character="#">#</a>';

        $music_press_range = range('A', 'Z');

        foreach ($music_press_range as $range) {

            $output .= '<a class="directional" href="javascript:void(0)" data-col="' . $sl_col . '" data-limit="' . $sl_postperpage . '" data-character="' . $range . '">' . $range . '</a>';
        }

        $output .= '<a class="directional active" href="javascript:void(0)" data-character="all" data-col="' . $sl_col . '" data-limit="' . $sl_postperpage . '">' . esc_html__('All', 'music-press-pro') . '</a>';

        $output .= '</div></div><div id="ls_content" class="bottom-content">';



        $list_songs_query_args = array(
            'post_type' => 'mp_song',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'orderby' => 'title',
            'order' => $sl_order,
        );

        $list_songs = new WP_Query($list_songs_query_args);
        $ls_count_i = 1;
        $list_songs_array = array();
        if ($list_songs->have_posts()) : while ($list_songs->have_posts()) : $list_songs->the_post();

            $ls_count_i++;

            $ls_title = get_the_title();

            $ls_permalink = get_the_permalink();

            $ls_firstchar = substr($ls_title, 0, 1);

            if (is_numeric($ls_firstchar)) {
                if (!in_array($ls_firstchar, $list_songs_array)) {
                    $output .= '<h3>#</h3>';
                    array_push($list_songs_array, $ls_firstchar);
                    $ls_count_i = 1;
                }
                $output .= '<div class="s_item col-' . $sl_col . '"><a href="' . $ls_permalink . '" alt="' . $ls_title . '">' . $ls_title . '</a> </div>';
            } else {
                if (!in_array($ls_firstchar, $list_songs_array)) {
                    $output .= '<div class="clearfix"></div>';
                    $output .= '<h3 class="' . $ls_count_i . '">' . $ls_firstchar . '</h3>';
                    array_push($list_songs_array, $ls_firstchar);
                    $ls_count_i = 1;
                }
                $list_songs_limit = '';
                if(isset($sl_postperpage) && $sl_postperpage != ''){
                    $list_songs_limit .= $sl_postperpage;
                }else{
                    $list_songs_limit = 9999;
                }
                if($ls_count_i <= $list_songs_limit){
                    $output .= '<div class="s_item col-' . $sl_col . ' count-'.$ls_count_i.'"><a href="' . $ls_permalink . '" alt="' . $ls_title . '">' . $ls_title . '</a> </div>';
                }
            }

        endwhile; endif;

        $output .= '</div></div>';

        return $output;

    }

    public function music_press_pro_get_video_songs($shortcode_atts)
    {
        $defaults = array(
            'vds_novts' => '8',
            'vds_orderby' => 'title',
            'vds_order' => 'DESC',
            'vds_thumbnail' => 'show',
            'vds_views' => 'show',
            'vds_nii' => '1',
        );
        $vds_novts = $vds_orderby = $vds_order = $vds_thumbnail = $vds_views = $vds_nii = '';

        extract(shortcode_atts(apply_filters('music_press_pro_get_video_songs', $defaults), $shortcode_atts));
        global $post;
        $number = '';
        if (isset($vds_novts)) {
            $number .= $vds_novts;
        } else {
            $number = -1;
        }
        $orderby = '';
        if (isset($vds_orderby)) {
            $orderby .= $vds_orderby;
        } else {
            $orderby = 'title';
        }
        $order = '';
        if (isset($vds_order)) {
            $order .= $vds_order;
        } else {
            $order = 'DESC';
        }

        $thumbnail = '';
        if (isset($vds_thumbnail)) {
            $thumbnail .= $vds_thumbnail;
        } else {
            $thumbnail = 'show';
        }

        $displayview = '';
        if (isset($vds_views)) {
            $displayview .= $vds_views;
        } else {
            $displayview = 'show';
        }

        $iteminline = '';
        if (isset($vds_nii)) {
            $iteminline .= $vds_nii;
        } else {
            $iteminline = '4';
        }

        $custom_order = "";
        $metakey = '';
        if ($orderby == 'view') {
            $custom_order = 'meta_value_num';
            $metakey = 'mp_count_play';
        } else {
            $custom_order = $orderby;
        }

        $itemclass = '';
        if ($iteminline == 4) {
            $itemclass = 'w25';
        } elseif ($iteminline == 3) {
            $itemclass = 'w33';
        } elseif ($iteminline == 2) {
            $itemclass = 'w50';
        } else {
            $itemclass = 'w100';
        }
        $query_args = array(
            'post_type' => 'mp_song',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'meta_query' => array(
                array(
                    'key' => 'song_type',
                    'value' => 'video'
                )
            ),
            'order' => $order,
            'orderby' => $custom_order,
            'meta_key' => $metakey,
            'posts_per_page' => $number,

        );

        $videosongs = new WP_Query($query_args);
        ?>
        <div class="videos-song-shortcode">
            <?php
            $vdsc_i = 0;
            if ($videosongs->have_posts()) :
                ?>
                <ul class="mp-list video-songs <?php echo esc_attr($itemclass); ?>">

                    <?php
                    while ($videosongs->have_posts()) : $videosongs->the_post();
                        $vdsc_i++;
                        $songID = get_the_ID();
                        ?>

                        <li class="mp-item item-<?php echo $vdsc_i; ?>">
                            <?php
                            if ($thumbnail == 'show' && has_post_thumbnail($post->ID)):
                                ?>
                                <a class="mp-img"
                                   href="<?php echo get_permalink(); ?>"><?php the_post_thumbnail(array(250, 250), array('class' => 'center')) ?>
                                    <span><i class="fa fa-play"></i></span>
                                </a>
                            <?php endif; ?>
                            <h3>
                                <a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a>
                            </h3>
                            <?php
                            /*  Get Artists */
                            $artists = get_field('song_artist', $songID);
                            if ($artists != null) {
                                echo '<div class="artist">';
                                $count = count($artists);
                                $i = 1;
                                $song_artist = '';
                                foreach ($artists as $artist) {
                                    if ($i == $count) {
                                        $song_artist .= get_the_title($artist);
                                        echo '<a href="' . get_the_permalink($artist) . '">' . get_the_title($artist) . '</a>';
                                    } else {
                                        $song_artist .= get_the_title($artist) . esc_html__(', ', 'music-press-pro');
                                        echo '<a href="' . get_the_permalink($artist) . '">' . get_the_title($artist) . '</a>' . esc_html__(', ', 'music-press-pro');
                                    }
                                    $i++;
                                }
                                echo '</div>';
                            } else {
                                echo '<div class="artist">';
                                echo '<a href="#" title="updating...">' . esc_html__('Updating...', 'music-press-pro') . '</a>';
                                echo '</div>';
                            }
                            ?>
                            <?php if ($displayview == 'show'): ?>
                                <span class="mp-item__view">
                            <?php
                            $view = get_post_meta(get_the_ID(), 'mp_count_play', true);
                            echo esc_html($view) . esc_html__(' views', 'music-press-pro');
                            ?>
                        </span>
                            <?php endif; ?>
                            <div class="clr"></div>
                        </li>

                        <!--Show div.clearfix-->
                        <?php
                        if ($iteminline == 4) {
                            if ($vdsc_i % 4 == 0) {
                                echo '<div class="clearfix"></div>';
                            }
                        } elseif ($iteminline == 3) {
                            if ($vdsc_i % 3 == 0) {
                                echo '<div class="clearfix"></div>';
                            }
                        } elseif ($iteminline == 2) {
                            if ($vdsc_i % 2 == 0) {
                                echo '<div class="clearfix"></div>';
                            }
                        }
                        ?>

                    <?php
                    endwhile;
                    ?>

                </ul>
            <?php endif; ?>
        </div>
        <?php
        return;
    }

    public function music_press_pro_get_all_artist($shortcode_atts)
    {
        $defaults = array(
            'ar_orderby' => 'title',
            'ar_order' => 'DESC',
            'ar_avatar' => 'show',
            'ar_limit' => '-1',
        );
        $ar_orderby = $ar_order = $ar_avatar = $ar_limit = '';

        extract(shortcode_atts(apply_filters('music_press_pro_all_artist', $defaults), $shortcode_atts));

        ?>

        <div class="all-artist-shortcode widget_get_artists">

        <?php
        $query_args = array(

            'post_type' => 'mp_artist',
            'post_status' => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page' => $ar_limit,
            'orderby' => $ar_orderby,
            'order' => $ar_order,
        );

        global $post;

        $artist = new WP_Query($query_args);

        if ($artist->have_posts()) : ?>

            <ul class="mp-list artists">

                <?php while ($artist->have_posts()) : $artist->the_post(); ?>

                    <li class="mp-item">
                        <?php
                        if ($ar_avatar == 'show'):
                            if(has_post_thumbnail($post->ID)):
                                ?>
                                <a class="mp-img"
                                   href="<?php echo get_permalink(); ?>"><?php the_post_thumbnail(array(50, 50), array('class' => 'center')) ?>
                                </a>
                            <?php else: ?>
                                <a class="mp-img"
                                   href="<?php echo get_permalink(); ?>">
                                    <img width="50px" height="50px" src="<?php echo MUSIC_PRESS_PRO_PLUGIN_URL ?>/assets/images/no_avt.png" alt="<?php echo esc_html__('No Avatar','music-press-pro'); ?>"
                                </a>
                            <?php endif; ?>
                        <?php endif; ?>
                        <h3><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h3>
                        <div class="clr"></div>
                    </li>

                <?php endwhile; ?>

            </ul>

        <?php endif;

        wp_reset_postdata();

        ?>

        </div>

            <?php

        return;

    }

}

new Music_Press_Pro_Shortcodes();