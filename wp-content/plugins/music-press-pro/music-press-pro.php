<?php
/*
Plugin Name: Music Press Pro
Plugin URI: http://wordpress.templaza.net/plugins/music-press/album/sing-me-to-sleep/
Description: Music Press Plugin help you create and manager your music store. Genre manager, Artist manager, Albums manager. You can create playlist audio and playlist video.
Version: 1.4.6
Author: templaza
Author URI: http://templaza.com/
License: GPLv2 or later
*/
if (!defined('ABSPATH')) exit; // Exit if accessed directly
if (!class_exists('Music_Press_Pro')) {
    class Music_Press_Pro
    {
        public function __construct()
        {
            if (!defined('TZ_MUSIC_PLUGIN_FILE')) {
                define('TZ_MUSIC_PLUGIN_FILE', __FILE__);
            }
            define('MUSIC_PRESS_PRO_PLUGIN_DIR', untrailingslashit(plugin_dir_path(__FILE__)));
            define('MUSIC_PRESS_PRO_PLUGIN_URL', untrailingslashit(plugins_url(basename(plugin_dir_path(__FILE__)), basename(__FILE__))));
            define('MUSIC_PRESS_PRO_PLUGIN_BASENAME', plugin_basename(__FILE__));
            define('TZ_MUSIC_TEMPLATE_DEBUG_MODE', false);
            if (!class_exists('acf_mp') && !defined('ACF_LITE')) {
                define('ACF_LITE', true);

                // Include Advanced Custom Fields
                include('includes/library/acf/acf.php');
            }
            if (!class_exists('acf_options_page_plugin_mp')) {
                include('includes/library/acf-options-page/acf-options-page.php');
            }
            include('includes/library/functions.php');
            include('includes/library/init.php');
            include('includes/music-press-customs.php');
            include('includes/music-press-song-fields.php');
            include('includes/music-press-album-fields.php');
            include('includes/music-press-band-fields.php');
            include('includes/music-press-artist-fields.php');
            include('includes/music-press-genre-fields.php');
            include('includes/music-press-template-loader.php');
            include('includes/music-press-shortcodes.php');
            include('includes/music-press-core-functions.php');
            if (is_admin()) {
                include('includes/admin/music-press-admin.php');
            }
            // Check add-ons install

            $this->customs = new Music_Press_Pro_Customs();
            $this->fields = new Music_Press_Pro_Fields();
            $this->fields = new Music_Press_Pro_Album_Fields();
            $this->fields = new Music_Press_Pro_Band_Fields();
            $this->fields = new Music_Press_Pro_Artist_Fields();
            $this->fields = new Music_Press_Pro_Genre_Fields();
            $this->templates = new Music_Press_Pro_Loader();

            // Activation - works with symlinks

            add_action('admin_init', array($this, 'music_press_pro_updater'));
            add_action('plugins_loaded', array($this, 'music_press_pro_load_plugin_textdomain'));
            add_action('after_setup_theme', array($this, 'include_template_functions'), 11);
            add_action('switch_theme', 'flush_rewrite_rules', 15);
            add_action('wp_enqueue_scripts', array($this, 'music_press_pro_frontend_scripts'));
            add_action('switch_theme', array($this->customs, 'music_press_pro_register_customs'), 10);
//            add_action( 'widgets_init', create_function( "", "include_once( 'includes/music-press-widgets.php' );" ) );

            add_action('wp_ajax_nopriv_music_ajax_action', array($this, 'music_ajax_action'));
            add_action('wp_ajax_music_ajax_action', array($this, 'music_ajax_action'));
            // Ajax list character
            add_action('wp_ajax_nopriv_music_list_character_ajax_action', array($this, 'music_list_character_ajax_action'));
            add_action('wp_ajax_music_list_character_ajax_action', array($this, 'music_list_character_ajax_action'));

            add_action('init', array($this, 'music_press_pro_download_file'));

            function music_press_widget()
            {
                include('includes/music-press-widgets.php');
            }

            add_action('widgets_init', 'music_press_widget');

            if ($this->is_request('frontend')) {
                include_once('includes/music-press-template-hook.php');
            }

        }

        private function is_request($type)
        {
            switch ($type) {
                case 'admin' :
                    return is_admin();
                case 'ajax' :
                    return defined('DOING_AJAX');
                case 'cron' :
                    return defined('DOING_CRON');
                case 'frontend' :
                    return (!is_admin() || defined('DOING_AJAX')) && !defined('DOING_CRON');
            }
        }

        public function music_ajax_action()
        {
            $songID = $_POST['songID'];
            $song_args = array(
                'post_type' => 'mp_song',
                'p' => $songID
            );

            $ajax_song = new WP_Query($song_args);
            if ($ajax_song->have_posts()):
                while ($ajax_song->have_posts()):
                    $ajax_song->the_post();
                    echo balanceTags(get_field('song_lyric'));
                endwhile;
                wp_reset_postdata();
            endif;
            exit();
        }

        public function music_list_character_ajax_action()
        {
            $character = $_POST['character'];
            $column = $_POST['column'];
            $limit = $_POST['limit'];

            ?>
            <h3><?php echo esc_html($character); ?></h3>
            <?php
            $list_songs_array = array();
            $list_songs_query_args = array(
                'post_type' => 'mp_song',
                'post_status' => 'publish',
                'posts_per_page' => -1,
                'orderby' => 'title',
                'order' => 'ASC',
            );
            $list_songs_i = 1;
            $list_songs = new WP_Query($list_songs_query_args);
            if ($list_songs->have_posts()) : while ($list_songs->have_posts()) : $list_songs->the_post();
                $list_songs_i++;
                $ls_title = get_the_title();
                $ls_firstchar = substr($ls_title, 0, 1);


                if (!in_array($ls_firstchar, $list_songs_array)) {
                    array_push($list_songs_array, $ls_firstchar);
                    $list_songs_i = 1;
                }

                if ($character == '#') {

                    if (is_numeric($ls_firstchar)) {
                        ?>
                        <div class="s_item char-<?php echo esc_attr($ls_firstchar); ?> item-<?php echo esc_attr($list_songs_i); ?> col-<?php echo esc_attr($column); ?>">
                            <a href="<?php the_permalink(); ?>"
                               alt="<?php the_title(); ?>"><?php the_title(); ?></a>
                        </div>
                        <?php
                    }

                    ?>

                    <?php

                } else {

                    if ($ls_firstchar == $character) {

                        ?>

                        <?php
                        if (isset($limit) && $limit != '') {
                            if ($list_songs_i <= $limit) {
                                ?>
                                <div class="s_item char-<?php echo esc_attr($ls_firstchar); ?> item-<?php echo esc_attr($list_songs_i); ?> col-<?php echo esc_attr($column); ?>">
                                    <a href="<?php the_permalink(); ?>"
                                       alt="<?php the_title(); ?>"><?php the_title(); ?></a>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="s_item char-<?php echo esc_attr($ls_firstchar); ?> item-<?php echo esc_attr($list_songs_i); ?> col-<?php echo esc_attr($column); ?>">
                                <a href="<?php the_permalink(); ?>"
                                   alt="<?php the_title(); ?>"><?php the_title(); ?></a>
                            </div>
                            <?php
                        }
                        ?>

                        <?php

                    }

                    ?>

                    <?php
                }
            endwhile;
            endif;
            wp_reset_postdata();

            exit();
        }

        public function include_template_functions()
        {
            include_once('includes/music-press-template-functions.php');
            define('MUSIC_PRESS_PRO_TEMPLATE_PATH', $this->music_press_pro_template_path());
        }

        public function music_press_pro_load_plugin_textdomain()
        {
            load_plugin_textdomain('music-press-pro', false, dirname(plugin_basename(__FILE__)) . '/languages/');
        }

        public function music_press_pro_updater()
        {
            include_once('includes/music-press-install.php');
        }

        public function music_press_pro_frontend_scripts()
        {
            //wp_enqueue_style('font-awesome', 'https://use.fontawesome.com/releases/v5.3.1/css/all.css');

            wp_enqueue_style('music-press-PRESS', MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/css/music_press.css');
            wp_enqueue_style('music-press-widgets', MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/css/widgets.css');

            wp_register_script('music-press-jquery.jplayer', MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/js/jquery.jplayer.js', array(), false, true);
            wp_register_script('music-press-jquery.jplayerlist', MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/js/jplayer.playlist.js', array(), false, true);
            wp_register_script('music-press-js', MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/js/music_press.js', array(), false, true);
            wp_register_script('music-press-wave-js', MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/js/wavesurfer.min.js', array(), false, true);

            wp_register_style('music-press-jplayer-blue', MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/css/playlist/blue.monday/css/jplayer.blue.monday.min.css', false);
            wp_register_style('music-press-jplayer-playlist', MUSIC_PRESS_PRO_PLUGIN_URL . '/assets/css/playlist/playlist.css', false);
            $admin_url = admin_url('admin-ajax.php');
            $music_admin_url = array('url' => $admin_url);
            wp_localize_script('music-press-jquery.jplayerlist', 'music_ajax', $music_admin_url);
            wp_localize_script('music-press-js', 'music_list_songs_ajax', $music_admin_url);
        }

        static function music_press_pro_template_path()
        {
            return apply_filters('music_press_template_path', 'music-press-pro/');
        }

        public function music_press_pro_plugin_path()
        {
            return untrailingslashit(plugin_dir_path(TZ_MUSIC_PLUGIN_FILE));
        }

        public function music_press_pro_download_file()
        {

            if (isset($_GET["song_id"]) && isset($_GET['download'])) {
                $this->music_press_pro_send_file();
            }
            if (isset($_GET["album_id"]) && isset($_GET['download'])) {
                $this->music_press_pro_send_allfile();
            }
        }

        public function music_press_pro_send_file()
        {
            //get filedata
            $attID = $_GET['song_id'];
            $file = get_attached_file($attID);
            $fetchurl = explode('/', $file);
            $nameurl = count($fetchurl) - 1;
            $basename = $fetchurl[$nameurl];
            if (file_exists($file) && is_readable($file) && preg_match('/\.mp3$/', $file)) {
                header('Content-type: application/mp3');
                header("Content-Disposition: attachment; filename=\"$basename\"");
                readfile($file);
            } elseif (file_exists($file) && is_readable($file) && preg_match('/\.mp4$/', $file)) {
                header('Content-type: application/octet-stream');
                header("Content-Disposition: attachment; filename=\"$basename\"");
                readfile($file);
            } else {
                header("HTTP/1.0 404 Not Found");
                echo "<h1>Error 404: File Not Found: <br /><em>$file</em></h1>";
            }
            exit();
        }

        public function music_press_pro_send_allfile()
        {
            //get filedata
            $albumID = $_GET['album_id'];
            $orderby = get_option('options_album_orderby', 'post_date');
            $order = get_option('options_album_order', 'DESC');
            $songids = music_press_pro_get_songs_from_album($albumID, $orderby, $order);
            $fileurls = array();
            $fileID = '';
            foreach ($songids as $songid) {
                if (get_field('song_audio', $songid)) {
                    $fileID = get_field('song_audio', $songid);
                    $fileurls[] = get_attached_file($fileID);
                }
                if (get_field('song_audio_cover', $songid)) {
                    $fileID = get_field('song_audio_cover', $songid);
                    $fileurls[] = get_attached_file($fileID);
                }
            }
            $zipname = 'file.zip';
            $zip = new ZipArchive;
            $zip->open($zipname, ZipArchive::CREATE);
            foreach ($fileurls as $file) {
                $fetchurl = explode('/', $file);
                $nameurl = count($fetchurl) - 1;
                $basename = $fetchurl[$nameurl];

                $zip->addFile($nameurl);
            }
            $zip->close();

            header('Content-Type: application/zip');
            header('Content-disposition: attachment; filename=' . $zipname);
            header('Content-Length: ' . filesize($zipname));
            readfile($zipname);
            exit();
        }
    }
}
$GLOBALS['music_press_pro'] = new Music_Press_Pro();