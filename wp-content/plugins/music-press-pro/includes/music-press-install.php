<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

/**
 * Music_Press_Pro_Install
 */
class Music_Press_Pro_Install {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		$this->music_press_pro_default_terms();
	}

	/**
	 * default_terms function.
	 *
	 * @access public
	 * @return void
	 */
	public function music_press_pro_default_terms() {

		if ( get_option( 'music_press_installed_terms' ) == 1 )
			return;

        $album = array(
            'post_title'    => 'Hello Summer',
            'post_content'  => 'Album Hello Summer',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'mp_album'
        );

        $genre = array(
            'post_title'    => 'Dance',
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'mp_genre'
        );

        $band = array(
            'post_title'    => '911',
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'mp_band'
        );

        $artist = array(
            'post_title'    => 'Alan Walker',
            'post_content'  => '',
            'post_status'   => 'publish',
            'post_author'   => 1,
            'post_type'     => 'mp_artist'
        );

// Insert the post into the database.
        wp_insert_post( $album );
        wp_insert_post( $genre );
        wp_insert_post( $band );
        wp_insert_post( $artist );


		update_option( 'music_press_installed_terms', 1 );
	}
}

new Music_Press_Pro_Install();