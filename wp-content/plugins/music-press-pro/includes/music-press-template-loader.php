<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/**
 * Template Loader
 *
 */
class Music_Press_Pro_Loader {

    /**
     * Hook in methods.
     */
    public function __construct() {
        add_filter( 'template_include', array( __CLASS__, 'music_press_pro_template_loader' ) );
    }

    static function music_press_pro_template_loader( $template ) {

        $find = array( 'music-press.php' );
        $file = '';
        if ( is_single() && get_post_type() == 'mp_song' ) {

            $file 	= 'single-song.php';
            $find[] = $file;
            $find[] =  Music_Press_Pro::music_press_pro_template_path() . $file;

        }
        if ( is_single() && get_post_type() == 'mp_album' ) {

            $file 	= 'single-album.php';
            $find[] = $file;
            $find[] =  Music_Press_Pro::music_press_pro_template_path() . $file;

        }
        if ( is_single() && get_post_type() == 'mp_artist' ) {

            $file 	= 'single-artist.php';
            $find[] = $file;
            $find[] =  Music_Press_Pro::music_press_pro_template_path() . $file;

        }

        if ( is_single() && get_post_type() == 'mp_genre' ) {

            $file 	= 'single-genre.php';
            $find[] = $file;
            $find[] =  Music_Press_Pro::music_press_pro_template_path() . $file;

        }

        if ( is_single() && get_post_type() == 'mp_band' ) {

            $file 	= 'single-band.php';
            $find[] = $file;
            $find[] =  Music_Press_Pro::music_press_pro_template_path() . $file;

        }

        if ( $file ) {
            $template       = locate_template( array_unique( $find ) );
            if ( ! $template ) {
                $template = MUSIC_PRESS_PRO_PLUGIN_DIR . '/templates/' . $file;
            }
        }
        return $template;
    }

}